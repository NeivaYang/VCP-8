
<style>
    .ativo {
        background-color: #1b6b9a !important;
    }
</style>

{{-- MENU HAMBURGUER --}}
<div class="dropdown4">
    <button onclick="myFunction4()" class="dropbtn4">
        <i class="fas fa-bars"></i>
    </button>

    <div id="myDropdown4" class="dropdown-content4 content">
        @php $listModules = Session::get('listModules'); @endphp
        <nav class="nav11" role="navigation">
            <ul class="nav11__list">
                <li class="navbar11">

                    {{-- AFERIÇÃO --}}
                    {{-- @if (array_search("afericao.pivoCentral", array_column($listModules, 'name')))
                        @php $index = array_search("afericao.pivoCentral", array_column($listModules, 'name')); @endphp

                    <input id="group-1" type="checkbox" hidden />
                        <label for="group-1"><span class="fa fa-caret-right"></span>{{ $listModules[$index]['description'] }}</label>

                    <ul class="group-list">
                        <li class="subnavbar">
                            <input id="sub-group-1" type="checkbox" hidden />
                            <label for="sub-group-1">
                                    <a href="{{ route('gauging_manager') }}" class='nav-link'>@lang('afericao.pivoCentral')</a>
                            </label> --}}

                            {{-- CAMPOS VAGOS PARA MAIS VIEWS, SOMENTE TIRAR DO COMENTARIO E ADICIONAR A ROTA --}}
                                {{--
                                <input id="sub-group-1" type="checkbox" hidden />
                                <label for="sub-group-1"></span><a href="#"> Second level</a></label>
                                <input id="sub-group-1" type="checkbox" hidden />
                                <label for="sub-group-1"></span><a href="#"> Second level</a></label>
                                <input id="sub-group-1" type="checkbox" hidden />
                                <label for="sub-group-1"></span><a href="#"> Second level</a></label> --}}
                        {{-- </li>
                    </ul>
                    @endif --}}

                    {{-- REDIMENSIONAMENTO --}}
                    {{-- @if (array_search("redimensionamento.pivoCentral", array_column($listModules, 'name')))
                    @php $index = array_search("redimensionamento.pivoCentral", array_column($listModules, 'name')); @endphp
                    <input id="group-2" type="checkbox" hidden />
                    <label for="group-2"><span class="fa fa-caret-right"></span>{{ $listModules[$index]['description'] }}</label>
                    <ul class="group-list">
                        <li class="subnavbar">
                            <input id="redimensionamento" type="checkbox" hidden />
                            <label for="redimensionamento">
                                <a href="{{ route('resizing_manager') }}" class='nav-link'>
                                    @lang('afericao.pivoCentral')
                                </a>
                            </label>
                        </li> --}}
                        {{-- SUBMENU COM DROPDOWN ATE TERCEIRO NIVEL --}}
                        {{-- <li class="subnavbar">
                            <input id="sub-group-2" type="checkbox" hidden />
                            <label for="sub-group-2"> Second level</label>
                            <ul class="sub-group-list-2">
                                <li><a href="#"><span>2nd level nav item</span> </a></li>
                                <li><a href="#"><span>2nd level nav item</span></a></li>
                                <li><a href="#"><span>2nd level nav item</span></a></li>
                                <li class="subnavbar2">
                                <input id="sub-sub-group-2" type="checkbox" hidden />
                                <label for="sub-sub-group-2"><span class="fa fa-caret-right"></span>
                                    Third level</label>
                                <ul class="sub-sub-group-list-2">
                                    <li><a href="#">3rd level nav item</a></li>
                                    <li><a href="#">3rd level nav item</a></li>
                                    <li><a href="#">3rd level nav item</a></li>
                                </ul>
                            </li>
                            </ul>
                        </li> --}}
                    {{-- </ul>
                    @endif --}}

                    {{-- ENTREGA TÉCNICA --}}
                    @if (array_search("entregaTecnica", array_column($listModules, 'name')))
                    @php $index = array_search("entregaTecnica", array_column($listModules, 'name')); @endphp
                    <input id="group-3" type="checkbox" hidden />
                    
                    <a href="{{ route('manage_commissioning') }}" class="nav-link entrega-tecnica-link sub_grupo">
                        {{ $listModules[$index]['description'] }}
                    </a>
                    @endif

                    {{-- ANÁLISE ENTREGA TÉCNICA --}}
                    @if (array_search("analise.entregaTecnica", array_column($listModules, 'name')))
                    @php $index = array_search("analise.entregaTecnica", array_column($listModules, 'name')); @endphp
                    <input id="group-4" type="checkbox" hidden />
                    <a href="{{ route('manage_analysis_commissioning') }}" class="nav-link entrega-tecnica-link sub_grupo">
                        </span>{{ $listModules[$index]['description'] }}
                    </a>

                    {{-- DOWNLOAD --}}
                    {{-- <input id="group-4" type="checkbox" hidden />
                    <a href="{{ route('manage_commissioning') }}" class="nav-link entrega-tecnica-link">
                        </span>@lang('entregaTecnica.biblioteca')
                    </a> --}}
                    @endif

                    {{-- GARANTIAS --}}

                    {{-- <input id="group-3" type="checkbox" hidden />
                    <label for="group-3"><span class="fa fa-caret-right"></span>@lang('garantias.garantias')</label>
                    <ul class="group-list">
                        <li class="subnavbar">
                            <input id="sub-group-3" type="checkbox" hidden />
                            <label for="sub-group-3">
                                <a href="#" class="nav-link">
                                    @lang('garantias.garantias')
                                </a>
                            </label>
                            <ul class="sub-group-list-3">
                                <li><a href="#">2nd level nav item</a></li>
                                <li><a href="#">2nd level nav item</a></li>
                                <li><a href="#">2nd level nav item</a></li>
                                <li class="subnavbar2">
                                    <input id="sub-sub-group-3" type="checkbox" hidden />
                                    <label for="sub-sub-group-3"><span class="fa fa-caret-right"></span>
                                        Third level</label>
                                    <ul class="sub-sub-group-list-3">
                                        <li><a href="#">3rd level nav item</a></li>
                                        <li><a href="#">3rd level nav item</a></li>
                                        <li><a href="#">3rd level nav item</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                            </ul> --}}

                    {{-- RELATÓRIOS DE FICHA TÉCNICA --}}

                    {{-- <input id="group-5" type="checkbox" hidden />
                    <label for="group-5"><span class="fa fa-caret-right"></span>@lang('relatorios.relatorios')</label>
                    <ul class="group-list">
                        <li class="subnavbar">
                            <input id="sub-group-3" type="checkbox" hidden />
                            <label for="sub-group-3">
                                <a href="#" class="nav-link">
                                    @lang('relatorios.relatorioFichaTecnica')
                                </a>
                            </label>
                            {{-- <ul class="sub-group-list-3">
                                <li><a href="#">2nd level nav item</a></li>
                                <li><a href="#">2nd level nav item</a></li>
                                <li><a href="#">2nd level nav item</a></li>
                                <li class="subnavbar2">
                                    <input id="sub-sub-group-3" type="checkbox" hidden />
                                    <label for="sub-sub-group-3"><span class="fa fa-caret-right"></span>
                                        Third level</label>
                                    <ul class="sub-sub-group-list-3">
                                        <li><a href="#">3rd level nav item</a></li>
                                        <li><a href="#">3rd level nav item</a></li>
                                        <li><a href="#">3rd level nav item</a></li>
                                    </ul>
                                </li>
                            </ul> --}}
                        </li>
                    </ul>
                    
                    {{-- CAMPO DISPONIVEL NO HAMBURGUER PARA PROXIMOS PROJETOS COM DROPDOWN ATÉ TERCEIRO NIVEL SE NECESSARIO --}}

                    {{-- <input id="group-5" type="checkbox" hidden />
                    <label for="group-5"><span class="fa fa-caret-right"></span>Relatórios</label>
                    <ul class="group-list">
                        <li class="subnavbar">
                            <input id="sub-group-5" type="checkbox" hidden />
                            <label for="sub-group-5"><span class="fa fa-caret-right"></span> Second
                                level</label>
                            <ul class="sub-group-list-5">
                                <li><a href="#">2nd level nav item</a></li>
                                <li><a href="#">2nd level nav item</a></li>
                                <li><a href="#">2nd level nav item</a></li>
                                <li class="subnavbar2">
                                    <input id="sub-sub-group-5" type="checkbox" hidden />
                                    <label for="sub-sub-group-5"><span class="fa fa-caret-right"></span>
                                        Third level</label>
                                    <ul class="sub-sub-group-list-5">
                                        <li><a href="#">3rd level nav item</a></li>
                                        <li><a href="#">3rd level nav item</a></li>
                                        <li><a href="#">3rd level nav item</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul> --}}
                </li>
            </ul>
        </nav>
    </div>
</div>

{{-- SELECIONAR FAZENDA --}}

<div class="dropdown">

    <button id="btnSelecionFazenda" class="dropbtn" onclick="myFunction()"
        style="background: url({{ asset('img/ico_fazenda.png') }});background-repeat: no-repeat; background-color: #0574AF; background-size: 30px; background-position: 5%;">
        
        @if (session()->has('fazenda'))
            <span class="dropbtn">{{ Session::get('fazenda')['nome'] }}</span>
        @else
            <span class="dropbtn">@lang('comum.nenhuma_fazenda_selecionada')</span> 
        @endif
        <i class="fas fa-caret-down"></i>
    </button>

    <div id="myDropdown1" class="dropdown-content1">
        <div class="inputicon">
            <input type="text" placeholder="@lang('fazendas.pesquisarFazenda')" id="myInput" class="myInput"
                onkeyup="filterFunction()"><i class="fas fa-search"></i>
        </div>
        <div class="headersearch">@lang('fazendas.fazendasDisponiveis')</div>
        <div class="listafazendas">
                @php $Lista_Fazendas = Session::get('Lista_Fazendas'); @endphp

                @foreach ($Lista_Fazendas as $item)
                    <a href="javascript:setFazenda({{ $item['id'] }})">{{ $item['nome'] }}</a>
                @endforeach    
        </div>
    </div>
</div>

{{-- BOTOES DO MENU NO HEADER --}}
<div class="imagens ">
    <a href="{{ route('dashboard') }}"> <img src="{{ asset('img/ico_dashboard.png') }}" alt="dashboard" class="icodash"> </a>
    {{-- <a href="{{ route('gauging_manager') }}" class="img-mobile-425"><img src="{{ asset('img/ico_afericao.png') }}" alt="afericao" class="icoafer"></a> --}}
</div>

{{-- MENU LATERAL DA DIREITA --}}
<div id="main">
    <ul id="menu" class="nav navbar-right header-usuario">
        <li class="header-logo"></li>
        <label for="user"></label>
        <li id="user" class="user-mobile-425">
            <img src="{{ asset('img/ico_user.png') }}" alt="" class="icones">
            <span>{{ session()->get('user_logged')->nome }}</span>
            <i class="fas fa-caret-down"></i>

            <ul class="menu2">

                @can('gerente')
                    <li class="container">
                        <a href="{{ route('manage_cost_center') }}">@lang('sidenav.cdc')</a>
                    </li>
                    <li class="container">
                        <a href="{{ route('farms_manager') }}">@lang('sidenav.fazendas')</a>
                    </li>
                    <li class="container">
                        <a href="{{ route('owner_manager') }}">@lang('sidenav.proprietarios')</a>
                    </li>
                @endcan

                @can('supervisor')
                    <li class="container">
                        <a href="{{ route('usuarios_manager') }}">@lang('sidenav.usuarios')</a></li>
                    <li class="container">
                        <a href="{{ route('farms_manager') }}">@lang('sidenav.fazendas')</a></li>
                    <li class="container">
                        <a href="{{ route('owner_manager') }}">@lang('sidenav.proprietarios')</a>
                    </li>
                @endcan

                @can('consultor')
                    <li class="container">
                        <a href="{{ route('farms_manager') }}">@lang('sidenav.fazendas')</a></li>
                    <li class="container">
                        <a href="{{ route('owner_manager') }}">@lang('sidenav.proprietarios')</a>
                    </li>
                @endcan

                @can('assistente')
                    <!--<li class="container"><a href="" class='dropdown-item nav-link'> <i class='fa fa-fw fa-map-signs'></i> @lang('sidenav.fazenda')</a></li>-->
                @endcan

                @can('admin')
                    <li class="container">
                        <i class='fa fa-fw fa-toolbox'></i> <a href="{{ route('admsystem') }}">AdmSystem</a>
                    </li>
                    <!--<li class="container">
                        <i class='fa fa-fw fa-users'></i> <a href="{{ route('usuarios_manager') }}">@lang('sidenav.usuarios')</a>
                    </li>
                    <li class="container">
                        <i class="far fa-money-bill-alt"></i> <a href="{{ route('manage_cost_center') }}">@lang('sidenav.cdc')</a>
                    </li>
                    <li class="container">
                        <i class='fa fa-fw fa-map-signs'></i> <a href="{{ route('farms_manager') }}">@lang('sidenav.fazendas')</a>
                    </li>
                    <li class="container">
                        <i class='fa fa-fw fa-id-card'></i> <a href="{{ route('owner_manager') }}">@lang('sidenav.proprietarios')</a>
                    </li>
                    <li class="container">
                        <i class='fa fa-fw fa-shower'></i> <a href="{{ route('manager_nozzles') }}">@lang('sidenav.bocais')</a>
                    </li>
                    <li class="container">
                        <i class='fa fa-fw fa-tint'></i> <a style="font-size: 12px; padding: 0 12px;" href="{{ route('manager_pivot') }}">@lang('sidenav.pivos')</a>
                    </li>
                    <li class="container">
                        <i class="fas fa-store-alt"></i> <a style="font-size: 12px; padding: 0 12px;" href="{{ route('manager_resales') }}">@lang('sidenav.revendas')</a>
                    </li>-->
                @endcan
            </ul>
        </li>

        <li><img src="{{ asset('img/ico_config.png') }}" class="icones"><i class="fas fa-caret-down "></i>
            <ul class="idioma">
                @if (session()->has('idiomas'))
                    @foreach (Session::get('idiomas') as $idioma)
                        <li class="{{ (Session::get('locale') == $idioma['valor']) ? 'ativo' : '' }}" >
                            <a href="{{ route('language_update', $idioma['valor']) }}"> 
                                <img class="bandeiras" src="{{ asset('img/flags/' . $idioma['valor'] . '.png') }}" alt=""> 
                                @lang('idioma.' . $idioma['valor'])
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </li>

        <li>
            <a href="{{ route('sair') }}" data-toggle="tooltip" data-placement="bottom">
                <img src="{{ asset('img/ico_sair.png') }}" class="icones sair2">
            </a>
        </li>
    </ul>
</div>
