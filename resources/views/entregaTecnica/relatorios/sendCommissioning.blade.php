@extends('_layouts._layout_site')

@section('topo_detalhe')

    <div class="container-fluid topo">
        <div class="row align-items-start">

            {{-- TITULO E SUBTITULO --}}
            <div class="col-6">
                <h1>@lang('entregaTecnica.entregaTecnica')</h1>
                <h4>@lang('entregaTecnica.declaracao')</h4>
            </div>

            {{-- BOTOES SALVAR E VOLTAR --}}
            <div class="col-6 text-right botoes mobile">
                <a href="{{ route('edit_commissioning', $id_entrega_tecnica) }}" style="color: #3c8dbc">
                    <button type="button" data-toggle="tooltip" data-placement="bottom" title="Voltar">
                        <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-angle-double-left fa-stack-1x fa-inverse"></i>
                        </span>
                    </button>
                </a>

                <button type="button" data-toggle="tooltip" data-placement="bottom" title="Enviar" id="sendbutton">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <a href="#">
                            <i class="fas fa-paper-plane fa-stack-1x fa-inverse"></i>    
                        </a>
                    </span>
                </button>
            </div>
        </div>

        {{-- FILTRO DE PESQUISA --}}
        <div class="row justify-content-start telo5inputfiltro mt-2">
            <div class="ml-4">
                <h3> @lang('entregaTecnica.numero_pedido'):  <span style="color: #003A5D">{{ $entrega_tecnica['numero_pedido'] }}</span></h3> 
            </div>
            <div class="ml-5">
                <h3> @lang('entregaTecnica.data'):  <span style="color: #003A5D">{{ date('d/m/Y', strtotime($entrega_tecnica['data_entrega_tecnica'])) }}</span></h3> 
            </div>
            <div class="ml-5">
                <h3> @lang('entregaTecnica.tipo_entrega_tecnica'):  <span style="color: #003A5D">{{ strtoupper($entrega_tecnica['tipo_entrega_tecnica']) }}</span></h3> 
            </div>
        </div>
    </div>

    {{-- MODAL CPF --}}      
    <div class="modal fade" id="valida_cpf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('entregaTecnica.cpf_invalido')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('send_complete_commissioning') }}" id="dados_cpf" method="POST" enctype="multipart/form-data">          
                @csrf 
                <input type="hidden" name="id_entrega_tecnica" value="{{ $id_entrega_tecnica }}">
                <div class="modal-body">
                    <div class="form-row justify-content-start">
                        <div class="form-group col-md-12 telo5ce">
                            <label for="cpf_antigo">CPF {{ $entrega_tecnica['cpf_cliente'] }} @lang('entregaTecnica.msg_cpf_invalido_et')</label>
                        </div>
                    </div>
                    <div class="form-row justify-content-start">
                        <div class="form-group col-md-4 telo5ce">
                            <input type="text" name="cpf" id="cpf" class="form-control">
                        </div>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('comum.sair')</button>
                        <button type="button" class="btn btn-primary" id="enviar_cpf">@lang('comum.salvar')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL SEND CONFIRMATION COMMISSIONING --}}
    <div class="modal fade" id="modalConfirmationIncompleteCommissioning" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang('entregaTecnica.confirmacaoEnvioET')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmationSendCommissioning" method="POST" enctype="multipart/form-data">
                    <div class="form-group col-md-12 telo5ce mt-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="customSwitch1" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1" style="font-size: 1.2rem">@lang('entregaTecnica.solicitacaoConfirmacaoEnvioET')</label>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="form-row justify-content-start">
                            <div class="form-group col-md-6 telo5ce">
                                <label for="confirmEmail">@lang('usuarios.email')</label>
                                <input type="confirmEmail" class="form-control" id="confirmEmail" name="confirmEmail" maxlength="100">
                            </div>
                            <div class="form-group col-md-6 telo5ce">
                                <label for="confirmPassword">@lang('usuarios.confirmar_senha')</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" maxlength="20">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('comum.cancelar')</button>
                        <button type="button" class="btn btn-primary" id="sendConfirmation">@lang('comum.confirmar')</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('conteudo')
        <div id="alert">                
            @include('_layouts._includes._alert')    
        </div>  
        <div name="alertInput" id="alertInput" class="alertInput1 mt-0 pb-5"></div>

        {{-- PRELOADER --}}
        <div id="coverScreen">
            <div class="preloader">
                <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                <div>@lang('comum.preloader')</div>
            </div>
        </div>

        <form action="{{ route('send_complete_commissioning') }}" id="formdados" method="POST" enctype="multipart/form-data">           
            @csrf 
            <input type="hidden" name="id_entrega_tecnica" id="id_entrega_tecnica" value="{{ $id_entrega_tecnica }}">

            <div class="col-md-12" id="cssPreloader">
                <div class="form-row justify-content-start col-md-2">
                    <select name="assinatura_digital" id="" class="form-control">
                        <option value="clicksign">ClickSign</option>
                        <option value="d4sign">D4Sign</option>
                    </select>
                </div>
                
                <div class="form-row justify-content-start">
                    
                    <div class="form-group col-md-2 mt-2">
                        <label for="data_envio_entrega_tecnica">@lang('entregaTecnica.data_envio')</label>
                        <input type="text" name="data_envio_entrega_tecnica" class="form-control text-center" value="{{ date('d/m/Y H:i:s') }}" readonly>
                    </div>
                </div>
                <div class="form-row justify-content-start">
                    <div class="form-group col-md-12">
                        <label for="observacoes_envio">@lang('entregaTecnica.observacoes')</label>
                        <textarea class="form-control" id="observacoes_envio" name="observacoes_envio" rows="5"></textarea>
                    </div>
                </div>
            </div>

            <!-- Modal imagens torre central -->
            <div class="modal fade" id="modal_imagem" tabindex="-1" role="dialog" aria-labelledby="modal_imagem_Label">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_label_"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">     
                        <img src="" class="img_modal"/>      
                        {{-- @foreach ($dados_tc as $item)
                            @if (count($item) > 0)
                                <img src="{{ asset('../storage/app/public/')}}" class="img_modal">
                            @else                                                                
                            @endif
                        @endforeach --}}
                    </div>
                </div>
                </div>
            </div>
        </form>
