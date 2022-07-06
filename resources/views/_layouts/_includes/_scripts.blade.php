<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script> -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/navbar.js')}}"></script>
<!-- <script src="{{asset('js/inputMaterial.js')}}"></script>
<script src="{{asset('js/jquery.maskMoney.min.js')}}"></script> -->

{{-- SCRIPT PARA FUNCIONALIDADE DO TOOLTIP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
"
 <!-- Latest compiled and minified JavaScript -->
 <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> -->
{{-- MASCARA DE INPUT --}}
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

{{-- SALVAR E VALIDAR CAMPOS VAZIOS --}}
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
<script type="text/javascript">

<script>
        $(document).ready(function() {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            })

            $('#botaosalvar').on('click', function() {
                $('#formdados').submit();
            });
            
            $('#telefone').mask('(00) 00000-0000');

            $("#formdados").validate({
                rules: {
                    "nome": {
                        required: true,
                    },
                    "tipo": {
                        required: true,
                    },
                    "id_country": {
                        required: true,
                    }
                },
                messages: {
                    nome: "@lang('validate.validate')",
                    tipo: "@lang('validate.validate')",
                    id_country: "@lang('validate.validate')"
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
            
            $('#id_country').on('change',function() {
                var country = $('#id_country :selected').text();
                $('#pais').val(country);
            });
        });

        $(window).on('load', function() {
            $("#coverScreen").hide();
        });
        
</script>

<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<script src="https://kit.fontawesome.com/f03279da48.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
