<?php

namespace App\Http\Controllers\Sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Constantes\Notificacao;
use Illuminate\Support\Facades\DB;
use App\Classes\Sistema\Empresa;
use Session;
use Auth;
use App\Classes\Sistema\CountryLanguage;

class EmpresaController extends Controller
{
    // To Manage
    public function managerEmpresa()
    {
        $manager_empresa = Empresa::select('id', 'nome', 'telefone', 'email', 'tipo', 'id_country as pais', 'cidade', 'estado') 
            ->orderby('nome', 'ASC')
            ->paginate(10);
        $codeLang = 0;
        $userLang = Auth::user()->preferencia_idioma;
        if ($userLang == 'pt-br') {
            $userLang  = 1;
        }
        else if ($userLang == 'en') {
            $userLang  = 2;
        }
        else if ($userLang == 'es') {
            $userLang  = 3;
        }

        foreach ($manager_empresa as $item) {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')
                                    ->where('id_language', $userLang)
                                    ->where('id_country', $item->pais)
                                    ->get();
            $item->pais = $countries[0]['name'];
            if ( $item->tipo == 'corporation' ) {
                $item->tipo = __('empresa.corporation');
            } 
            else {
                $item->tipo = __('empresa.dealer');
            }
        }
    
        return view('sistema.empresa.gerenciar', compact('manager_empresa'));
    }
    
    // To Search
    public function searchEmpresa(Request $request) 
    {
        $empresa = [];
        
        if (empty($request['filter'])) {
            $empresa = Empresa::select('id', 'nome', 'telefone', 'email')
            ->where(function ($query) use ($request){
                if (!empty($request['filter'])) {
                    $query->orWhere('nome', 'like', '%'.$request['filter'].'%')
                        ->orWhere('telefone', 'like', '%'.$request['filter'].'%')
                        ->orWhere('email', 'like', '%'.$request['filter'].'%');
                }
            })->paginate(10);
        }else {
            $empresa = Empresa::select('id', 'nome', 'telefone', 'email')->orderBy('created_at')
            ->where(function ($query) use ($request){
                if (!empty($request['filter'])) {
                    $query->orWhere('nome', 'like', '%'.$request['filter'].'%')
                        ->orWhere('telefone', 'like', '%'.$request['filter'].'%')
                        ->orWhere('email', 'like', '%'.$request['filter'].'%');
                }
            })->paginate(10);
        }
    }

    //To Create
    public function createEmpresa()
    {
        $userLang = Auth::user()->preferencia_idioma;

        if ($userLang == 'pt-br') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 1)->get();
        }
        else if ($userLang == 'en') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 2)->get();
        }
        else if ($userLang == 'es') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 3)->get();
        }
        return view('sistema.empresa.cadastrar' , compact('countries'));
    
    }

    // To Save
    public function saveEmpresa(Request $req)
    {
        $dados = $req->all();
        $id = Empresa::create($req->all())->id;
        Session::put('id_created', $id);
        Notificacao::gerarAlert('', 'empresa.cadastro_empresa_sucesso', 'success');
        return redirect()->route('manager_empresa');
    }

    // To Edit
    public function editEmpresa($id)
    {
        $empresa = Empresa::find($id);
        
        $userLang = Auth::user()->preferencia_idioma;

        if ($userLang == 'pt-br') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 1)->get();
        }
        else if ($userLang == 'en') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 2)->get();
        }
        else if ($userLang == 'es') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 3)->get();
        }

        return view('sistema.empresa.editar', compact('empresa'), compact('countries'));
        
    }

    // To Update
    public function updateEmpresa(Request $req)
    {
        $dados = $req->all();
        Empresa::find($dados['id'])->update($dados);
        Notificacao::gerarAlert('', 'empresa.editar_empresa_sucesso', 'success');
        return redirect()->route('manager_empresa');
    }

    // To Delete
    public function delete($id)
    {
        $delete = Empresa::find($id);
        $delete->delete();
        return redirect()->route('manager_empresa')->with('Sucesso', 'Foi deletado');
    }
}
