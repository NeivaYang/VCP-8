@extends('_layouts._layout_admsystem')
@include('_layouts._includes._head_admsystem')

@section('head')

@endsection

@section('titulo')
    @lang('empresa.corporation')
@endsection

@section('topo_detalhe')
    <div class="container-fluid topo">
        <div class="row align-items-start">

            {{-- Titlle --}}
            <div class="col-6">
                <h1>@lang('sidenav.empresa')</h1><br>
                <h4 style="margin-top: -20px">@lang('comum.editar')</h4>
            </div>

            {{-- Save button and return button --}}
            <div class="col-6 text-right botoes mobile">
                <a href="{{ route('manager_empresa') }}" style="color: #3c8dbc" data-toggle="tooltip"
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

        {{-- PRELOADER --}}
        <div id="coverScreen">
            <div class="preloader">
                <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                <div>@lang('comum.preloader')</div>
            </div>
        </div>

        {{-- FORMULARIO DE EDICAO --}}
        <form action="{{ route('update_empresa') }}" method="post" class="mt-3" id="formdados">
            <div class="tab-content" id="myTabContent">
                @include('_layouts._includes._alert')
                <div class="tab-pane fade show active" id="editar" role="tabpanel" aria-labelledby="editar-tab">
                    @csrf
                    <div class="col-md-12 " id="cssPreloader">
                        <input type="hidden" name="id" value="{{ $empresa->id }}">

                        <div class="form-row justify-content-start">
                            <div class="form-group col-md-4 telo5ce">
                                <label for="nome">@lang('empresa.nome')</label>
                                <input type="text" class="form-control telo5ce" id="nome" name="nome" maxlength="50"
                                    required value="{{ $empresa->nome }}">
                            </div>

                            <div class="form-group col-md-4 telo5ce ">
                                <label for="email">@lang('empresa.email')</label>
                                <input type="email" class="form-control" id="email" name="email" maxlength="100" required
                                    value="{{ $empresa->email }}">
                            </div>

                            <div class="form-group col-md-4 telo5ce">
                                <label for="telefone">@lang('revendas.telefone')</label>
                                <input type="tel" class="form-control telo5ce" id="telefone" name="telefone"
                                    maxlength="15" required value="{{ $empresa->telefone }}">
                            </div>
                        </div>
                        <div class="form-row justify-content-start">
                            <div class="form-group col-md-4 telo5ce">
                                <label for="pais">@lang('usuarios.pais')</label><br>
                                <input type="hidden" name="pais" id="pais" />
                                <select required name="id_country" id="id_country" class="form-control telo5ce">
                                    <option value="{{ $empresa->id_country }}"></option>
                                @foreach ($countries as $datas)
                                    <option value="{{ $datas['id_country'] }}">{{ $datas['name'] }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group col-md-4 telo5ce">
                                <label for="cidade">@lang('empresa.cidade')</label>
                                <input type="text" class="form-control telo5ce" id="cidade" name="cidade" 
                                maxlength="100" value="{{ $empresa->cidade }}">
                            </div>
                            <div class="form-group col-md-4 telo5ce">
                                <label for="estado">@lang('empresa.estado')</label>
                                <input type="text" class="form-control telo5ce" id="estado" name="estado" 
                                maxlength="50" value="{{ $empresa->estado }}">
                            </div>
                        </div>
                        <div class="form-group col-md-2 telo5ce">
                            <legend>@lang('empresa.tipo')</legend>
                            <select required name="tipo" id="tipo" class="form-control telo5ce">
                                <option value="dealer">@lang('empresa.dealer')</option>
                                <option value="corporation">@lang('empresa.corporation')</option>
                            </select>
                        </div>                       
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')


{{-- FILTRO SELECT --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
    integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

        {{-- MASCARA DE INPUT --}}
        <script src="{{ asset('js/jquery.mask.js') }}"></script>
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#telefone').mask('(00) 00000-0000');
            });
    
        </script>

    {{-- VALIDAÇÕES DE CAMPOS --}}
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $('#botaosalvar').on('click', function() {
                $('#formdados').submit();
            });

            $("#formdados").validate({
                rules: {
                    "nome": {
                        required: true
                    },
                    "email": {
                        required: true
                    },
                    "telefone": {
                        required: true
                    }
                },
                messages: {
                    nome: "@lang('validate.validate')",

                    "email": {
                        required: "@lang('validate.validate')"
                    },
                    "telefone": {
                        required: "@lang('validate.validate')"
                    }
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

    {{-- SCRIPT PARA FUNCIONALIDADE DO TOOLTIP --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

@endsection