@endsection

@section('scripts')

    {{-- MASCARA DE INPUT --}}
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script>
function expandImage(imagem_modal) {
            var src_img = $(imagem_modal).attr("src");
            $("#modal_imagem img").attr("src", src_img);
            $('#modal_imagem').modal('show');
        }
        function myfn(myinput) {
            var name = $(myinput).attr("name");
            var id = $(myinput).attr("id");
            var val = $(myinput).val();
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'png': case 'jpeg':
                    readURL(myinput);
                    break;
                default:
                    $(this).val('');
                    break;
            }
        }

        function readURL(myinput) {
            
            var id_image = $(myinput).attr("id").replace("img", "preview");
            var id_label = 'lb' + $(myinput).attr("id");

            if (myinput.files && myinput.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + id_image).attr('src', e.target.result);
                    $('#' + id_image).css('background-image', 'none');                    
                    $('#' + id_label ).html(' @lang("entregaTecnica.alterar_imagem") ');
                }
                
                reader.readAsDataURL(myinput.files[0]);
            }
        }

        function callbackModalSendConfirmation() {
            jQuery.noConflict();
            $('#modalConfirmationIncompleteCommissioning').modal('show');

            $('#customSwitch1').click(function() {
                if ($(this).prop("checked") == false) {
                    validarConfirmacaoEnvioET(true);
                } else if ($(this).prop("checked") == true) {
                    validarConfirmacaoEnvioET(false);
                }
            });

            $('#sendConfirmation').click(function(event) {
                event.preventDefault();

                var email = $('#confirmEmail').val();
                var senha = $('#confirmPassword').val();

                if (email == '' || senha == '') {
                    $('#modalConfirmationIncompleteCommissioning').modal('hide');
                    $('#alertInput').html('<div class="alert alert-danger alert-dismissible fade show pb-2" role="alert"><p>@lang("comum.checkInput3")</p></div>');
                    $(".alert").fadeIn(300).delay(3000).fadeOut(400);
                } else {
                    $.ajax({
                        url: "{{ route('sendConfirmation_commissioning') }}",
                        type: "post",
                        data: { _token: "{{ csrf_token() }}", email: email, senha: senha },
                        dataType: 'json',
                    }).done(function(res) {
                        dataReturn = res;

                        if(dataReturn.status == true){
                            $('#modalConfirmationIncompleteCommissioning').modal('hide');
                            $('#alertInput').html('<div class="alert alert-success alert-dismissible fade show pb-2" role="alert"><p>@lang("comum.checkInput4")</p></div>');
                            $(".alert").fadeIn(300).delay(1600).fadeOut(400);
                            sendValidCommissioning();
                        } else {
                            $('#modalConfirmationIncompleteCommissioning').modal('hide');
                            $('#alertInput').html('<div class="alert alert-danger alert-dismissible fade show pb-2" role="alert"><p>@lang("comum.checkInput3")</p></div>');
                            $(".alert").fadeIn(300).delay(1600).fadeOut(400);
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log("Error: " + textStatus);
                    });
                }
            });
        }

        function validarConfirmacaoEnvioET(flag) {
            $('#confirmPassword').prop('disabled', flag);
            $('#confirmEmail').prop('disabled', flag);
        }

        function sendValidCommissioning() {
                var url_back = "{{ route('manage_commissioning') }}"

                $.ajax({
                    type:'POST',
                    url: "{{ route('send_complete_commissioning') }}",
                    data: $('#formdados').serialize(),
                    success:function(data) {
                        if (data['observacoes_envio'] != null) {
                            location.href = url_back;
                            $("#coverScreen").show();
                            $("#cssPreloader textarea").each(function() {
                                $(this).css('opacity', '0.2');
                            });
                        } else if (data['observacoes_envio'] === null){
                            $("#coverScreen").show();
                            $("#cssPreloader input").each(function() {
                                $(this).css('opacity', '0.2');
                            });
                            $("#cssPreloader textarea").each(function() {
                                $(this).css('opacity', '0.2');
                            });
                            $("#alert").fadeIn(300).delay(2000).fadeOut(400);
                            window.location.reload();
                        }
                    },
                    error:function() {
                        jQuery.noConflict(); 
                        $('#valida_cpf').modal("show");
                    },
                });
        }

        function checkCommissioningStatus() {
            var id_entrega_tecnica = $('#id_entrega_tecnica').val();

            $.ajax({
                url: "{{ route('checkStatus_commissioning') }}",
                type: "post",
                data: { _token: "{{ csrf_token() }}", id_entrega_tecnica: id_entrega_tecnica },
                dataType: 'json',
            }).done(function(res) {
                statusReturn = res;

                if (statusReturn[0].status == 1 ) { 
                    callbackModalSendConfirmation();
                } else {
                    sendValidCommissioning();
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus);
            });
        }

        $(document).ready(function() {
            validarConfirmacaoEnvioET(true);

            $("#alert").fadeIn(300).delay(2000).fadeOut(400);
            $('#cpf').mask('000.000.000-00');

            $('#enviar_cpf').on('click', function() {
                $('#dados_cpf').submit();
            });

            $('#sendbutton').on('click', function(event) {
                event.preventDefault();
                checkCommissioningStatus();
            });                        
        });
            
            $(window).on('load', function() {
                $("#coverScreen").hide();
            });
    </script>
@endsection
