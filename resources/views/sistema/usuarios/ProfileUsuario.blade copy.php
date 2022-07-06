@extends('_layouts._layout_admsystem')
@include('_layouts._includes._head_admsystem')

@section('head')

@endsection

@section('titulo')
    @lang('usuarios.usuarios')
@endsection

@section('topo_detalhe')
    <div class="container-fluid topo">
        <div class="row align-items-start">
            {{-- TITULO E SUBTITULO --}}
            <div class="col-6">
                <h1>@lang('usuarios.usuarios')</h1>
                <h4 style="margin-top: -2px">Profile</h4>
            </div>
        </div>
    </div>
@endsection

@section('conteudo')
    <div class="col-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">@lang('comum.informacoes_navtabs')</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-6 p-3">
                <form id="form_submit" action="{{ route('usuario_alterar') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user['id'] }}">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome">@lang('usuarios.nome')<em class="label-required"> *</em>
                                <input id="nome" class="form-perfil" maxlength="20" name="nome" required="required" type="text" aria-describedby="" value="{{ $user['nome'] }} "/>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="celular">@lang('usuarios.telefone')<em class="label-required"> *</em>
                                <input id="celular" class="form-perfil" maxlength="15" name="telefone" required="required" type="text" aria-describedby="" value="{{ $user['celular'] }} "/>
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">@lang('usuarios.email')<em class="label-required"> *</em>
                                <input id="email" class="form-perfil" maxlength="190" name="email" required="required" type="email" aria-describedby="" value="{{ $user['email'] }} "/>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="codigo_idioma">@lang('usuarios.idioma')<em class="label-required"></em>
                                <select id="codigo_idioma" class="form-perfil has-value" name="configuracao_idioma" required="required">
                                    <option value="0" {{ $user['codigo_idioma'] == '0' ? 'selected' : ''}}>pt-br</option>
                                    <option value="1" {{ $user['codigo_idioma'] == '1' ? 'selected' : ''}}>en</option>
                                    <option value="2" {{ $user['codigo_idioma'] == '2' ? 'selected' : ''}}>es</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="form-row ">
                        <div class="col-6 text-left">
                            <button id="botaosalvar" class="btn btn-primary" style="margin: 0px auto;" type="submit">@lang('comum.salvar')</button>
                            <a class="btn btn-outline-secondary" href="{{route('dashboard')}}">@lang('comum.voltar')</a>
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="col-12 mb-2 p-1"><em class="tam"><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em></div>
                    </div> 
                </form>
            </div>

            <div class="col-md-6 p-3">
                <form id="form_submit_alt_senha" action="{{ route('alterar_senha') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user['id'] }}">

                    <h3 style="color: rgb(1, 56, 86);">Alterar Senha</h3>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="currentPassword">@lang('usuarios.senha_atual')<em class="label-required"> *</em>
                                <input id="currentPassword" class="form-perfil" minlength="6" maxlength="20" name="currentPassword" type="password" placeholder="@lang('usuarios.senha_atual')" />
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="newPassword">@lang('usuarios.nova_senha')<em class="label-required"> *</em>
                                <input id="newPassword" class="form-perfil" minlength="6" maxlength="20" name="newPassword" type="password" placeholder="Apenas informe a senha se for altera-la!" />
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="confirmNewPassword">@lang('usuarios.confirmar_nova_senha')<em class="label-required"> *</em>
                                <input id="confirmNewPassword" class="form-perfil" minlength="6" maxlength="20" name="confirmNewPassword" type="password" placeholder="Confirme a senha!" />
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-6 text-left">
                            <button class="btn btn-primary" style="margin: 0px auto;" type="submit">@lang('usuarios.alterar_senha')</button>
                            <a class="btn btn-outline-secondary" href="{{route('dashboard')}}">@lang('comum.voltar')</a>
                        </div>
                    </div>
                    <div class="col-12 mb-2 p-1"><em class="tam"><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em></div>

                </form>                
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    {{-- MASCARA DE INPUT --}}
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
        });

    </script>
    {{-- SALVAR E VALIDAR CAMPOS VAZIOS --}}
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $('#botaosalvar').on('click', function() {
                $('#form_submit').submit();
            });
            
            $('#telefone').mask('(00) 00000-0000');

            $("#form_submit").validate({
                rules: {
                    "nome": {
                        required: true,
                    },
                    "email": {
                        required: true,
                    },
                    "celular": {
                        required: true,
                    }
                    "codigo_idioma": {
                        required: true,
                    }
                },
                messages: {
                    nome: "@lang('validate.validate')",
                    email: "@lang('validate.validate')",
                    celular: "@lang('validate.validate')"
                    codigo_idioma: "@lang('validate.validate')"
                },
                submitHandler: function(form) {
                    $("#coverScreen").show();
                    $("#cssPreloader input").each(function() {
                        $(this).css('opacity', '0.2');
                    });
                    $("#cssPreloader select").each(function() {
                        $(this).css('opacity', '0.2');
                    });
                    form.submit();
                }
            });
        });
        $(window).on('load', function() {
            $("#coverScreen").hide();
        });
    </script>

@endsection