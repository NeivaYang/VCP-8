<?php

namespace App\Http\Controllers\Sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Session;
use App\Classes\Sistema\CentroDeCusto;
use App\Classes\Sistema\UserSuperior;
use App\Classes\Sistema\CdcUsuario;
use App\Classes\Constantes\Notificacao;
use App\Classes\Sistema\UserPermissions;
use App\Classes\Sistema\TypeUserPermissions;
use App\Classes\Sistema\RolesDefautPermissions;
use App\Classes\Sistema\ModulePermissions;
use App\Classes\Sistema\Country;
use App\Classes\Sistema\CountryLanguage;
use App\Classes\Sistema\ModuleLanguage;
use App\Classes\Sistema\Empresa;
use App\Classes\Sistema\Funcao;

class UsuarioController extends Controller
{

    public function managerUsuarios(Request $req)
    {
        $func_emp = user::select('id_empresa', 'id_funcao');
        $filtro = $req->all();
        $usar_filtro = False;
        if (isset($filtro['filtro'])) {
            $usar_filtro = True;
        }

        $listaUsuarios = [];
        $listaPapeis = User::getListaDePapeis();
        $idiomas = User::getListaDeIdiomas();
        $papeis = User::getListaDePapeis();
        if (Auth::User()->tipo_usuario != 0) {
            unset( $papeis[0]);
            unset( $papeis[1]);
            if($usar_filtro) {
                // Trazer os dados para da tabela User $listaUsuarios associando o nome da empresa e da função aos campos id_empresa e id_função na tabela
                $listaUsuarios = User::select('users.id', 'users.nome', 'users.telefone', 'users.pais', 'users.tipo_usuario', 'users.email', 'users.situacao',
                                            'users.id_empresa', 'users.id_funcao', 'empresa.nome as nome_empresa', 'funcao.nome as nome_funcao')
                                        ->leftjoin('empresa', 'empresa.id', 'users.id_empresa')
                                        ->leftjoin('funcao', 'funcao.id', 'users.id_funcao')
                                        ->where(function ($query) use ($filtro) {
                                            //Busca pelo nome
                                            if(!empty($filtro['users.nome'])){
                                                $query->where('users.nome', 'like', '%'.$filtro['users.nome'].'%');
                                            }
                                            //Busca pelo tipo de usuário
                                            if(!empty($filtro['users.tipo_usuario'])){
                                                $query->where('users.tipo_usuario', ($filtro['users.tipo_usuario'] - 100));
                                            }
                                            //Busca apenas ativos
                                            if(!empty($filtro['users.ativo']) && empty($filtro['users.inativo'])){
                                                $query->where('situacao', 1);
                                            }
                                            //Busca apenas inativos
                                            if(empty($filtro['users.ativo']) && !empty($filtro['users.inativo'])){
                                                $query->where('users.situacao',  0);
                                            }
                                        })
                                        ->paginate(10);

            } else {
                // Trazer os dados para da tabela User $listaUsuarios associando o nome da empresa e da função aos campos id_empresa e id_função na tabela
                $listaUsuarios = User::select('users.id','users.nome', 'users.telefone', 'users.pais', 'users.tipo_usuario', 'users.email', 'users.situacao', 'users.id_empresa', 'users.id_funcao',
                                            'empresa.nome as nome_empresa', 'funcao.nome as nome_funcao')
                                        ->leftjoin('empresa', 'empresa.id', 'users.id_empresa')
                                        ->leftjoin('funcao', 'funcao.id', 'users.id_funcao')
                                        ->where('users.tipo_usuario', '!=', 0)->where('users.tipo_usuario', '!=', 1)->orderBy('users.created_at')->paginate(10);
            }
        } else {
            if ($usar_filtro) {
                // Trazer os dados para da tabela User $listaUsuarios associando o nome da empresa e da função aos campos id_empresa e id_função na tabela
                $listaUsuarios = User::select('users.id','users.nome', 'users.telefone', 'users.pais', 'users.tipo_usuario', 'users.email', 'users.situacao', 'users.id_empresa', 'users.id_funcao',
                                            'empresa.nome as nome_empresa', 'funcao.nome as nome_funcao')   
                                            ->leftjoin('empresa', 'empresa.id', 'users.id_empresa')
                                            ->leftjoin('funcao', 'funcao.id', 'users.id_funcao')
                                            ->orderBy('users.created_at')
                                            ->where(function ($query) use ($filtro) {
                                                //Busca pelo nome
                                                if (!empty($filtro['users.nome'])) {
                                                    $query->where('users.nome', 'like', '%'.$filtro['users.nome'].'%');
                                                }
                                                //Busca pelo tipo de usuário
                                                if (!empty($filtro['users.tipo_usuario'])) {
                                                    $query->where('users.tipo_usuario', ($filtro['users.tipo_usuario'] - 100));
                                                }
                                                //Busca apenas ativos
                                                if (!empty($filtro['users.ativo']) && empty($filtro['users.inativo'])) {
                                                    $query->where('users.situacao', 1);
                                                }
                                                //Busca apenas inativos
                                                if (empty($filtro['users.ativo']) && !empty($filtro['users.inativo'])) {
                                                    $query->where('users.situacao',  0);
                                                }
                                            })
                                            ->paginate(10);
            } else {
                // Trazer os dados para da tabela User $listaUsuarios associando o nome da empresa e da função aos campos id_empresa e id_função na tabela
                $listaUsuarios = User::select('users.id','users.nome', 'users.telefone', 'users.pais', 'users.tipo_usuario', 'users.email', 'users.situacao', 'users.id_empresa', 'users.id_funcao',
                                            'empresa.nome as nome_empresa', 'funcao.nome as nome_funcao')
                                        ->leftjoin('empresa', 'empresa.id', 'users.id_empresa')
                                        ->leftjoin('funcao', 'funcao.id', 'users.id_funcao')
                                        ->orderBy('users.created_at')->paginate(10);
            }
        }
        //dd($listaUsuarios);
        $cdcs = CentroDeCusto::all();
        foreach($cdcs as $cdc) {
            $cdc['nome'] =( $cdc['codigo'] . " - " . $cdc['nome']);
        }
        
        // Usuários para o field de superior no cadastro/edição de usuários
        $usuarios_superiores = User::select('users.nome', 'users.id', 'users.tipo_usuario', 'users.id_empresa', 'users.id_funcao')
            ->where('situacao', '1')->where('users.tipo_usuario', '!=', '0')->where('users.tipo_usuario', '!=', '4')
            ->orderBy('users.nome', 'asc')->get();

        //Alterando as chaves de idioma e papel para strings
        foreach($listaUsuarios as $user) {
            $user->tipo_usuario = __($listaPapeis[$user->tipo_usuario]['valor']);
            if ($user->situacao == 0) {
                $user->situacao = __('usuarios.inativo');
            } else {
                $user->situacao = __('usuarios.ativo');
            }
        }

        Session::put('nome_usuario', $listaUsuarios['nome']);
        // return view('sistema.usuarios.gerenciar', compact('listaUsuarios', 'idiomas', 'papeis', 'usuarios_superiores', 'cdcs', 'filtro'));
        return view('sistema.usuarios.gerenciar', compact('listaUsuarios'));
    }

