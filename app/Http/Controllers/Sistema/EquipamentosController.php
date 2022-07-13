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
    public function manageEquipamentos()
    { 

        $equipamentos = Equipamento::select('equipamentos.id', 'equipamentos.id_fazenda', 'equipamentos.nome', 'equipamentos.fabricante', 
            'equipamentos.modelo', 'equipamentos.tipo_equipamento', 'fazendas.nome as nome_fazenda')
            ->join('fazendas', 'fazendas.id', 'equipamentos.id_fazenda')
            ->orderby('nome')
            ->paginate(10);

        return view('sistema.equipamentos.gerenciar', compact('equipamentos'));
    }

    public function createEquipamentos()
    {
        $fazendas = Fazenda::select('fazendas.id', 'fazendas.nome')->orderby('nome')->get();

        $fabricante = Lista::fornecedores();
        $noserie_painel = Lista::getPainel();
        $modelo = Lista::getModeloPivo();
        $altura_equipamento = Lista::getListaAlturaEquipamento();
        $getBalanco = Lista::getBalanco();
        $paineis = Lista::getPainel();
        // $giro = Lista::getGiro();0
        $tipo_equipamento = Lista::getTipoEquipamento();
        // $raio_ultima_torre = Lista::getRaioUltimaTorre();
        // $area = Lista::getArea();
        // $lamina_100 = Lista::getLamina();

        return view('sistema.equipamentos.cadastrar', compact('fazendas', 'fabricante', 'noserie_painel', 'modelo', 'altura_equipamento', 'getBalanco',
                    'paineis', 'tipo_equipamento'));
    }

    public function saveEquipamentos (Request $request)
    {
        $dados = $request->all();
        $novo_equipamento = Equipamento::create($dados);
        // $id = Equipamento::create($request->all())->id;
        // Equipamento::create($request->all());
        // $id = Equipamento::create($req->all())->id;
        // Session::put('id_created', $id);       
        // $id = Equipamento::create($req->all())->id;  //$req->all();
        // dd($id);
        // Session::put('id_created', $id);
        // // $id = Equipamento::create($req->all())->id;
        // Session::put('id_created', $id);

        Notificacao::gerarAlert('', 'comum.cadastro_sucesso', 'success');

        return redirect()->route('manage_equipamentos');
    }

    public function editEquipamentos($id)
    {
        $equipamento = Equipamento::find($id);
        $fazendas = Fazenda::select('fazendas.id', 'fazendas.nome')->orderby('nome')->get();
        $fabricante = Lista::fornecedores();
        $noserie_painel = Lista::getPainel();
        $modelo = Lista::getModeloPivo();
        $altura_equipamento = Lista::getListaAlturaEquipamento();
        $getBalanco = Lista::getBalanco();
        $paineis = Lista::getPainel();
        // $giro = Lista::getGiro();0
        $tipo_equipamento = Lista::getTipoEquipamento();
        // $raio_ultima_torre = Lista::getRaioUltimaTorre();
        // $area = Lista::getArea();
        // $lamina_100 = Lista::getLamina();

        return view('sistema.equipamentos.editar', compact('equipamento', 'fazendas', 'fabricante', 'noserie_painel', 'modelo', 'altura_equipamento', 'getBalanco',
                    'paineis', 'tipo_equipamento'));
    }

    public function updateEquipamento(Request $req)
    {
        $dados = $req->all();
        Equipamento::find($dados['id'])->update($dados);
        Notificacao::gerarAlert('', 'empresa.editar_empresa_sucesso', 'success');
        return redirect()->route('manage_equipamentos');
    }

    public function deleteEquipamentos($id)
    {
        $delete = Equipamento::find($id);
        $delete->delete();
        return redirect()->back();
    }
}