@extends('_layouts._layout_site')

@section('topo_detalhe')
    <div class="container-fluid topo">
        <div class="row align-items-start">

            {{-- TITULO E SUBTITULO --}}
            <div class="col-6 titulo-cdc-mobile">
                <h1>@lang('entregaTecnica.entregaTecnica')</h1><br>
                <h4 style="margin-top: -20px">@lang('entregaTecnica.adutora') - @lang('comum.cadastrar')</h4>
            </div>

            {{-- BOTOES SALVAR E VOLTAR --}}
            <div class="col-6 text-right botoes mobile">
                <a href="{{ route('edit_commissioning', $id_entrega_tecnica) }}" style="color: #3c8dbc" data-toggle="tooltip"
                    data-placement="bottom" title="@lang('entregaTecnica.voltar')">
                    <button type="button">
                        <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-angle-double-left fa-stack-1x fa-inverse"></i>
                        </span>
                    </button>
                </a>

                <button type="button" id="botaosalvar" data-toggle="tooltip" data-placement="bottom" title="@lang('entregaTecnica.salvar')" name="botao" value="sair">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-save fa-stack-1x fa-inverse"></i>
                    </span>
                </button>

                <!-- modificação para botão salvar sair -->
                <button type="button" id="saveoutbutton" data-toggle="tooltip" data-placement="bottom" title="@lang('entregaTecnica.salvar_sair')">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-chevron-right fa-stack-1x fa-inverse" style="margin-left:15px;"></i>
                        <i class="fas fa-save fa-stack-1x fa-inverse"style=" margin-left:-6px;"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('conteudo')
        {{-- NAVTAB'S --}}
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">@lang('entregaTecnica.principais')</a>
            </li>
        </ul>

        {{-- FORMULARIO DE CADASTRO --}}
        <form action="{{ route('save_commissioning_water_supply') }}" method="post" class="mt-3" id="formdados">
            <div class="tab-content" id="myTabContent">
                @include('_layouts._includes._alert')
                <input type="hidden" name="id_entrega_tecnica" id="id_entrega_tecnica" value="{{ $id_entrega_tecnica }}">
                <input type="hidden" name="adutora" id="adutora" value="{{ count($adutoras) > 0 }}">
                <div class="tab-pane fade show active formcdc" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
                    @csrf 
                    <div class="form-row justify-content-start">
                        <div class="form-group col-md-4 telo5ce pl-4">            
                            <label for="fornecedor">@lang('entregaTecnica.fornecedor')</label>          
                            <select name="fornecedor" required class="form-control"  id="fornecedor_'{{ $adutoras['id_adutora'] }}">
                                <option value=""></option>
                                @foreach ($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor["fornecedor"] }}" {{ $fornecedor["fornecedor"] == $adutoras["fornecedor"] ? 'selected' : '' }}>{{ __("listas." . $fornecedor["fornecedor"] ) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4 telo5ce">
                            <label for="fornecedor">@lang('entregaTecnica.marca_tubo')</label>          
                            <select name="marca_tubo" required class="form-control"  id="marca_tubo_'{{ $adutoras['id_adutora'] }}">
                                <option value=""></option>
                                @foreach ($marcaTubos as $item)
                                    <option value="{{ $item["marca"] }}" {{ $item["marca"] == $adutoras["marca_tubo"] ? 'selected' : '' }}>{{ __("listas." . $item["marca"] ) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="informativo">
                        <span class="removetablerow" style=""><i class="fas fa-exclamation-circle"></i></span> <span class="informacao">@lang('entregaTecnica.informacao_adutora')</span>
                    </div>

                    <div class="table-responsive m-auto tabela" id="cssPreloader">
                        @if ($adutoras > 0)         
                            <table class="table table-striped mx-auto text-center" id="tabelaTrechos">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('afericao.tipoCano')</th>
                                        <th scope="col">@lang('afericao.diametro') @lang('unidadesAcoes.(pol)')</th>
                                        <th scope="col">@lang('afericao.numeroCanos')</th>
                                        <th scope="col">@lang('afericao.comprimento') @lang('unidadesAcoes.(m)')</th>
                                        <th scope="col">@lang('afericao.acoes')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adutoras as $adutora)                       
                                        <tr>
                                            <td>
                                                <select name="tipo_tubo[]" required class="form-control"  id="tipo_tubo_'{{ $adutora['id_adutora'] }}">
                                                    <option value=""></option>
                                                    @foreach ($tubos as $tubo)
                                                        <option value="{{ $tubo["tipo"] }}" {{ $tubo["tipo"] == $adutora["tipo_tubo"] ? 'selected' : '' }}>{{ __("listas." . $tubo["tipo"] ) }}</option>
                                                    @endforeach
                                                </select>
                                            </td>                
                                            <td><input type="number" class="form-control" required name="diametro[]" id="diametro_'{{ $adutora['id_adutora'] }}" value="{{ $adutora['diametro'] }}"></td>
                                            <td><input type="number" class="form-control" required name="numero_linha[]" id="numero_linha_'{{ $adutora['id_adutora'] }}" value="{{ $adutora['numero_linha'] }}"></td>
                                            <td><input type="number" min=1 class="form-control" required name="comprimento[]" id="comprimento_'{{ $adutora['id_adutora'] }}" value="{{ $adutora['comprimento'] }}"></td>
                                            
                                            <td>
                                                <button type="button" class="removetablerow" onclick="remove(this)"
                                                    style="outline: none; cursor: pointer; margin-top: 4px;"><i class="fa fa-fw fa-times fa-lg"></i>
                                                </button>
                                            </td>
                                        </tr>        
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td>
                                        <button onclick="AddTableRow()" type="button" class="addtablerow"
                                            style="outline: none; cursor: pointer;">
                                            <span class="fa-stack fa-sm">
                                                <i class="fas fa-plus-circle fa-stack-2x"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
                            </table>
                        @else 
                            <table class="table table-striped mx-auto text-center" id="tabelaTrechos">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('afericao.fornecedor')</th>
                                        <th scope="col">@lang('afericao.marca_tubo')</th>
                                        <th scope="col">@lang('afericao.tipoCano')</th>
                                        <th scope="col">@lang('afericao.diametro') @lang('unidadesAcoes.(pol)')</th>
                                        <th scope="col">@lang('afericao.numeroCanos')</th>
                                        <th scope="col">@lang('afericao.comprimento') @lang('unidadesAcoes.(m)')</th>
                                        <th scope="col">@lang('afericao.acoes')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <td>
                                        <button onclick="AddTableRow()" type="button" class="addtablerow"
                                            style="outline: none; cursor: pointer;">
                                            <span class="fa-stack fa-sm">
                                                <i class="fas fa-plus-circle fa-stack-2x"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </form>
@endsection

@section('scripts')

    {{-- COMBOS DE SELECTS --}}
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            var adutora = $('#adutora').val();
            if (adutora == 0) {
                AddTableRow();
            }
            
            $("#alert").fadeIn(300).delay(2000).fadeOut(400);
            
            $('#botaosalvar').on('click', function() {
                $('#formdados').submit();
            });
        });
    </script>

    {{-- FUNÇÃO PARA REMOVER LINHAS DA TABELA --}}
    <script>

        (function($) {
            remove = function(item) {
                var tr = $(item).closest('tr');
                tr.fadeOut(400, function() {
                    tr.remove();
                });
                return false;
            }
        })(jQuery);

    </script>

    {{-- FUNÇÃO PARA ADICIONAR LINHAS A TABELA --}}
    <script>
        (function($) {
            AddTableRow = function() {

                var rowCount = $('#tabelaTrechos >tbody >tr').length;
                var newRow = $("<tr>");
                var cols = "";
                cols += '<td hidden><input type="number" class="form-control" name="id_adutora[]" id="id_adutora_' + rowCount + '"></td>';
                
                cols += '<td>';
                cols += '   <select name="tipo_tubo[]" required class="form-control"  id="tipo_tubo_' + rowCount + '">';
                cols += '       <option value=""></option>';
                cols += '       @foreach ($tubos as $tubo)';
                cols += '           <option value="{{ $tubo["tipo"] }}" {{ $tubo["tipo"] == $adutora["tipo_tubo"]}}>{{ __("listas." . $tubo["tipo"] ) }}</option>';
                cols += '       @endforeach';
                cols += '   </select>';
                cols += '</td>';
                
                cols += '<td><input type="number" class="form-control" required name="diametro[]" id="diametro_' + rowCount + '"></td>';
                cols += '<td><input type="number" class="form-control" required name="numero_linha[]" id="numero_linha_' + rowCount + '"></td>';
                cols += '<td><input type="number" min=1 class="form-control" required name="comprimento[]" id="comprimento_' + rowCount + '"></td>';


                if (rowCount > 0){
                    cols += '<td><button type="button" class="removetablerow" onclick="remove(this)" style="outline: none; cursor: pointer; margin-top: 4px;"><i class="fa fa-fw fa-times fa-lg"></i></button></td>';
                }
                newRow.append(cols);
                $("#tabelaTrechos").append(newRow);
                return false;
            };
        })(jQuery);

    </script>
@endsection
