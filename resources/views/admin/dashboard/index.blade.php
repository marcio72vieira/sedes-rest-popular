@extends('template.templateadmin')

@section('content-page')

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>


    <!-- INICIO Content Row CARDS-->
    <div class="row">

        <!-- Empresas -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Empresas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totEmpresas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-city fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Nutricionistas -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nutricionistas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totNutricionistas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Usuarios -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totUsuarios }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Regionais -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Regionais</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $regionais->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-globe-americas fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Municípios -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Municípios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totMunicipios }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurantes -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Restaurantes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totRestaurantes}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Compras -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            {{-- <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Compras / Mês</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totComprasGeral }} / {{ $totComprasMes }}</div> --}}
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Compras</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totComprasMes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Valor Total -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalValorCompras, 2, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- Valor Compras Normal-->
         <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Compra Normal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totComprasNormal, '2', ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Valor Compras AF-->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Compras AF</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totComprasAf, '2', ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Categorias-->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Categorias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categorias->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stream fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Produtos-->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Produtos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $produtos->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-leaf fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{--
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pontos Coletas
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        --}}

    </div>
    <!-- FIM Content Row CARDS-->


    <!-- INÍCIO Content Row GRÁFICOS -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    {{-- <h6 class="m-0 font-weight-bold text-primary">GRÁFICOS</h6>
                    <input type="month" id="start" name="start"> --}}
                    <div class="dropdown">
                        <a class="dropdown-toggle font-weight-bold text-primary" href="#" role="button" id="dropdownMenuDados"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                            Dados
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuDados">
                            <div class="dropdown-header">Gerais:</div>
                            <a class="dropdown-item tipodadosgraficopadrao psdlink">Produtos</a>
                            <a class="dropdown-item tipodadosgraficopadrao psdlink">Categorias</a>
                            <a class="dropdown-item tipodadosgraficopadrao psdlink">Regionais</a>
                        </div>
                    </div>

                    <div class="dropdown no-arrow">
                        {{-- <a class="dropdown-toggle font-weight-bold text-primary" href="#" role="button" id="dropdownMenuTipografico"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                            Estilo
                        </a> --}}
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuTipografico"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuTipografico">
                            <div class="dropdown-header">Estilo do Gráfico:</div>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="bar"><span><i class="fas fa-chart-bar"></i></span> Coluna</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="horizontalBar"><span><i class="fas fa-stream"></i> Barra</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="pie"><span><i class="fas fa-chart-pie"></i> Pizza</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="line"><span><i class="fas fa-chart-line"></i> Linha</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="doughnut"><span><i class="fas fa-circle-notch"></i> Rosca</a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header"><i class="fas fa-cubes"></i> Pilha:</div>
                            {{-- <a class="dropdown-item estilograficoempilhado psdlink"><i class="fas fa-cubes"></i> Pilha</a> --}}
                            <a class="dropdown-item estilograficoempilhado psdlink"> Normal x AF</a>
                            {{-- <a class="dropdown-item estilograficoempilhadocategoriaproduto psdlink"> Categoria (produtos)</a> --}}
                            {{--<a class="dropdown-item estilograficoempilhadoregionalcategoria psdlink"> Regionais (produtos)</a>--}}
                            {{--<a class="dropdown-item estilograficoempilhadoregionalcategoria psdlink"> Regionais (categorias)</a>--}}
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    {{-- chartJS 3.9.1 --}}
                    <div id="areaparagraficos" style="width: 100%; height: 500px;">
                        <canvas id="myChartArea"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela Tradução -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tradução</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="max-height: 470px; overflow: auto;">{{-- <div class="chart-pie pt-4 pb-2"> <canvas id="myPieChart"></canvas> </div>  --}}
                    <table class="tabelatraducao">
                        @php
                            $somacompra = 0;
                            $porcentagemcompra = 0;

                            //Dados vindo da view via método compact
                            if(count($dataRecords))  {
                                // Obtém o valor da soma de todas as compras realizadas, para cálculo da %
                                foreach ($dataRecords as $value) {
                                    $somacompra = $somacompra + $value;
                                }

                                echo "<tr><td colspan='3' class='titulotraducao'>COMPRAS POR PRODUTOS</td></tr>";
                                echo "<tr><td class='subtitulolabeltraducao'>Nome</td><td class='subtitulovalortraducao'>Valor</td><td class='subtitulovalortraducao'>%</td>";
                                echo "</tr>";
                                foreach ($dataRecords as $key => $value) {
                                    // Calcula a porcentagem da compra do produto atual
                                    $porcentagemcompra = (($value * 100) / $somacompra);

                                    echo "<tr class='destaque'><td class='dadoslabel'>".$key."</td><td class='dadosvalor'>".number_format($value, 2, ',', '.')."</td><td class='dadosvalor'>".number_format($porcentagemcompra, 2, ',', '.')."</td></tr>";
                                    //$somacompra = $somacompra += $value;
                                }
                                echo "<tr class='totaldadosvalor'><td class='dadoslabel'> Total GERAL</td><td class='dadosvalor'>".number_format($somacompra, 2, ',', '.')."</td><td class='dadosvalor'>".number_format(100, 2, ',', '.')."</td></tr>";
                            }
                        @endphp
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Content Row GRÁFICOS -->

    {{-- 
    <!-- INÍCIO MEUS GRÁFICOS LINHA MÊS a MÊS -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div>
                    <h5 class="card-header" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">Comparativo de Compra Mensal (Normal x Agricultara Familiar)</h5>
                    <div class="card-header"  style="float: right; margin-top: -41px;">
                        <div class="dropdown no-arrow">
                            <!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDadosMesMes"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                Dados
                            </a> -->
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDadosMesMes"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <!-- Div: psdmenu-mrc, sem função alguma, só para envolver a div: dropdown-menu e modificar seu estilo no arquivo mystyles.css
                                 a fim de não afetar o estilo das demais divis que possui a mesma class (dropdown-menu -->
                            <div class="psdmenu-mrc">
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuDadosMesMes">
                                    <a class="dropdown-item psdlink entidademesames" data-entidademesames="Geral"  data-id="0">Geral</a>

                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header"><i class="fas fa-cubes"></i> Regionais: {{$regionais->count()}}</div>
                                    @foreach($regionais as $registroentidade)
                                        <div style="float: left">
                                            <div style="width: 13rem;">
                                            <a class="dropdown-item psdlink entidademesames" data-entidademesames="Regionais" data-id="{{$registroentidade->id}}">{{$registroentidade->nome}}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div style="clear: both"></div>

                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header"><i class="fas fa-cubes"></i> Categorias: {{$categorias->count()}}</div>
                                    @foreach($categorias as $registroentidade)
                                        <div style="float: left">
                                            <div style="width: 9rem">
                                                <a class="dropdown-item psdlink entidademesames" data-entidademesames="Categorias" data-id="{{$registroentidade->id}}">{{$registroentidade->nome}}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div style="clear: both"></div>

                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header"><i class="fas fa-cubes"></i> Produtos:  {{$produtos->count()}}</div>
                                    @foreach($produtos as $registroentidade)
                                        <div style="float: left">
                                            <div style="width: 7rem">
                                                <a class="dropdown-item psdlink entidademesames" data-entidademesames="Produtos" data-id="{{$registroentidade->id}}">{{$registroentidade->nome}}</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="width: 100%; height: 20%; background-color: white;">
                        <div id="areaparagraficosmesames">
                            <canvas id="graficoLinha" width="200" height="40" style="padding: 10px 5px 5px 5px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM MEUS GRÁFICOS LINHA MÊS a MÊS -->
    --}}
    



    <!-- INÍCIO GRÁFICOS MONITOR MÊS A MÊS REGIONAL - MUNICIPIO - RESTAURANTE  -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="pesquisaMonitor">
                   {{--  <h5 class="card-header" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">
                        Comparativo de Compra Mensal (Normal x Agricultara Familiar) por Município ou Restaurante
                    </h5> --}}
                    <div class="card-header ">
                        <div class="form-row">
                            <div class="col-md-3">
                                {{-- <label for="selectRegional"  style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; " class="col-form-label col-form-label-sm">Regional:</label> --}}
                                <select id="selectRegional_id" class="form-control col-form-label-sm">
                                    <option value="0" selected>Regional...</option>
                                    @foreach($regionais as $regional)
                                        <option value="{{$regional->id}}">{{$regional->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                {{-- <label for="selectMuniciopio"  style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; " class="col-form-label col-form-label-sm">Município:</label> --}}
                                <select id="selectMunicipio_id" class="form-control col-form-label-sm">
                                    <option value="0" selected>Município...</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                {{-- <label for="selectRestaurante"  style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; " class="col-form-label col-form-label-sm">Restaurante:</label> --}}
                                <select id="selectRestaurante_id" class="form-control col-form-label-sm">
                                    <option  value="0" selected>Restaurante...</option>
                                </select>
                            </div>

                            {{-- <div class="col-md-1">
                                {{-- <label for="selectMes"  style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; " class="col-form-label col-form-label-sm">Mês:</label>
                                <select id="selectMes" class="form-control col-form-label-sm">
                                    <option value="0" selected>Mês...</option>
                                    <option value="1">janeiro</option>
                                    <option value="2">fevereiro</option>
                                    <option value="3">março</option>
                                    <option value="4">abril</option>
                                    <option value="5">maio</option>
                                    <option value="6">junho</option>
                                    <option value="7">julho</option>
                                    <option value="8">agosto</option>
                                    <option value="9">setembro</option>
                                    <option value="10">outubro</option>
                                    <option value="11">novembro</option>
                                    <option value="12">dezembro</option>
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-1">
                                <button type="button" class="btn btn-outline-info btn-sm" id="exibirdadosmonitor" style="margin-left: 30px; margin-top: 4px; padding-top: 2px; padding-bottom: 0px">Exibir</button>
                            </div> --}}
                        </div>
                    </div>

                    {{-- <div class="card-header"  style="float: right; margin-top: -81px; border-bottom: 1px solid #f8f9fc;"> Utilizado com a exibição da tag's: <label for="selectMes"> acima --}}
                    <div class="card-header"  style="float: right; margin-top: -51px; border-bottom: 1px solid #f8f9fc;">
                        <div class="dropdown no-arrow">
                            {{-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDadosMesMes"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                Dados
                            </a> --}}
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDadosMesMesRestaurante"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            {{-- Div: psdmenu-mrc, sem função alguma, só para envolver a div: dropdown-menu e modificar seu estilo no arquivo mystyles.css
                                 a fim de não afetar o estilo das demais divis que possui a mesma class (dropdown-menu --}}
                            <div class="psdmenu-mrc">
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuDadosMesMes">
                                    <a class="dropdown-item psdlink entidademesamesmonitor" data-entidademesamesmonitor="Geral"  data-id="0">Geral</a>

                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header"><i class="fas fa-cubes"></i> Categorias: {{$categorias->count()}}</div>
                                    @foreach($categorias as $registroentidade)
                                        <div style="float: left">
                                            <div style="width: 9rem">
                                                <a class="dropdown-item psdlink entidademesamesmonitor" data-entidademesamesmonitor="Categorias" data-id="{{$registroentidade->id}}">{{$registroentidade->nome}}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div style="clear: both"></div>

                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header"><i class="fas fa-cubes"></i> Produtos:  {{$produtos->count()}}</div>
                                    @foreach($produtos as $registroentidade)
                                        <div style="float: left">
                                            <div style="width: 7rem">
                                                <a class="dropdown-item psdlink entidademesamesmonitor" data-entidademesamesmonitor="Produtos" data-id="{{$registroentidade->id}}">{{$registroentidade->nome}}</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="width: 100%; height: 20%; background-color: white;">
                        <div id="areaparagraficosmesamesmonitor">
                            <canvas id="graficomesamesMonitor" width="200" height="40" style="padding: 10px 5px 5px 5px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM GRÁFICOS MONITOR MÊS A MÊS REGIONAL - MUNICIPIO - RESTAURANTE -->





    <!-- INÍCIO OUTROS DADOS - VISUALIZAÇÃO RÁPIDA E INFORMAÇÕES -->
    <div class="row">
        {{-- Outros dados --}}
        <div class="col-xl-5 col-lg-6">
            <div class="card shadow mb-4">
                <div>
                    <h5 class="card-header" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">Visualização Rápida</h5>
                    <div class="card-header"  style="float: right; margin-top: -41px;">
                        <div class="dropdown no-arrow">
                            {{-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuEntidade"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                Entidade
                            </a> --}}
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuEntidade"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuEntidade">
                                <div class="dropdown-header">Entidade:</div>
                                <a class="dropdown-item tabentidade psdlink">Usuários</a>
                                <a class="dropdown-item tabentidade psdlink">Empresas</a>
                                <a class="dropdown-item tabentidade psdlink">Nutricionistas</a>
                                <a class="dropdown-item tabentidade psdlink">Regionais</a>
                                <a class="dropdown-item tabentidade psdlink">Municípios</a>
                                <a class="dropdown-item tabentidade psdlink">Categorias</a>
                                <a class="dropdown-item tabentidade psdlink">Produtos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="width: 100%; height: 20%; background-color: white;">
                        <div style="height:400px; overflow: auto;">
                            <table class="tabelaentidade">
                                @php
                                    //Dados vindo da view via método compact
                                    if(count($usuarios))  {
                                        echo "<tr><td colspan='3' class='titulotabelavisualizacao'>USUÁRIOS</td></tr>";
                                        echo "<tr>
                                            <td class='cabecalhotabelavisualizacao' style='width: 2%'>Id</td>
                                            <td class='cabecalhotabelavisualizacao' style='width: 95%'>Nome</td>
                                            <td class='cabecalhotabelavisualizacao' style='width: 3%'>Ativo</td>
                                        </tr>";
                                        foreach ($usuarios as $key => $value) {
                                            echo "<tr class='destaque'>";
                                                echo "<td class='dadoslabel'>".$value->id."</td>";
                                                echo "<td class='dadoslabel regid psdlink' data-id='".$value->id."'>".$value->nomecompleto."</td>";
                                                echo "<td class='dadoslabel' style='text-align:center'>".($value->perfil != "ina" ? '<b><i class="fas fa-check text-success mr-2"></i></b>' : '<b><i class="fas fa-times  text-danger mr-2"></i></b>')."</td>";
                                            echo "</tr>";
                                        }
                                    }
                                @endphp
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informações --}}
        <div class="col-xl-7 col-lg-6">
            <div class="card shadow mb-4">
                <div>
                    <h5 class="card-header" id="headinformacaoes" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">Informações</h5>
                </div>
                <div class="card-body" style="height: 440px; overflow: auto;">
                    <div style="width: 100%;">
                        <div>
                            <table id="informacoes" style="width: 100%"> </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM OUTROS DADOS  - VISUALIZAÇÃO RÁPIDA E INFORMAÇÕES -->

</div>

@endsection

@section('scripts')
    @php
        //Configurando os labels para os gráficos
        if(count($dataRecords)){
            //Recuperando só as chaves do array, que será o label dos registros
            $labelRecords = array_keys($dataRecords);

            $arrLabel = [];
            foreach($labelRecords as $labelRecord){
                // Substitui caracteres especiais (' " / . ,) em uma string por espaço vazio. Evita erro. Ex: farinha D'agua = faria Dagua
                $arrbusca = ["'","/","."];
                $arrtroca = [""];
                $labelRecord = str_replace($arrbusca, $arrtroca, $labelRecord);

                // Faz uma concatenação do tipo: 'labelX', 'labelY', 'labelZ', 'labelW', etc...
                $arrLabel[] = "'".$labelRecord."'";     //dd($arrLabel);
            }
        }


        // Obtendo os valores das médias de preços por semana AF e NORMAL (antigo meu gráfico de linha)
        // if(count($dataRecordsMediaPrecoAf)){
        //     $dataAf =  array_values($dataRecordsMediaPrecoAf);
        // }
        // if(count($dataRecordsMediaPrecoNorm)){
        //     $dataNormal =  array_values($dataRecordsMediaPrecoNorm);
        // }

        /*
        // Obtendo os valores das compras Normal e AF mês a mês
        if(count($compras_af)){
            $dataAf =  array_values($compras_af);
        }
        if(count($compras_norm)){
            $dataNormal =  array_values($compras_norm);
        }
        */



        // Obtendo os valores das compras Normal e AF mês a mês para gráfico monitor, para cálculo de porcentagem
        $valorTotalCompraNoMesAfNorm =  [];
        $percentAFmesatual = [];
        $percentNORMmesatual = [];

        for($c = 0; $c < 12; $c++){

            $valorTotalCompraNoMesAfNorm[$c] = $compras_af[$c] + $compras_norm[$c];

            // Evitando divisão por 0 (zero)
            $valorTotalCompraNoMesAfNorm[$c] = ($valorTotalCompraNoMesAfNorm[$c] != 0 ? $valorTotalCompraNoMesAfNorm[$c] : 1);

            $percentAFmesatual[$c] = number_format((($compras_af[$c] * 100) / $valorTotalCompraNoMesAfNorm[$c]), '1', '.', '');
            $percentNORMmesatual[$c] = number_format((($compras_norm[$c] * 100) / $valorTotalCompraNoMesAfNorm[$c]), '1', '.', '');

            // Escondendo o 0 (zeros) na exibição dos valores no gráfico
            $percentAFmesatual[$c] = $percentAFmesatual[$c] > 0 ? $percentAFmesatual[$c] : '';
            $percentNORMmesatual[$c] = $percentNORMmesatual[$c] > 0 ? $percentNORMmesatual[$c] : '';

        }

        $dataAf =  array_values($percentAFmesatual);
        $dataNormal =  array_values($percentNORMmesatual);
    @endphp


    <script>
        $(document).ready(function() {

            //Renderiza o gráfico padrão com dados vindo do método compact da view, logo que a página é carregada.
            renderGrafico("bar");

            //Definindo as variáveis de forma Global (fora de qualquer função) para que possam ser acessadas livremente.
            var estilo = "";
            var tipodados = "";
            var valorLabels = [];
            var valorData = [];

            //Gráficos empilhados
            var valorDataNormal = [];
            var valorDataAf = [];
            var somaCompra = 0;
            var porcentagemCompra = 0;
            var somaCompraNormal = 0;
            var somaCompraAf = 0;

            var valorTituloGrafico =  "";

            //Gráfico mês a mês
            var tipoentidademesames = "";
            var nomeregistomesames = "";
            var idregsentidademesames = "";

            var valorTituloMesaMes = "";
            var valornormalMesaMes = [];
            var valorafMesaMes = [];

            //Gráfico mês a mês monitor
            var tipoentidademesamesmonitor = "";
            var nomeregistomesamesmonitor = "";
            var idregsentidademesamesmonitor = "";

            var valorTituloMesaMesmonitor = "";
            var valorSubTituloMesaMesmonitor = "";
            var valornormalMesaMesmonitor = [];
            var valorafMesaMesmonitor = [];

            //Informações rápidaas

            var entidade = "";
            var identidade = 0;
            var identificadorreg = 0;



            //ALTERAÇÃO DO ESTILO DE GRÁFICO
            $('.estilografico').on('click', function() {

                //Define o estilo do gráfico
                estilo = $(this).data('estilo-grafico');

                //Logo que a página é carregada, tipodado não está definido, então renderiza-se o gráfico padrão (bar) com os dados padrão (produtos), vindos
                //do método compact da view
                if(tipodados == ""){
                    renderGrafico(estilo);
                }else{
                    //Obs: Nesse momento valorTituloGrafico recebe o valor definido globalmente.
                    renderGraficoDinamico(estilo, tipodados, valorLabels, valorData, valorTituloGrafico);
                }

            });



            //Início do estilo do gráfico do tipo pilha
            $('.estilograficoempilhado').on('click', function() {

                if(tipodados == ""){
                    tipodadosEmpilhado = " Produtos";   //alert("Nenhum DADO foi escolhido " + tipodadosEmpilhado);
                }else{
                    tipodadosEmpilhado = tipodados;     //alert("DADO já escolhido" + tipodadosEmpilhado);
                }


                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosgraficoempilhado')}}",
                    type: "GET",
                    data: {
                        tipodados: tipodadosEmpilhado
                    },
                    dataType : 'json',

                    success: function(result){

                        //Zerando o valor das variáveis globais para este tipo de gráfico (empilhado)
                        valorLabels = [];
                        valorDataNormal = [];
                        valorDataAf = [];
                        somaCompra = 0;
                        porcentagemCompra = 0;
                        somaCompraNormal = 0;
                        somaCompraAf = 0;
                        valorTituloGrafico = '';

                        //Atribuindo os respecitvos arrays
                        valorLabels = result['labels'];
                        valorDataNormal = result['compranormal'];
                        valorDataAf = result['compraaf'];
                        valorTituloGrafico = result['titulo'];

                        //Renderiza gráfico passando as informações necessárias
                        renderGraficoDinamicoEmpilhado(valorLabels, valorDataNormal, valorDataAf, valorTituloGrafico);

                        //Atualiza a tabela tradução
                        $(".tabelatraducao").html('');
                        $(".tabelatraducao").append('<tr><td colspan="4" class="titulotraducao">'+ valorTituloGrafico +'</td></tr>');
                        $(".tabelatraducao").append('<tr><td class="subtitulolabeltraducao">'+ tipodadosEmpilhado +'</td><td class="subtitulovalortraducao">Normal</td><td class="subtitulovalortraducao">AF</td><td class="subtitulovalortraducao">Total</td></tr>');

                        //Itera sobre os dados retornados pela requisição Ajax
                        $.each(result['dados'], function(key,value){

                            somaCompraNormal = somaCompraNormal += Number(value.totalcompranormal);
                            somaCompraAf = somaCompraAf += Number(value.totalcompraaf);
                            somaCompra = somaCompra += Number(value.totalcompra);

                            $(".tabelatraducao").append('<tr class="destaque"><td class="dadoslabel">' + value.nome + '</td><td class="dadosvalor">' + number_format(value.totalcompranormal,2,",",".") + '</td><td class="dadosvalor">' + number_format(value.totalcompraaf,2,",",".") + '</td><td class="dadosvalor">' + number_format(value.totalcompra,2,",",".") + '</td></tr>');
                        });

                        $(".tabelatraducao").append('<tr class="totaldadosvalor"><td class="dadoslabel">Total GERAL</td><td class="dadosvalor">' + number_format(somaCompraNormal,2,",",".") + '</td><td class="dadosvalor">' + number_format(somaCompraAf,2,",",".") + '</td><td class="dadosvalor">' + number_format(somaCompra,2,",",".") + '</td></tr>');
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });
            //Fim do estilo do gráfico do tipo pilha


            //Início gráfico mês a mês
            $(".entidademesames").on("click", function(){

                //alert("Entidade escolhida é: " + $(this).data('entidademesames') + ": " + $(this).text().trim() + ", id: " + $(this).data('id'));
                //Recupera o tipo de entidade (Regionais, Categorias ou Produto) e o respectivo id do registro escolhido
                tipoentidademesames = $(this).data('entidademesames');
                nomeregistomesames = $(this).text().trim();
                idregsentidademesames = $(this).data('id');


                //Faz requisição para obter datos do registro da entidade
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosgraficomesames')}}",
                    type: "GET",
                    data: {
                        tipoentidade: tipoentidademesames,
                        nomeregistroentidade: nomeregistomesames,
                        idregistroentidade: idregsentidademesames
                    },
                    dataType : 'json',

                    //Obs:  "result", recebe o valor retornado pela requisição Ajax (result = $data), logo como resultado, temos:
                    //      result['titulo'], result['comprasAF'] e result['comprasNORM'] que são arrays.
                    success: function(result){

                        //Zerando o valor das variáveis globais do tipo array
                        valornormalMesaMes = [];
                        valorafMesaMes = [];
                        valorTituloMesaMes = "";

                        valornormalMesaMes = result['comprasNORM'];
                        valorafMesaMes = result['comprasAF'];
                        valorTituloMesaMes = result['titulo'];

                        //Renderiza gráfico passando as informações necessárias
                        renderGraficoDinamicoMesaMes(valornormalMesaMes, valorafMesaMes, valorTituloMesaMes);

                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });


            //####### MONITOR ##################
            //Início gráfico mês a mês monitor $(this).parents(".linhaDados").find(".produto_id").val();
            //##################################
            $(".entidademesamesmonitor").on("click", function(){

                //alert("Entidade escolhida é: " + $(this).data('entidademesamesmonitor') + ": " + $(this).text().trim() + ", id: " + $(this).data('id'));
                //Recupera o tipo de entidade (Geral, Categorias ou Produto) e o respectivo id do registro escolhido
                tipoentidademesamesmonitor = $(this).data('entidademesamesmonitor');
                nomeregistomesamesmonitor = $(this).text().trim();
                idregsentidademesamesmonitor = $(this).data('id');

                //Capturando os valores dos select
                var selecaoRegional = $(this).parents(".pesquisaMonitor").find("#selectRegional_id").val();
                var selecaoMunicipio = $(this).parents(".pesquisaMonitor").find("#selectMunicipio_id").val();
                var selecaoRestaurante = $(this).parents(".pesquisaMonitor").find("#selectRestaurante_id").val();
                // alert("Regional: " + selecaoRegional + "; Município: " + selecaoMunicipio + "; Restaurante: " + selecaoRestaurante);

                //Capturando os textos dos selects
                var textSelecaoRegional = $("#selectRegional_id option:selected").text();
                var textSelecaoMunicipio = $("#selectMunicipio_id option:selected").text();
                var textSelecaoRestaurante = $("#selectRestaurante_id option:selected").text();
                // alert("Regional: " + textSelecaoRegional + "; Município: " + textSelecaoMunicipio + "; Restaurante: " + textSelecaoRestaurante);


                //Faz requisição para obter datos do registro da entidade
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosgraficomesamesmonitor')}}",
                    type: "GET",
                    data: {
                        tipoentidade: tipoentidademesamesmonitor,
                        nomeregistroentidade: nomeregistomesamesmonitor,
                        idregistroentidade: idregsentidademesamesmonitor,
                        idReg: selecaoRegional,
                        idMuni: selecaoMunicipio,
                        idRest: selecaoRestaurante,
                        txtReg: textSelecaoRegional,        //Utilizado para montar o título do gráfico
                        txtMuni: textSelecaoMunicipio,      //Utilizado para montar o título do gráfico
                        txtRest: textSelecaoRestaurante     //Utilizado para montar o título do gráfico
                    },
                    dataType : 'json',

                    //Obs:  "result", recebe o valor retornado pela requisição Ajax (result = $data), logo, como resultado, temos:
                    //      result['titulo'], result['comprasAF'] e result['comprasNORM'] que são arrays.
                    success: function(result){

                        //Zerando o valor das variáveis globais do tipo array
                        valorafMesaMesmonitor = [];
                        valornormalMesaMesmonitor = [];
                        valorTituloMesaMesmonitor = "";
                        valorSubTituloMesaMesmonitor = "";

                        valorafMesaMesmonitor = result['comprasAF'];
                        valornormalMesaMesmonitor = result['comprasNORM'];
                        valorTituloMesaMesmonitor = result['titulo'];
                        valorSubTituloMesaMesmonitor = result['subtitulo'];


                        //  Início - TRANSFORMANDO VALORES EM PORCENTAGEM.
                        //  Para exibir valores, comente este trecho  de código
                            var valorTotalCompraNoMesAfNorm = [];
                            var percentAFmesatual = [];
                            var percentNORMmesatual = [];
                            //Itera sobre os dados retornados
                            for(c = 0; c < 12; c++){
                                valorTotalCompraNoMesAfNorm.push(Number(valorafMesaMesmonitor[c]) + Number(valornormalMesaMesmonitor[c]));

                                //Evitando divisão por zero
                                valorTotalCompraNoMesAfNorm[c] = (valorTotalCompraNoMesAfNorm[c] != 0 ? valorTotalCompraNoMesAfNorm[c] : 1);

                                percentAFmesatual[c] = number_format(((Number(valorafMesaMesmonitor[c]) * 100) / valorTotalCompraNoMesAfNorm[c]), '1', '.', '');
                                percentNORMmesatual[c] = number_format(((Number(valornormalMesaMesmonitor[c]) * 100) / valorTotalCompraNoMesAfNorm[c]), '1', '.', '');

                                // Escondendo o 0 (zeros) na exibição dos valores no gráfico
                                percentAFmesatual[c] = percentAFmesatual[c] > 0 ? percentAFmesatual[c] : '';
                                percentNORMmesatual[c] = percentNORMmesatual[c] > 0 ? percentNORMmesatual[c] : '';
                            }

                            valornormalMesaMesmonitor = percentNORMmesatual;
                            valorafMesaMesmonitor = percentAFmesatual;
                        //  Para exibir valores, comente este trecho  de código
                        //  Fim - TRANSFORMANDO VALORES EM PORCENTAGEM.


                        //Renderiza gráfico passando as informações necessárias
                        renderGraficoDinamicoMesaMesMonitor(valornormalMesaMesmonitor, valorafMesaMesmonitor, valorTituloMesaMesmonitor, valorSubTituloMesaMesmonitor);

                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });


            $("#exibirdadosmonitor").on("click", function() {
                alert("Buscar informações!");

                var valorselectRegional_id = 0;
                var valorselectMunicipio_id = 0;
                var valorselectRestaurante_id = 0;

            });
            //####### MONITOR ##################
            // Fim  gráfico mês a mês monitor
            //##################################



            //Inicio do estilo do gráfico tipo pilha categoria produto
            /*
            $('.estilograficoempilhadocategoriaproduto').on('click', function() {

                var tipodadosEmpilhadoCategoria = "Categorias";   //alert("GRAFICO DADO foi escolhido " + tipodadosEmpilhadoCategoria);

                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosgraficoempilhadocategoriaproduto')}}",
                    type: "GET",
                    data: {
                        tipodadoscategoria: tipodadosEmpilhadoCategoria
                    },
                    dataType : 'json',

                    success: function(result){

                        // alert(result['titulo']);
                        // alert(result['labelsCat']); //new Set(chars);
                        // var CategPro = [...new Set(result['labelsCat'])];
                        // alert(CategPro);
                        // alert(result['labelsProd']);
                        // alert(result['valuesCompra']);


                        //Zerando o valor das variáveis globais para este tipo de gráfico (empilhado)
                        // valorLabels = [];
                        // valorDataNormal = [];
                        // valorDataAf = [];
                        // somaCompra = 0;
                        // somaCompraNormal = 0;
                        // somaCompraAf = 0;
                        // valorTituloGrafico = '';


                        //Atribuindo os respecitvos arrays
                        valorLabels = [...new Set(result['labelsCat'])];
                        //valorDataNormal = result['compranormal'];
                        //valorDataAf = result['compraaf'];
                        valorDataNormal = [30, 40, 50, 50, 70];
                        valorDataAf = [10, 15, 20, 25, 25];
                        valorTituloGrafico = result['titulo'];

                        //Renderiza gráfico passando as informações necessárias
                        //renderGraficoPilhaCategoriaProduto(valorLabels, valorTituloGrafico, conjuntoDeDados);
                        renderGraficoPilhaCategoriaProduto(valorLabels, valorTituloGrafico, cordeFundo, cordaBorda);

                        //Atualiza a tabela tradução
                        $(".tabelatraducao").html('');
                        $(".tabelatraducao").append('<tr><td colspan="4" class="titulotraducao">'+ valorTituloGrafico +'</td></tr>');
                        $(".tabelatraducao").append('<tr><td class="subtitulolabeltraducao">'+ 'tipodadosEmpilhado' +'</td><td class="subtitulovalortraducao">Normal</td><td class="subtitulovalortraducao">AF</td><td class="subtitulovalortraducao">Total</td></tr>');

                        //Itera sobre os dados retornados pela requisição Ajax
                        $.each(result['dados'], function(key,value){

                            somaCompraNormal = somaCompraNormal += Number(value.totalcompranormal);
                            somaCompraAf = somaCompraAf += Number(value.totalcompraaf);
                            somaCompra = somaCompra += Number(value.totalcompra);

                            $(".tabelatraducao").append('<tr class="destaque"><td class="dadoslabel">' + value.nome + '</td><td class="dadosvalor">' + number_format(value.totalcompranormal,2,",",".") + '</td><td class="dadosvalor">' + number_format(value.totalcompraaf,2,",",".") + '</td><td class="dadosvalor">' + number_format(value.totalcompra,2,",",".") + '</td></tr>');
                        });

                        $(".tabelatraducao").append('<tr class="totaldadosvalor"><td class="dadoslabel">Total GERAL</td><td class="dadosvalor">' + number_format(somaCompraNormal,2,",",".") + '</td><td class="dadosvalor">' + number_format(somaCompraAf,2,",",".") + '</td><td class="dadosvalor">' + number_format(somaCompra,2,",",".") + '</td></tr>');
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });
            */
            //Fim do estilo do gráfico tipo pilha  categoria produto



            //Escolha de outro tipo de dados além do tipo padrão: "Produtos"
            $(".tipodadosgraficopadrao").on("click", function(){

                //Limpa espaço em branco no texto do link tipodados
                tipodados = $(this).text().trim();

                var urltipo = "";

                //Faz requisição para obter novos dados
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosgrafico')}}",    //urltipo
                    type: "GET",
                    data: {
                        tipodados: tipodados
                    },
                    dataType : 'json',

                    //Obs:  "result", recebe o valor retornado pela requisição Ajax (result = $data), logo como resultado, temos:
                    //      result['titulo'] que é uma string e result['dados'] que é um array
                    success: function(result){

                        //Zerando o valor das variáveis globais do tipo array
                        valorLabels = [];
                        valorData = [];
                        somaCompra = 0;
                        porcentagemCompra = 0;
                        valorTituloGrafico = "";

                        //Iterando sobre o array['dados'] e // Obtém o valor da soma de todas as compras realizadas, para cálculo da %
                        $.each(result['dados'], function(key,value){
                            valorLabels.push(key);
                            valorData.push(value);
                            somaCompra = somaCompra += Number(value);
                        });

                        valorTituloGrafico = result['titulo'];

                        //Se tipo é igual a espaço em branco, é porque nenhum outro estilo de gráfico foi escolhido, permanecendo portanto o padrão "bar"
                        if(estilo == ""){estilo = "bar";}

                        //Renderiza gráfico passando as informações necessárias
                        renderGraficoDinamico(estilo, tipodados, valorLabels, valorData, valorTituloGrafico);

                        //Atualiza a tabela tradução
                        $(".tabelatraducao").html('');
                        $(".tabelatraducao").append('<tr><td colspan="3" class="titulotraducao">'+ valorTituloGrafico +'</td></tr>');
                        $(".tabelatraducao").append('<tr><td class="subtitulolabeltraducao">Nome</td><td class="subtitulovalortraducao">Valor</td><td class="subtitulovalortraducao">%</td></tr>');

                        //Itera sobre os dados retornados pela requisição Ajax
                        $.each(result['dados'], function(key,value){
                            // Calcula a porcentagem da compra do produto atual
                            porcentagemCompra = ((value * 100) / somaCompra);

                            $(".tabelatraducao").append('<tr class="destaque"><td class="dadoslabel">' + key + '</td><td class="dadosvalor">' + number_format(value,2,",",".") + '</td><td class="dadosvalor">' + number_format(porcentagemCompra,2,",",".") + '</td></tr>');
                            //somaCompra = somaCompra += Number(value);
                        });

                        $(".tabelatraducao").append('<tr class="totaldadosvalor"><td class="dadoslabel">Total GERAL</td><td class="dadosvalor">' + number_format(somaCompra,2,",",".") + '</td><td class="dadosvalor">' + number_format(100,2,",",".") + '</td></tr>');
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });


            //*****************************
            // Iníco - VISUALIZAÇÃO RÁPIDA
            //*****************************
            //Escolha de outro tipo de entidade além do tipo padrão: "Usuários"
            $(".tabentidade").on("click", function(){

                $("#informacoes").html('');

                //entidade = $(this).text().trim();

                /* if(entidade == ""){
                    entidade = "Usuários";
                }else{
                    //Limpa espaço em branco no texto do link tipodados
                    entidade = $(this).text().trim();
                } */

                //Limpa espaço em branco no texto do link tipodados
                entidade = $(this).text().trim();

                //Faz requisição para obter novos dados
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosentidades')}}",    //urltipo
                    type: "GET",
                    data: {
                        entidade: entidade
                    },
                    dataType : 'json',

                    success: function(result){

                        titulotabelaentidade =  result['titulo'];

                        //Atualiza a tabela entidade
                        $(".tabelaentidade").html('');
                        $(".tabelaentidade").append('<tr><td colspan="3" class="titulotabelavisualizacao">'+ titulotabelaentidade +'</td></tr>');
                        $(".tabelaentidade").append('<tr><td class="cabecalhotabelavisualizacao" style="width: 2%">Id</td><td class="cabecalhotabelavisualizacao" style="width: 95%">Nome</td><td class="cabecalhotabelavisualizacao" style="width: 3%">Ativo</td></tr>');

                        //Itera sobre os dados retornados pela requisição Ajax
                        $.each(result['dados'], function(key,value){
                            //Essa verificação é necessária, em função da tabela usuários não possuir o campo ativo e sim os perfis: (adm, nut e ina)
                            //Na consulta ao banco, o campo pefil é epelidado de "ativo", para se equiparar aos outros modelos e fazer jus a esta verificação
                            if(value.ativo == 0 || value.ativo == "ina"){
                                statusentidade = "0";
                            } else {
                                statusentidade = "1";
                            }

                            //$(".tabelaentidade").append('<tr class="destaque"><td class="dadoslabel">' + value.id + '</td><td class="dadoslabel regid psdlink" data-id="' + value.id + '">' + value.nome + '</td><td class="dadoslabel" style="text-align:center">' + (value.ativo != "ina" || value.ativo != "0" ? "<b><i class='fas fa-check text-success mr-2'></i></b>" : "<b><i class='fas fa-times text-danger mr-2'></i></b>") + '</td></tr>');
                            $(".tabelaentidade").append('<tr class="destaque"><td class="dadoslabel">' + value.id + '</td><td class="dadoslabel regid psdlink" data-id="' + value.id + '">' + value.nome + '</td><td class="dadoslabel" style="text-align:center">' + (statusentidade == "1" ? "<b><i class='fas fa-check text-success mr-2'></i></b>" : "<b><i class='fas fa-times text-danger mr-2'></i></b>") + '</td></tr>');
                        });
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });
            // Fim Entidade

            //Aqui, houve a necessidade de se aplicar a delegação de eventos, visto que a classe ".regid" é
            //criada dinamicamente na tabela "tabelaentidade".Não fosse assim, não teriamo como ler o id
            //do registro da coluna clicada identificada pelo "data-id", como comentado abaixo
            //$(".regiid").on("click", function(){
            $(".tabelaentidade").on("click", ".regid", function(){

                idreg = $(this).data('id');

                if(entidade == ""){
                    entidade = "Usuários";
                }else {
                    entidade = entidade;
                }

                //Faz requisição para obter novos dados
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperainformacoesregistro')}}",    //urltipo
                    type: "GET",
                    data: {
                        entidade: entidade,
                        idregistro: idreg
                    },
                    dataType : 'json',

                    success: function(result){
                        //Função para preencher tabela com informações
                        preenchetabelainformacao(result);
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });
            //*****************************
            // Fim - VISUALIZAÇÃO RÁPIDA
            //*****************************


            //************************************************************
            // Início SELECT's DINÂMICOS REGIONAL - MUNCÍPIO - RESTAURANTE
            //************************************************************
            //Recuperação dinâmica dos municípios de uma regional
            $('#selectRegional_id').on('change', function() {
                var regional_id = this.value;
                $("#selectMunicipio_id").html('');
                $('#selectRestaurante_id').html('<option value="0">Restaurante...</option>');
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperamunicipiosregionais')}}",
                    type: "GET",
                    data: {
                        idRegional: regional_id
                    },
                    dataType : 'json',
                    success: function(result){
                        $('#selectMunicipio_id').html('<option value="0">Município...</option>');
                        $.each(result.municipios,function(key,value){
                            $("#selectMunicipio_id").append('<option value="'+value.id+'">'+value.nome+'</option>');
                        });
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });

            //Recuperação dinâmica dos restaurantes de um município
            $('#selectMunicipio_id').on('change', function() {
                var municipio_id = this.value;
                $("#selectRestaurante_id").html('');
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperarestaurantesmunicipios')}}",
                    type: "GET",
                    data: {
                        idMunicipio: municipio_id
                    },
                    dataType : 'json',
                    success: function(result){
                        $('#selectRestaurante_id').html('<option value="0">Restaurante...</option>');
                        $.each(result.restaurantes,function(key,value){
                            $("#selectRestaurante_id").append('<option value="'+value.id+'">'+value.identificacao+'</option>');
                        });
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });
            //************************************************************
            // Fim SELECT's DINÂMICOS REGIONAL - MUNCÍPIO - RESTAURANTE
            //************************************************************

        }); // fim $(document).ready(function()



        //**************************************************************************
        // FUNÇÕES PARA RENDERIZAÇÃO DE GRÁFICOS BAR - HORIZONTALBAR - LINHA - ROSCA
        //**************************************************************************
        //Renderiza Gráfico com dados padrão Produtos e o estilo igual a "bar" (Dados vindos via método compac, da view).
        function renderGrafico(estilo){
            //Limpa a área do grafico para evitar sobreposição de informações
            $('#myChartArea').remove();
            $('#areaparagraficos').append('<canvas id="myChartArea"><canvas>');

            const ctx = document.getElementById('myChartArea').getContext('2d');
            const myChart = new Chart(ctx, {
                //ATENÇÃO:  A versão 3.9.1 do ChartJS não suporta o estilo: 'horizontalBar', para alcancar este efeito
                //          deve-se apenas definir a propriedade indexAxis: 'y' no objeto 'options'
                //

                //type: estilo, // versão 2.9.4
                type: (estilo == 'horizontalBar' ? 'bar' : estilo), // versao 3.9.1
                data: {
                    labels: [ {!! implode(',', $arrLabel) !!} ],    //labels: ['GRÃOS', 'HORTALIÇAS', 'PROTEINA ANIMAL', 'VERDURAS'],
                    datasets: [{
                        label: 'Produtos',
                        data: [ {{ implode(',', $dataRecords) }} ], //Dados vindo da view via método compact
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(100, 159, 64, 0.5)',
                            'rgba(100, 255, 192, 0.5)',
                            'rgba(183, 90, 255, 0.5)',
                            'rgba(255, 159, 100, 0.5)', //
                            'rgba(200, 99, 132, 0.5)',
                            'rgba(50, 162, 235, 0.5)',
                            'rgba(210, 206, 86, 0.5)',
                            'rgba(175, 192, 192, 0.5)',
                            'rgba(100, 102, 255, 0.5)',
                            'rgba(210, 159, 64, 0.5)',
                            'rgba(220, 192, 192, 0.5)',
                            'rgba(100, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(100, 159, 64, 1)',
                            'rgba(100, 255, 192, 1)',
                            'rgba(183, 90, 255, 1)',
                            'rgba(255, 159, 100, 1)', //
                            'rgba(200, 99, 132, 1)',
                            'rgba(50, 162, 235, 1)',
                            'rgba(210, 206, 86, 1)',
                            'rgba(175, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)',
                            'rgba(210, 159, 64, 1)',
                            'rgba(220, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)'
                        ],
                        borderWidth: 1,
                        barPercentage: 0.5, //Determina a largura da coluna ou barra
                    }]
                },
                plugins: [ChartDataLabels], // Exibe rótulo dos valores dentro dos gráficos
                options: {
                    scales: {
                        // versão 2.9.4
                        /* yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }] */
                        // versão 3.9.1
                        x: {
                            grid: {
                            offset: true
                            }
                        }
                    },
                    // versão 3.9.1
                    plugins: {
                    // Change options for ALL labels of THIS CHART
                        datalabels: {
                            color: '#0000ff'
                        }
                    },
                    title: {
                        display: true,
                        text: 'COMPRAS POR PRODUTOS'
                    },
                    legend: {
                        display: false,
                    },
                    indexAxis: (estilo == 'horizontalBar' ? 'y' : 'x'),  // versão 3.9.1
                    // Adequa o tamanho dos gráficos conforme o tamanho da div: "#areaparagraficos"
                    maintainAspectRatio: false, // versão 3.9.1
                }
            });

            //Configurações personalizadas se grafico é do tipo linha
            if(myChart.config.type == 'line'){
                myChart.data.datasets[0].backgroundColor = 'rgb(255, 0, 0, 0.5)';
                myChart.data.datasets[0].borderColor = 'rgb(0, 0, 0, 0.2)';
                myChart.data.datasets[0].borderWidth = 3;
                myChart.data.datasets[0].fill = true;
                myChart.options.elements.line.tension = 0;
                myChart.update();
            }

            /*
            chartjs 2.9.4
            //Configurações personalizadas se gráfico é do tipo rosca
            if(myChart.config.type == 'doughnut'){
                myChart.options.maintainAspectRatio = false;
                myChart.options.tooltips.backgroundColor = 'rgb(255,255,255)';
                myChart.options.tooltips.bodyFontColor = '#858796';
                myChart.options.tooltips.borderColor = '#dddfeb';
                myChart.options.tooltips.borderWidth = 1;
                myChart.options.tooltips.xPadding = 15;
                myChart.options.tooltips.yPadding = 15;
                myChart.options.tooltips.displayColors = true;
                myChart.options.tooltips.caretPadding =  10;
                myChart.options.legend.display = true;
                myChart.options.cutoutPercentage =  80;
                myChart.update();
            }
            */
        }



        function renderGraficoDinamico(estilo, tipodados, valorLabels, valorData, titulo){

            //Limpa a área do grafico para evitar sobreposição de informações
            $('#myChartArea').remove();
            $('#areaparagraficos').append('<canvas id="myChartArea"><canvas>');

            const ctx = document.getElementById('myChartArea').getContext('2d');
            const myChart = new Chart(ctx, {
                //type: estilo, // versão 2.9.4
                type: (estilo == 'horizontalBar' ? 'bar' : estilo), // versao 3.9.1
                data: {
                    labels: valorLabels,
                    datasets: [{
                        label: tipodados,
                        data: valorData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(100, 159, 64, 0.5)',
                            'rgba(100, 255, 192, 0.5)',
                            'rgba(183, 90, 255, 0.5)',
                            'rgba(255, 159, 100, 0.5)', //
                            'rgba(200, 99, 132, 0.5)',
                            'rgba(50, 162, 235, 0.5)',
                            'rgba(210, 206, 86, 0.5)',
                            'rgba(175, 192, 192, 0.5)',
                            'rgba(100, 102, 255, 0.5)',
                            'rgba(210, 159, 64, 0.5)',
                            'rgba(220, 192, 192, 0.5)',
                            'rgba(100, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(100, 159, 64, 1)',
                            'rgba(100, 255, 192, 1)',
                            'rgba(183, 90, 255, 1)',
                            'rgba(255, 159, 100, 1)', //
                            'rgba(200, 99, 132, 1)',
                            'rgba(50, 162, 235, 1)',
                            'rgba(210, 206, 86, 1)',
                            'rgba(175, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)',
                            'rgba(210, 159, 64, 1)',
                            'rgba(220, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)'
                        ],
                        borderWidth: 2,
                        barPercentage: 0.5, //Determina a largura da coluna ou barra
                        fill: false,

                    }]
                },
                plugins: [ChartDataLabels], // Exibe rótulo dos valores dentro dos gráficos
                options: {
                    scales: {
                        /*
                        versao 2.9.4
                         yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }] */
                        // versão 3.9.1
                        x: {
                            grid: {
                            offset: true
                            }
                        }
                    },
                    // versão 3.9.1
                    plugins: {
                    // Change options for ALL labels of THIS CHART
                        datalabels: {
                            color: '#0000ff'
                        }
                    },
                    title: {
                        display: true,
                        text: titulo
                    },
                    legend: {
                        display: false,
                    },
                    indexAxis: (estilo == 'horizontalBar' ? 'y' : 'x'),  // versão 3.9.1
                    // Adequa o tamanho dos gráficos conforme o tamanho da div: "#areaparagraficos"
                    maintainAspectRatio: false, // versão 3.9.1
                }
            });

            //Configurações personalizadas se grafico é do tipo linha
            if(myChart.config.type == 'line'){
                myChart.data.datasets[0].backgroundColor = 'rgb(255, 0, 0, 0.5)';
                myChart.data.datasets[0].borderColor = 'rgb(0, 0, 0, 0.2)';
                myChart.data.datasets[0].borderWidth = 3;
                myChart.data.datasets[0].fill = true;
                myChart.options.elements.line.tension = 0;
                myChart.update();
            }

            /*
            versão 2.9.4
            //Configurações personalizadas se gráfico é do tipo rosca
            if(myChart.config.type == 'doughnut'){
                myChart.options.maintainAspectRatio = false;
                myChart.options.tooltips.backgroundColor = 'rgb(255,255,255)';
                myChart.options.tooltips.bodyFontColor = '#858796';
                myChart.options.tooltips.borderColor = '#dddfeb';
                myChart.options.tooltips.borderWidth = 1;
                myChart.options.tooltips.xPadding = 15;
                myChart.options.tooltips.yPadding = 15;
                myChart.options.tooltips.displayColors = true;
                myChart.options.tooltips.caretPadding =  10;
                myChart.options.legend.display = true;
                myChart.options.cutoutPercentage =  80;
                myChart.update();
            }
            */
        }


        /*
        INÍCIO - MEUS GRÁFICOS LINHA MÊS a MÊS - Com o HTML ref. a este gráfico comentado, é lançado um erro!
                 visto que o código abaixo, não encontra o canvas: id="graficoLinha" abaixo.
        // Meu gráfico de LINHA Média de Preço Mês a Mês ESTÁTICO COM DADOS VINDO DA VIEW (MÉTODO COMPACT)
        //Limpa a área do grafico para evitar sobreposição de informações
        $('#graficoLinha').remove();
        $('#areaparagraficosmesames').append('<canvas id="graficoLinha"  width="200" height="40" style="padding: 10px 5px 5px 5px;"><canvas>');

        var ctx = document.getElementById('graficoLinha').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',    //type: 'line',

            // The data for our dataset
            data: {
                labels: ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'],
                //labels: ['s1','s2','s3','s4','s5','s6','s7','s8','s9','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50','s51','s52'],
                datasets: [
                    {
                        label: 'Compra Normal',
                        backgroundColor: 'rgb(255, 0, 0, 0.5)',
                        borderColor: 'rgb(255, 0, 0, 0.1)',
                        //data: [0, 10, 5, 2, 20, 30, 45],
                        //Digamos: pegar o preço do arroz comprados em todos os restaurantes em cada mês e fazer uma média
                        //Digamos: rest Liberdade, Coroadinho, São Jose de Ribamar, Bacuri (em imperatriz)
                        //data: [3.80, 4.80, 5, 5.50, 5.80, 5.80, 5.80, 6, 6.2, 5.80, 4.90, 6],
                        data: [ {{ implode(',', $dataNormal) }} ],
                        fill: true
                    },
                    {
                        label: 'Compra AF',
                        backgroundColor: 'rgb(0, 0, 255, 0.5)',
                        borderColor: 'rgb(0, 0, 255, 0.1)',
                        //data: [0, 20, 10, 12, 0, 60, 85],
                        //Digamos o preço do arroz da AF
                        //data: [3.50, 4.50, 4, 4.25, 4.40, 4.80, 5.80, 5.80, 6.2, 5.80, 6, 6],
                        data: [ {{ implode(',', $dataAf) }} ],
                        fill: true
                    }
                ]
            },
            plugins: [ChartDataLabels], // Exibe rótulo dos valores dentro dos gráficos
            // Configuration options go here
            options: {
                title: {
                    display: true,
                    text: 'GERAL'
                }
            }
        });
        FIM - MEUS GRÁFICOS LINHA MÊS a MÊS
        */


        //*********************************
        // GRÁFICO DINAMICO LINHA MES A MÊS
        //*********************************
        function renderGraficoDinamicoMesaMes(comprasNORM, comprasAF, titulo){

            //Limpa a área do grafico para evitar sobreposição de informações
            $('#graficoLinha').remove();
            $('#areaparagraficosmesames').append('<canvas id="graficoLinha"  width="200" height="40" style="padding: 10px 5px 5px 5px;"><canvas>');

            var ctx = document.getElementById('graficoLinha').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'],
                    datasets: [
                        {
                            label: 'Compra Normal',
                            backgroundColor: 'rgb(255, 0, 0, 0.5)',
                            borderColor: 'rgb(255, 0, 0, 0.1)',
                            data: comprasNORM,
                            fill: true
                        },
                        {
                            label: 'Compra AF',
                            backgroundColor: 'rgb(0, 0, 255, 0.5)',
                            borderColor: 'rgb(0, 0, 255, 0.1)',
                            data: comprasAF,
                            fill: true
                        }
                    ]
                },
                plugins: [ChartDataLabels], // Exibe rótulo dos valores dentro dos gráficos

                // Configuration options go here
                options: {
                    title: {
                        display: true,
                        text: titulo
                    }
                }
            });
        }













        //*************************************************
        // FUNÇÕES PARA RENDERIZAÇÃO DE GRÁFICOS EMPILHADO
        //*************************************************
        function renderGraficoDinamicoEmpilhado(valorLabels, valorNormal, valorAf, titulo){

            //Limpa a área do grafico para evitar sobreposição de informações
            $('#myChartArea').remove();
            $('#areaparagraficos').append('<canvas id="myChartArea"><canvas>');

            const ctx = document.getElementById('myChartArea').getContext('2d');
            const myChart = new Chart(ctx, {
                //Adapta o gráfico de acordo com a quantidade de dados.
                //type: valorLabels.length <= 13 ? "bar" : "horizontalBar", // versão 2.9.1

                type: 'bar',   // versão 3.9.1
                data: {
                    labels: valorLabels,
                    datasets: [{
                        label: 'Normal',
                        data: valorNormal,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.3)',
                            'rgba(54, 162, 235, 0.3)',
                            'rgba(255, 206, 86, 0.3)',
                            'rgba(75, 192, 192, 0.3)',
                            'rgba(153, 102, 255, 0.3)',
                            'rgba(255, 159, 64, 0.3)',
                            'rgba(255, 192, 192, 0.3)',
                            'rgba(153, 102, 255, 0.3)',
                            'rgba(100, 159, 64, 0.3)',
                            'rgba(100, 255, 192, 0.3)',
                            'rgba(183, 90, 255, 0.3)',
                            'rgba(255, 159, 100, 0.3)', //
                            'rgba(200, 99, 132, 0.3)',
                            'rgba(50, 162, 235, 0.3)',
                            'rgba(210, 206, 86, 0.3)',
                            'rgba(175, 192, 192, 0.3)',
                            'rgba(100, 102, 255, 0.3)',
                            'rgba(210, 159, 64, 0.3)',
                            'rgba(220, 192, 192, 0.3)',
                            'rgba(100, 102, 255, 0.3)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 0)',
                            'rgba(54, 162, 235, 0)',
                            'rgba(255, 206, 86, 0)',
                            'rgba(75, 192, 192, 0)',
                            'rgba(153, 102, 255, 0)',
                            'rgba(255, 159, 64, 0)',
                            'rgba(255, 192, 192, 0)',
                            'rgba(153, 102, 255, 0)',
                            'rgba(100, 159, 64, 0)',
                            'rgba(100, 255, 192, 0)',
                            'rgba(183, 90, 255, 0)',
                            'rgba(255, 159, 100, 0)', //
                            'rgba(200, 99, 132, 0)',
                            'rgba(50, 162, 235, 0)',
                            'rgba(210, 206, 86, 0)',
                            'rgba(175, 192, 192, 0)',
                            'rgba(100, 102, 255, 0)',
                            'rgba(210, 159, 64, 0)',
                            'rgba(220, 192, 192, 0)',
                            'rgba(100, 102, 255, 0)'
                        ],
                        borderWidth: 2,
                        barPercentage: 0.5, //Determina a largura da coluna ou barra
                        fill: false,

                    },
                    {
                        label: 'AF',
                        data: valorAf,
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(100, 159, 64, 1)',
                            'rgba(100, 255, 192, 1)',
                            'rgba(183, 90, 255, 1)',
                            'rgba(255, 159, 100, 1)', //
                            'rgba(200, 99, 132, 1)',
                            'rgba(50, 162, 235, 1)',
                            'rgba(210, 206, 86, 1)',
                            'rgba(175, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)',
                            'rgba(210, 159, 64, 1)',
                            'rgba(220, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(100, 159, 64, 1)',
                            'rgba(100, 255, 192, 1)',
                            'rgba(183, 90, 255, 1)',
                            'rgba(255, 159, 100, 1)', //
                            'rgba(200, 99, 132, 1)',
                            'rgba(50, 162, 235, 1)',
                            'rgba(210, 206, 86, 1)',
                            'rgba(175, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)',
                            'rgba(210, 159, 64, 1)',
                            'rgba(220, 192, 192, 1)',
                            'rgba(100, 102, 255, 1)'
                        ],
                        borderWidth: 2,
                        barPercentage: 0.5, //Determina a largura da coluna ou barra
                        fill: false,

                    }]
                },
                plugins: [ChartDataLabels], // Exibe rótulo dos valores dentro dos gráficos
                options: {
                    scales: {
                        /*
                        // versão 2.9.4
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            stacked: true
                        }] */
                        // versao 3.9.1
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    title: {
                        display: true,
                        text: titulo
                    },
                    legend: {
                        display: false,
                    },
                    // Adequa o tamanho dos gráficos conforme o tamanho da div: "#areaparagraficos"
                    maintainAspectRatio: false, // versão 3.9.1
                    // Se a quantidade de registro for muito grande, melhor visualizar os dados, verticalmente, ou seja,
                    // em linha(na forma de barras), Uma vez que o tipo horizontalBar não pe mais suportado pela
                    // versão 3.9.1 do chartJs, deve-se apenas definir a opção: indexAxis para 'y'
                    indexAxis: valorLabels.length >= 13 ? 'y' : 'x', // versão 3.9.1
                }
            });
        }


        //**************************************************************
        // GRÁFICOS MÊS A MÊS MONITOR REGIONAL - MUNICÍPIO - RESTAURANTE
        //**************************************************************
        //Limpa a área do grafico para evitar sobreposição de informações
        $('#graficomesamesMonitor').remove();
        $('#areaparagraficosmesamesmonitor').append('<canvas id="graficomesamesMonitor"  width="200" height="40" style="padding: 10px 5px 5px 5px;"><canvas>');

        var ctx = document.getElementById('graficomesamesMonitor').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',    //type: 'line',

            // The data for our dataset
            data: {
                labels: ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'],
                datasets: [
                    {
                        label: 'Compra Normal',
                        backgroundColor: 'rgb(255, 0, 0, 0.5)',
                        borderColor: 'rgb(255, 0, 0, 0.1)',
                        data: [ {{ implode(',', $dataNormal) }} ],
                        fill: true  // para gráfico do tipo linha
                    },
                    {
                        label: 'Compra AF',
                        backgroundColor: 'rgb(0, 0, 255, 0.5)',
                        borderColor: 'rgb(0, 0, 255, 0.1)',
                        data: [ {{ implode(',', $dataAf) }} ],
                        fill: true  // para gráfico do tipo linha
                    }
                ]
            },
            // Exibe rótulo dos valores dentro dos gráficos versão 3.9.1
            plugins: [ChartDataLabels],
            // Configuration options go here
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'GERAL',
                        padding: {
                            top: 3,
                            bottom: 3
                        }
                    },
                    subtitle: {
                        display: true,
                        text: 'Compras Gerais'
                    }
                }
            }
        });



        function renderGraficoDinamicoMesaMesMonitor(comprasNORM, comprasAF, titulo, subtitulo){

            //Limpa a área do grafico para evitar sobreposição de informações
            $('#graficomesamesMonitor').remove();
            $('#areaparagraficosmesamesmonitor').append('<canvas id="graficomesamesMonitor"  width="200" height="40" style="padding: 10px 5px 5px 5px;"><canvas>');

            var ctx = document.getElementById('graficomesamesMonitor').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'],
                    datasets: [
                        {
                            label: 'Compra Normal',
                            backgroundColor: 'rgb(255, 0, 0, 0.5)',
                            borderColor: 'rgb(255, 0, 0, 0.1)',
                            data: comprasNORM,
                            fill: true  // para gráfico do tipo linha
                        },
                        {
                            label: 'Compra AF',
                            backgroundColor: 'rgb(0, 0, 255, 0.5)',
                            borderColor: 'rgb(0, 0, 255, 0.1)',
                            data: comprasAF,
                            fill: true  // para gráfico do tipo linha
                        }
                    ]
                },
                plugins: [ChartDataLabels], // Exibe rótulo dos valores dentro dos gráficos

                // Configuration options go here
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: titulo,
                            padding: {
                                top: 3,
                                bottom: 3
                            }
                        },
                        subtitle: {
                            display: true,
                            //text: titulo != 'GERAL' ? titulo : 'Compras Gerais'
                            text: subtitulo
                        }
                    }
                }
            });
        }

        //******************************************************************
        // FIM GRÁFICOS MÊS A MÊS MONITOR REGIONAL - MUNICÍPIO - RESTAURANTE
        //******************************************************************














        //***********************************
        // FUNÇÃO PRA TABELAS DE INFORMAÇÕES
        //************************************
        // result irá receber tanto o índice 'titulo' como o índice 'dados'
        function preenchetabelainformacao(result) {

            var entidadeinformada = result['titulo'];

            $("#informacoes").html('');

            switch(entidadeinformada){
                case 'USUÁRIOS':
                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome:</td><td class="infodados">' + result['dados'].nomecompleto + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Pefil:</td><td class="infodados">' + (result['dados'].perfil == "adm" ? "ADMINISTRADOR" : result['dados'].perfil == "nut"  ? "NUTRICIONISTA" : "NUTRICIONISTA - INATIVO") + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">CPF:</td><td class="infodados">' + result['dados'].cpf + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">CRN:</td><td class="infodados">' + (result['dados'].crn != null ? result['dados'].crn : "") + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Município:</td><td class="infodados">' + result['dados'].municipio.nome + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Restaurante:</td><td class="infodados">' + (result['dados'].perfil == "nut" || result['dados'].perfil == "ina"  ? result['dados'].restaurante.identificacao : "") + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">E-mail:</td><td class="infodados">' + result['dados'].email + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Telefone:</td><td class="infodados">' + result['dados'].telefone + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');
                break;
                case 'EMPRESAS':
                    //Reune nutricionistas da empresa na mesma coluna
                    var qtdnutri = result['dados'].nutricionistas.length;
                    var dadosnutricionistas = "";
                    for(var i=0; i < qtdnutri; i++){
                        dadosnutricionistas += result['dados'].nutricionistas[i].nomecompleto + " - " + result['dados'].nutricionistas[i].telefone + " - " + result['dados'].nutricionistas[i].email + "<br>";
                    }

                    //Reune restaurantes da empresa na mesma coluna
                    var qtdrest = result['dados'].restaurantes.length;
                    var dadosrestaurantes = "";
                    for(var i=0; i < qtdrest; i++){
                        dadosrestaurantes += result['dados'].restaurantes[i].identificacao + "<br>";
                    }

                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Razão Social:</td><td class="infodados">' + result['dados'].razaosocial + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome de Fatasia:</td><td class="infodados">' + result['dados'].nomefantasia + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">CNPJ:</td><td class="infodados">' + result['dados'].cnpj + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Titular:</td><td class="infodados">' + result['dados'].titular + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cargo:</td><td class="infodados">' + result['dados'].cargotitular + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Logradouro:</td><td class="infodados">' + result['dados'].logradouro + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Número:</td><td class="infodados">' + result['dados'].numero + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Complemento:</td><td class="infodados">' + result['dados'].complemento + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Município:</td><td class="infodados">' + result['dados'].municipio + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Bairro:</td><td class="infodados">' + result['dados'].bairro + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">CEP:</td><td class="infodados">' + result['dados'].cep + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">E-mail:</td><td class="infodados">' + result['dados'].email + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Celular:</td><td class="infodados">' + result['dados'].celular + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Telefone:</td><td class="infodados">' + result['dados'].fone + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nutricionistas:</td><td class="infodados">'+ dadosnutricionistas +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Restaurantes:</td><td class="infodados">'+ dadosrestaurantes +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');
                break;
                case 'NUTRICIONISTAS':
                    //Como o relacionamento entre Nutricionista e Restaurante e Empresa é do tipo hasOne (um para um), o resultado da consulta para esta pesquisa é um
                    //objeto {...} ao contrário do relacionamento hasMany, que retorna um array de objetos [{...}, {...}]. Por isso não há a necessidade do loop como
                    //na entidade EMPRESAS acima. Obs: quanto um nutricionista não está associado a nenhuma outra entidade, seja, restaurante ou empresa (que nesse caso
                    //é impossível), primeiro testa-se o objeto do relacionamento exite (diferente de null) para depois exibir ou não a propriedade desejada, como abaixo:
                    //(result['dados'].restaurante != null ? result['dados'].restaurante.identificacao : "")

                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome:</td><td class="infodados">' + result['dados'].nomecompleto + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">CPF:</td><td class="infodados">' + result['dados'].cpf + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">CRN:</td><td class="infodados">' + result['dados'].crn + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">E-mail:</td><td class="infodados">' + result['dados'].email + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Telefone:</td><td class="infodados">' + result['dados'].telefone + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Empresa:</td><td class="infodados">'+ result['dados'].empresa.nomefantasia + " (Raz.Soc: " + result['dados'].empresa.razaosocial + ")" +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Restaurante:</td><td class="infodados">'+ (result['dados'].restaurante != null ? result['dados'].restaurante.identificacao : "") +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');
                break;
                case 'REGIONAIS':
                    //Reune municipios da regional na mesma coluna
                    var qtdmuni = result['dados'].municipios.length;
                    var dadosmunicipios = "";
                    for(var i=0; i < qtdmuni; i++){
                        dadosmunicipios += result['dados'].municipios[i].nome + "<br>";
                    }

                    //Reune restaurantes da regional na mesma coluna
                    var qtdrest = result['dados'].restaurantes.length;
                    var dadosrestaurantes = "";
                    for(var i=0; i < qtdrest; i++){
                        dadosrestaurantes += result['dados'].restaurantes[i].identificacao + "<br>";
                    }

                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome:</td><td class="infodados">' + result['dados'].nome + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Municípios:</td><td class="infodados">'+ dadosmunicipios +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Restaurantes:</td><td class="infodados">'+ dadosrestaurantes +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');
                break;
                case 'MUNICÍPIOS':
                    //Reune bairros do municipio na mesma coluna
                    var qtdbairr = result['dados'].bairros.length;
                    var dadosbairros = "";
                    for(var i=0; i < qtdbairr; i++){
                        dadosbairros += result['dados'].bairros[i].nome + "<br>";
                    }

                    //Reune restaurantes do municipio na mesma coluna
                    var qtdrest = result['dados'].restaurantes.length;
                    var dadosrestaurantes = "";
                    for(var i=0; i < qtdrest; i++){
                        dadosrestaurantes += result['dados'].restaurantes[i].identificacao + "<br>";
                    }

                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome:</td><td class="infodados">' + result['dados'].nome + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Regional:</td><td class="infodados">'+ result['dados'].regional.nome +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Bairros:</td><td class="infodados">'+ dadosbairros +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Restaurantes:</td><td class="infodados">'+ dadosrestaurantes +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');
                break;
                case 'CATEGORIAS':
                    //Reune produtos da categoria na mesma coluna
                    var qtdprod = result['dados'].produtos.length;
                    var dadosprodutos = "";
                    for(var i=0; i < qtdprod; i++){
                        dadosprodutos += result['dados'].produtos[i].nome + "<br>";
                    }

                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome:</td><td class="infodados">' + result['dados'].nome + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Produtos:</td><td class="infodados">'+ dadosprodutos +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');
                break;
                case 'PRODUTOS':

                    //Recebe o valor do id do produto escolhido.
                    var produtoid = result['dados'].id;

                    //Faz requisição para obter dados de todas as compras realizadas com este produto, independente da unidade.
                    $.ajax({
                        url:"{{route('admin.dashboard.ajaxrecuperacomprasdoproduto')}}",
                            type: "GET",
                            data: {
                                idproduto: produtoid
                            },
                            dataType : 'json',

                            success: function(result){
                                console.log(result);
                                console.log(result['campos'][0].nvzcmpnorm);
                                //Obs:  A título de exemplo: numvezescompranormal = result[0].nvzcmpnorm, não tem como ser reconhecida fora do escopo desta
                                //      função (success: funcion(result{}), fazendo com que a possibilidade fora deste escopo a torne "undefined", por isso
                                //      houve a necessidade de inserir seu valor assim como as demais, diretamente em um elemento html(span) através do
                                //      Jquery ($('#inf_nvez_cmp_normal').text(result['campos'][0].nvzcmpnorm);)
                                //      Tente acessar esta variável:  numvezescompranormal = result['campos'][0].nvzcmpnorm; fora deste escopo e ela será
                                //      considerada "undefined".

                                var numerovezescompranormal = parseInt(result['campos'][0].nvzcmpnorm);
                                var quantidadecompranormal = parseFloat((result['campos'][0].qtdcmpnorm != null ? result['campos'][0].qtdcmpnorm : 0));
                                var precototalcompranormal = parseFloat((result['campos'][0].prctotnorm != null ? result['campos'][0].prctotnorm: 0));

                                var numvezescompraaf = parseInt(result['campos'][0].nvzcmpaaf);
                                var quantidadecompraaf = parseFloat((result['campos'][0].qtdcmpaf != null ? result['campos'][0].qtdcmpaf : 0));
                                var precototalcompraaf = parseFloat((result['campos'][0].prctotaf != null ? result['campos'][0].prctotaf : 0));

                                var somanumerovezescompra = numerovezescompranormal + numvezescompraaf;
                                var somaquantidadecompra = quantidadecompranormal + quantidadecompraaf;
                                var somatotalcompra = precototalcompranormal + precototalcompraaf;


                                $('#inf_nvez_cmp_normal').text(numerovezescompranormal);
                                $('#inf_qtd_cmp_normal').text(number_format(quantidadecompranormal, "2", ",","."));
                                $('#inf_prctot_cmp_normal').text(number_format(precototalcompranormal, "2", ",","."));

                                $('#inf_nvez_cmp_af').text(numvezescompraaf);
                                $('#inf_qtd_cmp_af').text(number_format(quantidadecompraaf, "2", ",",".")); //
                                $('#inf_prctot_cmp_af').text(number_format(precototalcompraaf, "2", ",","."));

                                $('#inf_soma_total_nvez_cmp').text(somanumerovezescompra);
                                $('#inf_soma_total_qtd_cmp').text(number_format(somaquantidadecompra, "2", ",", "."));
                                $('#inf_soma_total_prc_cmp').text(number_format(somatotalcompra, "2", ",", "."));

                            },
                            error: function(result){
                                alert("Error ao retornar dados!");
                            }
                    });


                    ///
                    $("#informacoes").append('<tr><td class="infolabel">Id:</td><td class="infodados" colspan="4">' + result['dados'].id + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Nome:</td><td class="infodados" colspan="4">' + result['dados'].nome + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Categoria:</td><td class="infodados" colspan="4">'+ result['dados'].categoria.nome +'</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel" rowspan="4">Compras</td><td class="infosublabel">Tipo</td><td class="infosublabel">Nº Vezes</td><td class="infosublabel">Quantidade</td><td class="infosublabel">Valor</td></tr>');

                        $("#informacoes").append('<tr><td class="infosubdados">Normal</td><td class="infosubdados"><span id="inf_nvez_cmp_normal"></span></td><td class="infosubdados"><span id="inf_qtd_cmp_normal"></span></td><td class="infosubdados"><span id="inf_prctot_cmp_normal"></span></td></tr>');
                        $("#informacoes").append('<tr><td class="infosubdados">AF</td><td class="infosubdados"><span id="inf_nvez_cmp_af"></span></td><td class="infosubdados"><span id="inf_qtd_cmp_af"></span></td><td class="infosubdados"><span id="inf_prctot_cmp_af"></span></td></tr>');
                        $("#informacoes").append('<tr><td class="infosubdados">Total:</td><td class="infosubdados"><span id="inf_soma_total_nvez_cmp"></span></td><td class="infosubdados"><span id="inf_soma_total_qtd_cmp"></span></td><td class="infosubdados"><span id="inf_soma_total_prc_cmp"></span></td></tr>');


                    $("#informacoes").append('<tr><td class="infolabel">Obs:</td><td class="infodados" colspan="4">* Valores Totais independente da Unidade de Medida</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Cadastrado:</td><td class="infodados" colspan="4">' + mrc_formata_data(result['dados'].created_at) + '</td></tr>');
                    $("#informacoes").append('<tr><td class="infolabel">Atualizado:</td><td class="infodados" colspan="4">' + mrc_formata_data(result['dados'].updated_at) + '</td></tr>');

                break;

            }
        }








        //******************************
        // FUNÇÃO PARA FORMATAR DATAS
        //******************************
        function mrc_formata_data(adata){
            dataano = adata.substr(0, 4);
            datames = adata.substr(5, 2);
            datadia = adata.substr(8, 2);

            return(datadia + "/" + datames + "/" + dataano);
        }


        //******************************
        // FUNÇÃO PARA FORMATAR NÚMEROS
        //******************************
        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }


        /*
        //$("#informacoes").append('<tr><td class="infolabel">Nutricionistas:</td><td class="infodados">' + result['dados'].nutricionistas.forEach(mrc_formatardadosarray) + '</td></tr>');
        //result['dados'].nutricionistas.forEach(mrc_formatardadosarray);
        //$("#informacoes").append('<tr><td class="infolabel">Nutricionistas:</td><td class="infodados">'+ txtdadosarray +'</td></tr>');

        //************************************
        // FUNÇÃO PARA FORMATAR DADOS DO ARRAY
        //************************************
        var txtdadosarray = "";
        function mrc_formatardadosarray(value){
            txtdadosarray += value.nomecompleto + " "+ value.telefone + "<br>";
            //$("#informacoes").append('<tr><td class="infolabel">Nutricionistas:</td><td class="infodados">'+ txtdadosarray +'</td></tr>');
        }
        */

    </script>

@endsection
