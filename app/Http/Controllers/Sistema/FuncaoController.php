<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Sistema\Funcao;
use App\Classes\Constantes\Notificacao;

class FuncaoController extends Controller
{
    public function gerenciarFuncao()
    {
        // $funcoes = Funcao::select('id', 'nome', 'id_funcao_pai')->get();
        $funcoes = Funcao::select('funcao.id','funcao.nome','fp.nome as funcao_pai')
                           ->leftJoin('funcao as fp', 'fp.id', '=', 'funcao.id_funcao_pai')
                           ->paginate(25);


        return view('sistema.funcao.gerenciar', compact('funcoes'));
    }
    
    public function cadastroFuncao()
    {
        $funcoes = Funcao::select('funcao.id','funcao.nome','fp.nome as funcao_pai')
                           ->leftJoin('funcao as fp', 'fp.id', '=', 'funcao.id_funcao_pai')
                           ->paginate(25);

        return view('sistema.funcao.cadastrar' , compact('funcoes'));
    }

    public function cadastrarFuncao(Request $req)
    {
        Funcao::create($req->all());
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.cadastroSucesso", "success");

        return redirect()->back();
    }
    
    public function editarFuncao($id)
    {
        $funcao = Funcao::find($id);

        $funcoes = Funcao::select('funcao.id','funcao.nome','fp.nome as funcao_pai')
                            ->leftJoin('funcao as fp', 'fp.id', '=', 'funcao.id_funcao_pai')
                            ->paginate(25);
        
        return view('sistema.funcao.editar', compact('funcao'), compact('funcoes'));

    }

    public function editaFuncao(Request $req)
    {
        $dados = $req->all();
        Funcao::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        
        return redirect()->back();
    }

    public function removerFuncao($id)
    {
        $funcaopai = Funcao::find($id);
        $validacao = Funcao::where('id_funcao_pai', $funcaopai['id'])->count();

        if ($validacao > 0) {

            Notificacao::gerarAlert("notificacao.erro", "funcao.erro1", "danger");
        } else {
            $delete = Funcao::find($id);
            $delete->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        
        return redirect()->back();       
    }
}
