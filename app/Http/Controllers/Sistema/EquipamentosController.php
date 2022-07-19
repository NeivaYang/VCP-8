<?php

namespace App\Http\Controllers\Sistema;

use App\Classes\Comum\Validates;
use App\Http\Controllers\Controller;
use App\Classes\Constantes\Notificacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Classes\Sistema\Equipamento;
use App\Classes\Listas\Lista;
use Illuminate\Support\Facades\Lang;
use App\Classes\Sistema\Fazenda;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Console\Presets\React;
use Session;
use Auth;

class EquipamentosController extends Controller
{
    // To Manage
    public function manageEquipamentos()
    { 
        $equipamentos = Equipamento::select('equipamentos.id', 'equipamentos.id_fazenda', 'equipamentos.nome', 'equipamentos.fabricante', 
            'equipamentos.modelo', 'equipamentos.tipo_equipamento', 'fazendas.nome as nome_fazenda')
            ->join('fazendas', 'fazendas.id', 'equipamentos.id_fazenda')
            ->orderby('nome')
            ->paginate(10);

        //Pegar o nome adequado na lista(lang), concatenar e mosatrar na " view - gerenciar " de usuários.
        foreach($equipamentos as $item) {
            $item->fabricante = __('listas.'.$item->fabricante);
            $item->tipo_equipamento = __('listas.'.$item->tipo_equipamento);

        }

        return view('sistema.equipamentos.gerenciar', compact('equipamentos'));
    }

    // To Create
    public function createEquipamentos()
    {
        $fazendas = Fazenda::select('fazendas.id', 'fazendas.nome')->orderby('nome')->get();

        //Pegar o valor de cada variável na lista(model).
        $fabricante = Lista::fornecedores();
        $noserie_painel = Lista::getPainel();
        $modelo = Lista::getModeloPivo();
        $altura_equipamento = Lista::getListaAlturaEquipamento();
        $getBalanco = Lista::getBalanco();
        $paineis = Lista::getPainel();
        $tipo_equipamento = Lista::getTipoEquipamento();
        
        /*
        $giro = Lista::getGiro();
        $raio_ultima_torre = Lista::getRaioUltimaTorre();
        $area = Lista::getArea();
        $lamina_100 = Lista::getLamina();
        */

        return view('sistema.equipamentos.cadastrar', compact('fazendas', 'fabricante', 'noserie_painel', 'modelo', 'altura_equipamento', 'getBalanco',
                    'paineis', 'tipo_equipamento'));
    }

    // To Save
    public function saveEquipamentos (Request $request)
    {
        $dados = $request->all();
        $novo_equipamento = Equipamento::create($dados);
        Notificacao::gerarAlert('', 'comum.cadastro_sucesso', 'success');

        return redirect()->route('manage_equipamentos');
    }

    // To Edit
    public function editEquipamentos($id)
    {
        //Pegar o valor de cada variável na lista(model).
        $equipamento = Equipamento::find($id);
        $fazendas = Fazenda::select('id', 'nome')->orderby('nome')->get();
        $fabricante = Lista::fornecedores();
        $noserie_painel = Lista::getPainel();
        $modelo = Lista::getModeloPivo();
        $altura_equipamento = Lista::getListaAlturaEquipamento();
        $getBalanco = Lista::getBalanco();
        $paineis = Lista::getPainel();
        $tipo_equipamento = Lista::getTipoEquipamento();

        /*
        $giro = Lista::getGiro();
        $raio_ultima_torre = Lista::getRaioUltimaTorre();
        $area = Lista::getArea();
        $lamina_100 = Lista::getLamina();
        */

        return view('sistema.equipamentos.editar', compact('equipamento', 'fazendas', 'fabricante', 'noserie_painel', 'modelo', 'altura_equipamento', 'getBalanco',
                    'paineis', 'tipo_equipamento'));
    }

    // To Update
    public function updateEquipamentos(Request $req)
    {
        $dados = $req->all();
        Equipamento::find($dados['id'])->update($dados);
        Notificacao::gerarAlert('', 'empresa.editar_empresa_sucesso', 'success');
        return redirect()->route('manage_equipamentos');
    }

    // To Delete
    public function deleteEquipamentos($id)
    {
        $delete = Equipamento::find($id);
        $delete->delete();
        return redirect()->back();
    }
}