    public function searchUser(Request $request) 
    {
        $listaUsuarios = [];
        $listaPapeis = User::getListaDePapeis();

        if (Auth::User()->tipo_usuario != 0) {
            $listaUsuarios = User::select('id','nome', 'telefone', 'pais', 'tipo_usuario', 'email', 'situacao', 'id_empresa', 'id_funcao')
            ->where('tipo_usuario', '!=', 0)->where('tipo_usuario', '!=', 1)->orderBy('created_at')
            ->where(function ($query) use ($request) {
                if (!empty($request['filter'])) {
                    $query->orWhere('nome', 'like', '%'.$request['filter'].'%')
                        ->orWhere('telefone', 'like', '%'.$request['filter'].'%')
                        ->orWhere('email', 'like', '%'.$request['filter'].'%');
                }
            })->paginate(10);
        } else {
            // dd($request['filter']);
            $listaUsuarios = User::select('id','nome', 'telefone', 'pais', 'tipo_usuario', 'email', 'situacao', 'id_empresa', 'id_funcao')->orderBy('created_at')
            ->where(function ($query) use ($request) {
                if (!empty($request['filter'])) {
                    $query->orWhere('nome', 'like', '%'.$request['filter'].'%')
                        ->orWhere('telefone', 'like', '%'.$request['filter'].'%')
                        ->orWhere('email', 'like', '%'.$request['filter'].'%');
                }
            })->paginate(10);
        }

        //Alterando as chaves de idioma e papel para strings
        foreach($listaUsuarios as $user) {
            $user->tipo_usuario = __($listaPapeis[$user->tipo_usuario]['valor']);
            if ($user->situacao == 0) {
                $user->situacao = __('usuarios.inativo');
            } else {
                $user->situacao = __('usuarios.ativo');
            }
        }

        return view('sistema.usuarios.gerenciar', compact('listaUsuarios'));
    }

