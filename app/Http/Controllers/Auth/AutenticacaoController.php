<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Session;
use Illuminate\Validation\Rule;
use App\Classes\Constantes\Notificacao;
use App\Http\Controllers\Sistema\FazendaController;


class AutenticacaoController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
            if ($lang_browser == 'pt') {
                Session::put('locale', 'pt-br');
            } else if ($lang_browser == 'es') {
                Session::put('locale', 'es');
            } else {
                Session::put('locale', 'en');
            }
            return view('sistema.usuarios.login');
        }
    }

    public function Signin(Request $req)
    {
        $dados = $req->all();
        if (isset($dados['rememberPassword'])) {
            $remeber = true;
        } else {
            $remeber = false;
        }

        if (User::verificarUserAtivo($dados['email']) && Auth::attempt(['email' => $dados['email'], 'password' => $dados['password']],  $remeber)) {
            Session::put('name', Auth::user()->all());

            Session::put('user_logged', Auth::user());
            $usuario = Session::get('user_logged');

            //Alterando o idioma da página
            $idiomas =  User::getListaDeIdiomas();
            Session::put('locale',  Auth::user()->preferencia_idioma);
            //Adicionando a lista de idiomas a sessão
            Session::put('idiomas', $idiomas);

            $listModules = User::getListModulesPermissions();
            Session::put('listModules', $listModules);
            
            // Coloca a lista de fazendas no menu
            $fazendas = FazendaController::selectFarms();
            Session::put('Lista_Fazendas', $fazendas);
            
            return redirect()->route('dashboard');
        } else {
            redirect()->back()->with('error', __('login.dados_invalidos'), 'danger');
            return redirect()->route('login');
        }
    }

    public function LanguageUpdate($locale){
        //buscar logged user id
        $id_usuario = Auth::user()->id;

        //update language in user table
        User::where('id', $id_usuario)->update( array('preferencia_idioma' => $locale) );
        Session::put('locale', $locale);

        //update list of modules
        $listModules = User::getListModulesPermissions();
        Session::put('listModules', $listModules);

        return redirect()->back();
    }
    
    public function sair()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
