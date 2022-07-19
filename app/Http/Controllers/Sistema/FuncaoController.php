<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Sistema\Funcao;
use App\Classes\Constantes\Notificacao;

class FuncaoController extends Controller
{
    // To Mange
    public function gerenciarFuncao()
    {
        //Trazer os dados e associar o valor da função pai associado à função filha
        $funcoes = Funcao::select('funcao.id','funcao.nome','fp.nome as funcao_pai')
                           ->leftJoin('funcao as fp', 'fp.id', '=', 'funcao.id_funcao_pai')
                           ->paginate(25);


        return view('sistema.funcao.gerenciar', compact('funcoes'));
    }
    
    // To Search
    public function searchFuncao(Request $request) 
    {
        $funcoes = [];
        
        if (empty($request['filter'])) {
            $funcoes = Funcao::select('id', 'nome', 'id_funcao_pai')
            ->where(function ($query) use ($request){
                if (!empty($request['filter'])) {
                    $query->orWhere('nome', 'like', '%'.$request['filter'].'%')
                        ->orWhere('id_funcao_pai', 'like', '%'.$request['filter'].'%');
                }
            })->paginate(10);
        }else {
            $funcoes = Funcao::select('id', 'nome', 'id_funcao_pai')->orderBy('created_at')
            ->where(function ($query) use ($request){
                if (!empty($request['filter'])) {
                    $query->orWhere('nome', 'like', '%'.$request['filter'].'%')
                        ->orWhere('id_funcao_pai', 'like', '%'.$request['filter'].'%');
                }
            })->paginate(10);
        }
    }

    // To Create
    public function cadastroFuncao()
    {
        //Trazer os dados e associar o valor da função pai associado à função filha
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
    
    //To Edit
    public function editarFuncao($id)
    {
        $funcao = Funcao::find($id);

        //Trazer o os dados e associar o valor da função pai à função filha
        $funcoes = Funcao::select('funcao.id','funcao.nome','fp.nome as funcao_pai')
                            ->leftJoin('funcao as fp', 'fp.id', '=', 'funcao.id_funcao_pai')
                            ->paginate(25);
        
        return view('sistema.funcao.editar', compact('funcao'), compact('funcoes'));

    }

    // To Update
    public function editaFuncao(Request $req)
    {
        $dados = $req->all();
        Funcao::find($dados['id'])->update($dados);
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        
        return redirect()->back();
    }

    // To Delete
    public function removerFuncao($id)
    {
        $funcaopai = Funcao::find($id);
        
        //Validar para saber se a função é pai de outra função filha
        $validacao = Funcao::where('id_funcao_pai', $funcaopai['id'])->count();

        //Se for pai de outra função não será possível deletar
        if ($validacao > 0) {

            Notificacao::gerarAlert("notificacao.erro", "funcao.erro1", "danger");
        // Se não houver associação pai-filha com outra função será possível realizar a exclusão
        } else { 
            $delete = Funcao::find($id);
            $delete->delete();
            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        }
        
        return redirect()->back();       
    }

}
