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
                <h1>@lang('comum.equipamentos')</h1><br>
                <h4 style="margin-top: -20px">@lang('comum.editar')</h4>
            </div>

            {{-- Save button and return button --}}
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
            <form action="{{ route('update_equipamentos') }}" method="post" class="mt-3" id="formdados">
                <div class="tab-content" id="myTabContent">
                    @include('_layouts._includes._alert')
                    <div class="tab-pane fade show active formcdc" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
                        @csrf
                        <div class="col-md-12">
                            <input type="hidden" name="id" value="{{ $equipamento->id }}">

                            <div class="form-row justify-content-start">
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="nome">Nome Equipamento</label>
                                    <input type="text" class="form-control telo5ce" id="nome" name="nome" maxlength="50" value="{{ $equipamento->nome }}" >
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="id_fazenda">Fazendas</label>
                                    <select name="id_fazenda" id="id_fazenda" class="form-control telo5ce">>
                                        @foreach ($fazendas as $faz)                                    
                                            <option value="{{ $faz['id']}}" 
                                                {{ $equipamento->id_fazenda == $faz['id'] ? 'selected' : '' }} >{{ $faz['nome']}}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="modelo">Modelo</label>
                                    <select name="modelo" id="modelo" class="form-control telo5ce">
                                        @for ($i = 0; $i < count($modelo); $i++)                                    
                                            <option value="{{ $modelo[$i]['modelo']}}" {{ ($modelo[$i]['modelo'] == $equipamento['modelo'] ? 'selected' : '') }}>{{ $modelo[$i]['modelo']}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-row justify-content-start">
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="altura">Altura</label>
                                    <select name="altura" id="altura" class="form-control telo5ce">
                                        @for ($i = 0; $i < count($altura_equipamento); $i++)                                    
                                            <option value="{{ $altura_equipamento[$i]['altura_equipamento']}}" {{ ($altura_equipamento[$i]['altura_equipamento'] == $equipamento['altura'] ? 'selected' : '') }}>{{ __('listas.'. $altura_equipamento[$i]['altura_equipamento'] )}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="balanco">Balanço</label>
                                    <select name="balanco" id="balanco" class="form-control telo5ce">
                                        @for ($i = 0; $i < count($getBalanco); $i++)                                    
                                            <option value="{{ $getBalanco[$i]['balanco']}}" {{ ($getBalanco[$i]['balanco'] == $equipamento['balanco'] ? 'selected' : '') }}>{{ $getBalanco[$i]['balanco']}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="fabricante">Fabricante</label>
                                    <select name="fabricante" id="fabricante" class="form-control telo5ce">
                                        @for ($i = 0; $i < count($fabricante); $i++)                                    
                                            <option value="{{ $fabricante[$i]['fornecedor']}}" {{ ($fabricante[$i]['fornecedor'] == $equipamento['fabricante'] ? 'selected' : '') }}>{{ __('listas.'. $fabricante[$i]['fornecedor'] )}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-row justify-content-start">
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="tipo">Tipo</label>
                                    <select name="tipo" id="tipo" class="form-control telo5ce">
                                        @for ($i = 0; $i < count($tipo_equipamento); $i++)                                    
                                            <option value="{{ $tipo_equipamento[$i]['tipo_equipamento']}}" {{ ($tipo_equipamento[$i]['tipo_equipamento'] == $equipamento['tipo_equipamento'] ? 'selected' : '') }}>{{ __('listas.'. $tipo_equipamento[$i]['tipo_equipamento'] )}}</option>                                    
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4 telo5ce">
                                    <label for="noserie_painel">Painel</label>
                                    <select name="noserie_painel" id="noserie_painel" class="form-control telo5ce">
                                        @for ($i = 0; $i < count($noserie_painel); $i++)                                    
                                            <option value="{{ $noserie_painel[$i]['painel']}}" {{ ($noserie_painel[$i]['painel'] == $equipamento['noserie_painel'] ? 'selected' : '') }}>{{ __('listas.'. $noserie_painel[$i]['painel'] )}}</option>                                    
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

    {{-- VALIDAÇÕES DE CAMPOS --}}
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script>

        $(document).ready(function() {
            $('#botaosalvar').on('click', function() {
                $('#formdados').submit();
            });

        });
    </script>

@endsection