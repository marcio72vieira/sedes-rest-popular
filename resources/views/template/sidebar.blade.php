<!-- Página web para fonts awesome: https://fontawesome.com/v5/search?o=r&m=free -->


<!-- Sidebar: bg-gradient-warning; bg-gradient-danger; bg-gradient-success -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <br>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">RESTAURANTE POPULAR <br> </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" {{-- href="{{route('admin.dashboard') --}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
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
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Tabelas de Suporte:</h6>
                    <a class="collapse-item" href="{{ route('admin.municipio.index') }}"><i class="fas fa-globe-americas"></i>
                        Municípios</a>
                    <a class="collapse-item" href="{{ route('admin.bairro.index') }}"><i class="fas fa-location-arrow"></i>
                        Bairros</a>
                    <a class="collapse-item" href="{{ route('admin.categoria.index') }}"><i class="fas fa-list"></i>
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
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Recursos</h6>
                    <a class="collapse-item" href="#">Paises</a>
                    <a class="collapse-item" href="buttons.html">Estados</a>
                    <a class="collapse-item" href="buttons.html">Municípios</a>
                    <a class="collapse-item" href="cards.html">Bairros</a>
                </div>
            </div>
        </li>
        -->


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
