<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogActions;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;
use Session;

class LogActionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //Envia a requisição primeiro e depois volta para o middleware,
        // para que na ação de STORE, já consiga ter o retorno do ID inserido
        $response = $next($request);

        $token = $request->input('_token');

        $item_id = null;
        $farm_id = 0;

        if($token != null && (count($request->all()) > 0) ){
            $agent      = new Agent();
            $device     = $agent->device();             //Get the device name, if mobile. (iPhone, Nexus, AsusTablet, ...)
            $browser    = $agent->browser();            //Get the browser name. (Chrome, IE, Safari, Firefox, ...)
            $platform   = $agent->platform();           //Get the operating system. (Ubuntu, Windows, OS X, ...)
            $version    = $agent->version($platform);   //get the browser or platform version
            $deviceType = $agent->deviceType();         // If is desktop, phone, tablet or robot
            $UserAgent  = $agent->getUserAgent();       // the User-Agent

            $user_id            = Auth::user()->id;     //user id logged
            $user_client_host   = $request->server->get('HTTP_HOST');

            $uri                = $request->path();             //route
            $uri_explode        = explode("/", $uri);
            $uri_explode_count  = count($uri_explode);

            //Se for ENVIAR ENTREGA TÉCNICA, ajusta a captura do módulo
            if($uri_explode[1] == 'commissioning'){
                $module = $uri_explode[1];
            }else{
                $module = $uri_explode[0];
            }

            //$url        = $request->url();
            $method     = $request->method();
            $client_ip  = $request->ip();

            $farm_selected = Session::get('fazenda');
            $farm_id = (isset($farm_selected['id'])) ? (int)$farm_selected['id'] : 0;

            $input = $request->all();

            unset($input['_token']);

            //DELETE
            if($method == "DELETE"){
                $action = 'delete';
                $item_id = (int)$uri_explode[$uri_explode_count-1];
            }
            elseif($method == 'POST' && (
                    $uri_explode[$uri_explode_count-1] == 'save_commissioning'
                ))
            {
                $action = 'store';
                $item_id = (int)Session::get('id_created');
            }
            //UPDATE
            elseif ($method == 'POST' && (
                $uri_explode[$uri_explode_count-1] == 'update' ||
                $uri_explode[$uri_explode_count-1] == 'update_resales' ||
                $uri_explode[$uri_explode_count-2] == 'status' ||
                $uri_explode[$uri_explode_count-2] == 'commissioning'
                ))
            {
                $action = 'update';

                //Se for rota de ATIVAR/DESATIVAR o Usuário
                if($uri_explode[$uri_explode_count-2] == 'status'){
                    //Active or Disable USER
                    $item_id = (int)$uri_explode[$uri_explode_count-1];
                    //Adiciona o Status do usuário ao array do request
                    $input['situacao'] = Session::get('user_status');
                } else {

                    if($uri_explode[$uri_explode_count-2] == 'commissioning' || $uri_explode[$uri_explode_count-1] == 'commissioning'){

                        //Enviar e-mail
                        if($uri_explode[$uri_explode_count - 1] == 'sendConfirmation_complete_commissioning'){
                            $URL_explode = explode("/", URL::previous());
                            $item_id = (int)$URL_explode[count($URL_explode)-1];
                        } else {
                            if($uri_explode[$uri_explode_count - 1] != 'checkCommissioningStatus') {
                                $item_id = (int)$request->input('id_entrega_tecnica');
                            }
                        }

                    } else {
                        $item_id = (int)$request->input('id');
                    }
                }
            }
            //CREATE
            elseif ($method == 'POST' && (
                    $uri_explode[$uri_explode_count-1] == 'save' ||
                    $uri_explode[$uri_explode_count-1] == 'saveOwner' ||
                    $uri_explode[$uri_explode_count-1] == 'save_resales'
                ))
            {
                $action = 'store';
                $item_id = (int)Session::get('id_created');
            } else {
                $action = 'list/filter';
                $item_id = null;
            }

            //Limpa sessão
            Session::forget('id_created');
            Session::forget('user_status');

            $input_json = '';
            if(is_array($input)){
                if(count($input) > 0){
                    $input_json = json_encode($input, JSON_UNESCAPED_UNICODE);
                }
            }

            if($item_id != null){
                LogActions::create(
                    [
                        'farm_id' => $farm_id,
                        'user_id' => $user_id,
                        'uri' => $uri,
                        'method' => $method,
                        'item_id' => $item_id,
                        'action' => $action,
                        'module' => $module,
                        'request_data' => $input_json,
                        'client_host' => $user_client_host,
                        'client_ip' => $client_ip,
                        'client_device_type' => $deviceType,
                        'client_device' => $device,
                        'client_browser' => $browser,
                        'client_platform' => $platform,
                        'client_version' => $version,
                        'client_agent' => $UserAgent
                    ]
                );
            }
        }
        return $response;
    }
}