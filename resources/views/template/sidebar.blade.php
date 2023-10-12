<!-- Página web para fonts awesome: https://fontawesome.com/v5/search?o=r&m=free -->


<!-- Sidebar: bg-gradient-warning; bg-gradient-danger; bg-gradient-success -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <br>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" style="margin-top: 30px; margin-bottom: 30px">
        <div class="mx-3 sidebar-brand-text">
            <img src="{{asset('images/logo-ma.png')}}" width="150"><br>
            RESTAURANTE POPULAR
        </div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">


    @can("adm")
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            {{-- Dashboard sendo a rota como do tipo resource
            <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            --}}

            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>


         <!-- Divider -->
         <hr class="sidebar-divider d-none d-md-block">

        <!-- Nav Item - Monitor -->
        <li class="nav-item active">
            <a class="nav-link" href="">
                <i class="fas fa-table"></i>
                <span>Monitor</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Gerenciar
        </div>

        <!-- Nav Item - Empresas -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.empresa.index') }}">
                <i class="fas fa-city"></i>
                <span>Empresas</span>
            </a>
        </li>

        {{--
        <!-- Nav Item - Companhias -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.companhia.index') }}">
                <i class="fas fa-city"></i>
                <span>Companhias</span>
            </a>
        </li>
        --}}

        <!-- Nav Item - Restaurantes -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.restaurante.index') }}">
                <i class="fas fa-utensils"></i>
                <span>Restaurantes</span>
            </a>
        </li>

        <!-- Nav Item - Usuários COM PERFIL DE ADMINISTRADOR, NUTRICIONISTA, INATIVO -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user.index') }}">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Usuários</span>
            </a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">


        <!-- Heading
            <div class="sidebar-heading">
                Outros...
            </div>
        -->






        <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Suporte</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-2 bg-white rounded collapse-inner">
                        <h6 class="collapse-header">Tabelas de Suporte:</h6>
                        <a class="collapse-item" href="{{ route('admin.regional.index') }}"><i class="fas fa-globe-americas"></i>
                            Regionais</a>
                        <a class="collapse-item" href="{{ route('admin.municipio.index') }}"><i class="fas fa-map-marked-alt"></i>
                            Municípios</a>
                        <a class="collapse-item" href="{{ route('admin.bairro.index') }}"><i class="fas fa-location-arrow"></i>
                            Bairros</a>
                        <a class="collapse-item" href="{{ route('admin.categoria.index') }}"><i class="fas fa-stream"></i></i>
                            Categorias</a>
                        <a class="collapse-item" href="{{ route('admin.produto.index') }}"><i class="fas fa-leaf"></i>
                            Produtos</a>
                        <a class="collapse-item" href="{{ route('admin.medida.index') }}"><i class="fas fa-weight"></i>
                            Medidas</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            {{--
            <!-- Nav Item - Usuários COM PERFIL DE ADMINISTRADOR, NUTRICIONISTA, INATIVO -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user.index') }}">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Usuários</span>
                </a>
            </li>
            --}}


            <!-- Nav Item - Pages Collapse Menu
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Configurações</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-2 bg-white rounded collapse-inner">
                        <h6 class="collapse-header">Recursos</h6>
                        <a class="collapse-item" href="#">Paises</a>
                        <a class="collapse-item" href="buttons.html">Estados</a>
                        <a class="collapse-item" href="buttons.html">Municípios</a>
                        <a class="collapse-item" href="cards.html">Bairros</a>
                    </div>
                </div>
            </li>
            -->
        @endcan



        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompra"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-fw fa-cog"></i>
                <span>Compras</span>
            </a>
            <div id="collapseCompra" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 bg-white rounded collapse-inner">
                    <h6 class="collapse-header">Operação de Compras:</h6>
                    <a class="collapse-item" href="{{route('admin.registroconsultacompra.index')}}"><i class="fas fa-shopping-cart"></i>
                        Registros</a>
                    <a class="collapse-item" href="{{route('admin.registroconsultacompra.search') }}"><i class="fas fa-search-dollar"></i>
                        Consultas</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider d-none d-md-block">




    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="border-0 rounded-circle" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
