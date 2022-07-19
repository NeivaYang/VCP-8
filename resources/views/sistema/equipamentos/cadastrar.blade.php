@extends('_layouts._layout_admsystem')
@include('_layouts._includes._head_admsystem')

@section('head')

@endsection

@section('titulo')
    Equipamentos
@endsection

@section('topo_detalhe')

    <div class="container-fluid topo">
        <div class="row align-items-start">

            {{-- TITULO E SUBTITULO --}}
            <div class="col-6">
                <h1>Equipamento</h1>
                <h4 style="margin-top: -2px">Cadastrar</h4>
            </div>

            {{-- BOTOES SALVAR E VOLTAR --}}
            <div class="col-6 text-right botoes mobile">
                <a href="{{ route('manage_equipamentos') }}" style="color: #3c8dbc" data-toggle="tooltip"
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
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">@lang('comum.informacoes_navtabs')</a>
            </li>
        </ul>

        {{-- FORMULARIO DE CADASTRO --}}
        <div class="col-12 p-3">
            <form action="{{ route('save_equipamentos') }}" method="post" class="mt-3" id="formdados">
                <div class="tab-content" id="myTabContent">
                    @include('_layouts._includes._alert')
                    <div class="tab-pane fade show active formcdc" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-row justify-content-start">
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="nome">Nome Equipamento</label>
                                    <input type="text" class="form-control telo5ce" id="nome" name="nome" maxlength="50" >
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="id_fazenda">Fazendas</label>
                                    <select name="id_fazenda" id="id_fazenda" class="form-control telo5ce">
                                        <option value="0"> </option>
                                        @foreach ($fazendas as $faz)                                    
                                            <option value="{{ $faz['id']}}">{{ $faz['nome']}}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="modelo">Modelo</label>
                                    <select name="modelo" id="modelo" class="form-control telo5ce">
                                        <option value="">@lang(' ')</option>
                                        @for ($i = 0; $i < count($modelo); $i++)                                    
                                            <option value="{{ $modelo[$i]['modelo']}}">{{ $modelo[$i]['modelo']}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-row justify-content-start">
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="altura">Altura</label>
                                    <select name="altura" id="altura" class="form-control telo5ce">
                                        <option value="">@lang(' ')</option>
                                        @for ($i = 0; $i < count($altura_equipamento); $i++)                                    
                                            <option value="{{ $altura_equipamento[$i]['altura_equipamento']}}">{{ __('listas.'. $altura_equipamento[$i]['altura_equipamento'] )}}</option>                                   
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="balanco">Balanço</label>
                                    <select name="balanco" id="balanco" class="form-control telo5ce">
                                        <option value="">@lang(' ')</option>
                                        @for ($i = 0; $i < count($getBalanco); $i++)                                    
                                            <option value="{{ $getBalanco[$i]['balanco']}}">{{ $getBalanco[$i]['balanco']}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="fabricante">Fabricante</label>
                                    <select name="fabricante" id="fabricante" class="form-control telo5ce">
                                        <option value="">@lang(' ')</option>
                                        @for ($i = 0; $i < count($fabricante); $i++)                                    
                                            <option value="{{ $fabricante[$i]['fornecedor']}}">{{ __('listas.'. $fabricante[$i]['fornecedor'] )}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-row justify-content-start">
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="tipo_equipamento">Tipo</label>
                                    <select name="tipo_equipamento" id="tipo_equipamento" class="form-control telo5ce">
                                        <option value="">@lang(' ')</option>
                                        @for ($i = 0; $i < count($tipo_equipamento); $i++)                                    
                                            <option value="{{ $tipo_equipamento[$i]['tipo_equipamento']}}">{{ __('listas.'. $tipo_equipamento[$i]['tipo_equipamento'] )}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="noserie_painel">Painel</label>
                                    <select name="noserie_painel" id="noserie_painel" class="form-control telo5ce">
                                        <option value="">@lang(' ')</option>
                                        @for ($i = 0; $i < count($noserie_painel); $i++)                                    
                                            <option value="{{ $noserie_painel[$i]['painel']}}">{{ __('listas.'. $noserie_painel[$i]['painel'] )}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

    {{-- SALVAR E VALIDAR CAMPOS VAZIOS --}}
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script>

        $(document).ready(function() {
            $('#botaosalvar').on('click', function() {
                $('#formdados').submit();
            });

            // $("#formdados").validate({
            //     rules: {
            //         "nome": {
            //             required: true,
            //         },
            //     },
            //     messages: {
            //         nome: "@lang('validate.validate')",
            //     },
            // });
        });
        
    </script>

@endsection