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
                <h1>@lang('funcao.titulo')</h1>
                <h4 style="margin-top: -2px">@lang('comum.editar')</h4>
            </div>

            {{-- BOTOES SALVAR E VOLTAR --}}
            <div class="col-6 text-right botoes mobile">
                <a href="{{ route('funcao_gerenciar') }}" style="color: #3c8dbc" data-toggle="tooltip"
                    data-placement="bottom" title="Voltar">
                    <button type="button">
                        <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-angle-double-left fa-stack-1x fa-inverse"></i>
                        </span>
                    </button>
                </a>
                <button type="button" id="botaosalvar" data-toggle="tooltip" data-placement="bottom" title="Salvar">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-save fa-stack-1x fa-inverse"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('conteudo')
    <div>
        {{-- NAVTAB'S --}}
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="cadastro-tab" data-bs-toggle="tab" role="tab" aria-controls="cadastro"
                    aria-current="page" aria-selected="true" href="#cadastro">@lang('comum.informacoes_navtabs')</a>
            </li>
        </ul>

        {{-- FORMULARIO DE EDICAO --}}
        <div class="col-12 p-3">
            <form action="{{ route('funcao_edita') }}" method="post" class="mt-3" id="formdados">
                <div class="tab-content" id="myTabContent">
                    @include('_layouts._includes._alert')
                    <div class="tab-pane fade show active formcdc" id="editar" role="tabpanel" aria-labelledby="cadastro-tab">
                        @csrf
                        <div class="col-md-12">
                            <input type="hidden" name="id" value="{{ $funcao->id }}">
                            <div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="nome">@lang('funcao.nome')</label>
                                    <input type="text" class="form-control telo5ce" id="nome" name="nome" maxlength="50"
                                        required value="{{ $funcao->nome }}">
                                </div>
                            </div>
                            <div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="id_funcao_pai">@lang('funcao.funcao_pai')
                                        <select name="id_funcao_pai" id="id_funcao_pai" class="form-control telo5ce">
                                            <option value="">@lang('funcao.nenhumfuncao')</option>
                                        @foreach($funcoes as $funcpai)
                                            <option value="{{ $funcpai->id }}">{{ $funcpai->nome }}</option>
                                        @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
@endsection

@section('script')

    {{-- SALVAR E VALIDAR CAMPOS VAZIOS --}}
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>

        {{-- SCRIPT PARA FUNCIONALIDADE DO TOOLTIP --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>

        <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
                
        $(document).ready(function() {
            $('#botaosalvar').on('click', function() {
                $('#formdados').submit();
            });

            $("#formdados").validate({
                rules: {
                    "nome": {
                        required: true,
                    },
                },
                messages: {
                    nome: "@lang('validate.validate')",
                },
            });
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
        
        $(window).on('load', function() {
            $("#coverScreen").hide();
        });

    </script>

@endsection