    public function UserChangeStatus($id)
    {

        $usuarios = user::find($id);
        $situacao = ($usuarios['situacao']) ? 0 : 1;

        User::where('id', $id)->update( array('situacao' => $situacao) );
        Session::put('user_status', $situacao);

        return redirect()->back();
    }

    public function createUsuario()
    {
        $funcoes = Funcao::select('id','nome')->orderby('nome')->get();
        
        $empresas = Empresa::select('id','nome')->orderby('nome')->get();

        //dd($funcoes, $empresas);
        //Obtendo a lista de papéis do sistema
        $papeis = User::getListaDePapeis();
        $idiomas = User::getListaDeIdiomas();
        $cdcs = CentroDeCusto::all();
        $rolesList = User::getRolesList();
        $modules = ModulePermissions::select('id', 'name')->get();
        $typeUsers = TypeUserPermissions::select('name')->get();
        $userLang = Auth::user()->preferencia_idioma;

        if ($userLang == 'pt-br') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 1)->get();
            $modulesLang = ModuleLanguage::select('id_module', 'id_language', 'description')->where('id_language', 1)->get();
        }
        else if ($userLang == 'en') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 2)->get();
            $modulesLang = ModuleLanguage::select('id_module', 'id_language', 'description')->where('id_language', 2)->get();
        }
        else if ($userLang == 'es') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 3)->get();
            $modulesLang = ModuleLanguage::select('id_module', 'id_language', 'description')->where('id_language', 3)->get();
        }

        foreach ($cdcs as $cdc) {
            $cdc['nome'] = ($cdc['codigo'] . " - " . $cdc['nome']);
        }

        $listaPapeis = User::getListaDePapeis();
        $listaUsuarios = User::select('id', 'nome', 'telefone', 'pais', 'tipo_usuario', 'email', 'situacao')
            ->where('tipo_usuario', '!=', 0)->where('tipo_usuario', '!=', 1)->orderBy('created_at');

        // Usuários para o field de superior no cadastro/edição de usuários
        $usuarios_superiores = User::select('nome', 'id', 'tipo_usuario')
            ->where('situacao', '1')->where('tipo_usuario', '!=', '0')->where('tipo_usuario', '!=', '4')
            ->orderBy('nome', 'asc')->get();

        //Alterando as chaves de idioma e papel para strings
        foreach ($listaUsuarios as $user) {
            $user->tipo_usuario = __($listaPapeis[$user->tipo_usuario]['valor']);
            if ($user->situacao == 0) {
                $user->situacao = __('usuarios.inativo');
            } else {
                $user->situacao = __('usuarios.ativo');
            }
        }

        return view('sistema.usuarios.cadastrar', compact('funcoes', 'empresas', 'papeis', 'idiomas', 'cdcs', 'countries', 'usuarios_superiores', 'modules', 'typeUsers', 'rolesList', 'modulesLang'));
    }

    public function saveUsuario(Request $req)
    {
        $dados = $req->all();
        $token = $dados['_token'];

        //Medida provisória para flag de pendência de -email
        $dados['email_verified_at'] = time();

        $verifica =  DB::table('users')->where('email', $dados['email'])->first();
        if (!empty($verifica)) {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->back();
        }
        else {
            $dados['password'] = bcrypt($dados['password']);

            $id_user = User::create($dados);
    
            for($i = 0; $i < count($dados['id_module']); $i++) {
                $createItem = array(
                    '_token' => $token,
                    'id_user' => $id_user['id'],
                    'id_module' => $dados['id_module'][$i],
                    'permissions' => $dados['permissions'][$i]
                );

                UserPermissions::create($createItem);
                unset($createItem);
            }
    
            if ($dados['tipo_usuario'] == 2) {
                UserSuperior::inserirSuperior($id_user['id'], $dados['superior_s']);
            } else if ($dados['tipo_usuario'] == 3) {
                UserSuperior::inserirSuperior($id_user['id'], $dados['superior_c']);
            } else if ($dados['tipo_usuario'] == 4) {
                UserSuperior::inserirSuperior($id_user['id'], $dados['superior_a']);
            }

            if ($dados['tipo_usuario'] != 0) {
                CdcUsuario::inserirRelacionamentosCdcUsuario($id_user['id'], $dados['cdcs']);
            }        
            
            Session::put('id_created', $id_user['id']);
            Notificacao::gerarAlert('', 'usuarios.cadastro_usuario_sucesso', 'success');
            return redirect()->route('usuarios_manager')->with('Notificacao');    
        }
    }

    public function editUsuarios($id)
    {
        $funcoes = Funcao::select('id','nome')->orderby('nome')->get();
        
        $empresas = Empresa::select('id','nome')->orderby('nome')->get();
        
        //Obtendo a lista de papéis do sistema
        $usuarios = user::find($id);
        $papeis = User::getListaDePapeis();
        $idiomas = User::getListaDeIdiomas();
        $cdcs = CentroDeCusto::all();
        $rolesList = User::getRolesList();
        $modules = ModulePermissions::select('id', 'name')->get();
        $typeUsers = TypeUserPermissions::select('name')->where('id', $id)->get();
        $userPermissions = UserPermissions::select('id_module', 'permissions')->where('id_user', $id)->get();
        //$userPermissions = UserPermissions::select
        $userLang = Auth::user()->preferencia_idioma;

        if ($userLang == 'pt-br') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 1)->get();
            $modulesLang = ModuleLanguage::select('id_module', 'id_language', 'description')->where('id_language', 1)->get();
        }
        else if ($userLang == 'en') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 2)->get();
            $modulesLang = ModuleLanguage::select('id_module', 'id_language', 'description')->where('id_language', 2)->get();
        }
        else if ($userLang == 'es') {
            $countries  = CountryLanguage::select('id_country', 'id_language', 'name')->where('id_language', 3)->get();
            $modulesLang = ModuleLanguage::select('id_module', 'id_language', 'description')->where('id_language', 3)->get();
        }
        foreach ($cdcs as $cdc) {
            $cdc['nome'] = ($cdc['codigo'] . " - " . $cdc['nome']);
        }

        $listaPapeis = User::getListaDePapeis();
        $listaUsuarios = User::select('id', 'nome', 'telefone', 'pais', 'tipo_usuario', 'email', 'situacao')
            ->where('tipo_usuario', '!=', 0)->where('tipo_usuario', '!=', 1)->orderBy('created_at');
        // Usuários para o field de superior no cadastro/edição de usuários
        $usuarios_superiores = User::select('nome', 'id', 'tipo_usuario')
            ->where('situacao', '1')->where('tipo_usuario', '!=', '0')->where('tipo_usuario', '!=', '4')
            ->orderBy('nome', 'asc')->get();
        //Alterando as chaves de idioma e papel para strings
        foreach ($listaUsuarios as $user) {
            $user->tipo_usuario = __($listaPapeis[$user->tipo_usuario]['valor']);
            if ($user->situacao == 0) {
                $user->situacao = __('usuarios.inativo');
            } else {
                $user->situacao = __('usuarios.ativo');
            }
        }
        return view('sistema.usuarios.editar', compact('funcoes', 'empresas', 'usuarios', 'papeis', 'idiomas', 'cdcs', 'usuarios_superiores', 'countries', 'modules', 'userPermissions', 'modulesLang', 'typeUsers', 'rolesList'));
    }

    public function updateUsuarios(Request $req)
    {
        $dados = $req->all();

        // if (User::validaEmail($dados['email'], $dados['id'])) {
        //     if (!isset($dados['password']) || empty($dados['password'])) {
        //         unset($dados['password']);
        //     } else {
        //         $dados['password'] = bcrypt($dados['password']);
        //     }

        //     User::find($dados['id'])->update($dados);

        //     if ($dados['tipo_usuario'] == 2) {
        //         UserSuperior::inserirSuperior($dados['id'], $dados['superior_s']);
        //     }
        //     if ($dados['tipo_usuario'] == 3) {
        //         UserSuperior::inserirSuperior($dados['id'], $dados['superior_c']);
        //     }
        //     if ($dados['tipo_usuario'] == 4) {
        //         UserSuperior::inserirSuperior($dados['id'], $dados['superior_a']);
        //     }
        //     if ($dados['tipo_usuario'] != 0) {
        //         CdcUsuario::alterarCdcUsuario($dados['cdcs'], $dados['id']);
        //     }
        //     Notificacao::gerarAlert('', 'editar_usuario_sucesso', 'success');
        //     return redirect()->route('usuarios_manager');
        // } else {
        //     Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
        //     return redirect()->route('usuarios_manager');
        // }
        if (!User::validaEmail($dados['email'], $dados['id'])) {
            Notificacao::gerarAlert("notificacao.erro", "notificacao.falhaEmail", "danger");
            return redirect()->route('usuarios_manager');
        } else {
            User::find($dados['id'])->update($dados);

            for($i = 0; $i < count($dados['id_module']); $i++) {
                $createItem = array(
                    'id_user' => $dados['id'],
                    'id_module' => $dados['id_module'][$i],
                    'permissions' => $dados['permissions'][$i]
                );
                if(!UserPermissions::where('id_user', $dados['id'])->where('id_module', $dados['id_module'])->exists()){
                    UserPermissions::create($createItem);
        } else {
                    UserPermissions::where('id_user', $dados['id'])->where('id_module', $dados['id_module'])
                    ->update($createItem);
                }
                unset($createItem);
        }

        Notificacao::gerarAlert('', 'usuarios.editar_usuario_sucesso', 'success');
        return redirect()->route('usuarios_manager');
        }
    }

    //profile
    public function getProfile() {
        // dd(session()->all());
        $ex = (session()->get('user_logged'));
        $id = $ex['id'];
        $user = User::find($id);
        return view('sistema.usuarios.ProfileUsuario', compact('user'));
    }

    //profile
    public function alteraInfoPerfil(Request $req) 
    {
        $dados = $req->all();
        $token = $dados['_token'];

        $updateItem = array(
            '_token' => $token,
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'celular' => $dados['telefone'],
            'codigo_idioma' => $dados['configuracao_idioma']
        );
        User::find($dados['id'])->update($updateItem);
        unset($updateItem);

        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
        return redirect()->route('dashboard');
    }

    //profile
    //FUNÇÃO AJAX PARA ALTERAÇÃO DE SENHA - RECEBE AS INFORMAÇÕES E RETORNA UM JSON
    public function alterarSenha(Request $req)
    {
        $dados = $req->all();
        $token = $dados['_token'];
        $senhaAtual = $dados['currentPassword'];
        $novaSenha = $dados['newPassword'];
        $confirmarNovaSenha = $dados['confirmNewPassword'];
        $verifyHashPw = Hash::check($senhaAtual, Auth::user()->password);

        if ((mb_strlen($dados['currentPassword']) >= 6) && ( $verifyHashPw == true) && ($novaSenha === $confirmarNovaSenha)) {
            $hashedpw = bcrypt($dados['newPassword']);
            $updateItem = array(
                '_token' => $token,
                'password' => $hashedpw
            );
            User::find($dados['id'])->update($updateItem);
            unset($updateItem);

            Notificacao::gerarAlert("notificacao.sucesso", "notificacao.edicaoSucesso", "success");
            return redirect()->route('dashboard');
        } else {
            Notificacao::gerarAlert("notificacao.erro", "danger");
            return redirect()->back();
        }

    }

    public function getUsuario($id)
    {
        $user = User::find($id);
        $id_sup = UserSuperior::select('id_superior')->where('id_usuario', $id)->first();
        $user['id_superior'] = $id_sup['id_superior'];
        $user['cdc_user'] = CdcUsuario::select('id_centro_custo')->where('id_usuario', $id)->get();
        $cdc_user = [];
        foreach ($user['cdc_user'] as $cdc) {
            array_push($cdc_user, $cdc['id_centro_custo']);
        }
        $user['cdc_user'] = $cdc_user;
        return $user;
    }

    public function validarEmailUsuario($id_usuario)
    {
        $usuario = User::find($id_usuario);
        if (!empty($usuario)) {
            DB::table('users')
                ->where('id', $id_usuario)
                ->update(['email_verified_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        }
        return redirect()->route('usuarios_manager');
    }

    public function delete($id)
    {
        $delete = User::find($id);
        $delete->delete();
        Notificacao::gerarAlert("notificacao.sucesso", "notificacao.remocaoSucesso", "success");
        return redirect()->route('usuarios_manager');
    }
}
