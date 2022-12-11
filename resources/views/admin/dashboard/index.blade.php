@extends('template.templateadmin')

@section('content-page')

<div class="container-fluid">

    <!-- Page Heading -->
    {{--
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
    --}}

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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totRegionais }}</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Compras</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totCompras }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totCategorias }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totProdutos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-leaf fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        {{-- <!-- Earnings (Monthly) Card Example -->
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
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    <!-- FIM Content Row CARDS-->


    <!-- INÍCIO Content Row GRÁFICOS -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    
                    {{-- <h6 class="m-0 font-weight-bold text-primary">GRÁFICOS</h6>
                    <input type="month" id="start" name="start"> --}}

                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuTipografico"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                            Tipo de Gráfico
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuTipografico">
                            <div class="dropdown-header">Tipo de Gráfico:</div>
                            <a class="dropdown-item tipografico" href="#"><span><i class="fas fa-chart-bar"></i> Bar</a>
                            <a class="dropdown-item tipografico" href="#"><span><i class="fas fa-stream"></i></span> Coluna</a>
                            <a class="dropdown-item tipografico" href="#"><span><i class="fas fa-chart-pie"></i> Pizza</a>
                            <a class="dropdown-item tipografico" href="#"><span><i class="fas fa-chart-line"></i> Linha</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDados"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                            Dados
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuDados">
                            <div class="dropdown-header">Dados:</div>
                            <a class="dropdown-item" href="#">Categorias</a>
                            <a class="dropdown-item" href="#">Produtos</a>
                            <a class="dropdown-item" href="#">Regionais</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body"> {{-- <div class="chart-area"> <canvas id="myChart"></canvas></div> --}}
                    <div id="areaparagraficos">
                        <canvas id="myChartBar" style="display: none"></canvas>
                        <canvas id="myChartColumn" style="display: none"></canvas>
                        <canvas id="myChartPie" style="display: none"></canvas>
                        <canvas id="myChartLine" style="display: none"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">{{-- <div class="chart-pie pt-4 pb-2"> <canvas id="myPieChart"></canvas> </div>  --}}
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    {{--
                        @php 
                            if(count($dataRecords)){ 
                                foreach($dataRecords as $key => $values){
                                    echo '<span class="mr-2">  <i class="fas fa-circle"></i>'.$key.' </span>';
                                }
                            }   
                        @endphp 
                    --}}
                    
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body"> {{-- <div class="chart-area"> <canvas id="myChart"></canvas></div> --}}
                    <div>
                        <canvas id="myLineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Content Row GRÁFICOS -->

    <!-- INÍCIO MEUS GRÁFICOS -->
    <div class="card">
        <div>
            <h5 class="card-header" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">Comparativo Compra Normal x Agricultara Familiar</h5>
            <div class="card-header"  style="float: right; margin-top: -41px;">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDados"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                        Dados
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuDados">
                        <div class="dropdown-header">Dados:</div>
                        <a class="dropdown-item" href="#">Categorias</a>
                        <a class="dropdown-item" href="#">Produtos</a>
                        <a class="dropdown-item" href="#">Regionais</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div style="width: 100%; height: 20%; background-color: white;">
                <div>
                    <canvas id="graficoLinha" width="200" height="40" style="padding: 10px 5px 5px 5px;"></canvas>
                </div>
            </div>
        </div>
      </div>
    <!-- FIM MEUS GRÁFICOS -->

</div>

@endsection

@section('scripts')
    @php
        // CONFIGURANDO OS LABELS PARA OS GRÁFICOS DO TIPO BAR, PIZZA E BARRA
        if(count($dataRecords)){
            //Recuperando só as chaves do array, que será o label dos registros
            $labelRecords = array_keys($dataRecords);

            $arrLabel = [];
            foreach($labelRecords as $labelRecord){
                // Substitui caracteres especiais no nome de um campo por espaço vazio, para evitar erro.
                // Ex: farinha D'agua = faria Dagua
                $arrbusca = ["'","/","."];
                $arrtroca = [""];
                $labelRecord = str_replace($arrbusca, $arrtroca, $labelRecord);

                // Faz uma concatenação do tipo: 'labelX', 'labelY', 'labelZ', 'labelW', etc... 
                // para gráficos do tipo BAR, PIZZA, COLUNA
                $arrLabel[] = "'".$labelRecord."'";     //dd($arrLabel);
            }

            //$labells = implode(',', $labelRecords);     //echo $labells;
        }

        // Obtendo os valores de preço AF
        if(count($dataRecordsAf)){
            $dataAf =  array_values($dataRecordsAf);
            
        }
        // Obtendo os valores de preço NORMAL
        if(count($dataRecordsNormal)){
            $dataNormal =  array_values($dataRecordsNormal);
            
        }

        // Obtendo os valores das méidas de preços por seman AF e NORMAL
        if(count($dataRecordsMediaPrecoAf)){
            $dataAf =  array_values($dataRecordsMediaPrecoAf);
        }
        if(count($dataRecordsMediaPrecoNorm)){
            $dataNormal =  array_values($dataRecordsMediaPrecoNorm);
        }
        
    @endphp


    <script>
        $(document).ready(function() {

            //Oculta todos os gráficos com execão do padrão (myChartBar)
            $("#myChartColumn").hide();
            $("#myChartPie").hide();
            $("#myChartLine").hide();

            //Renderiza o gráfico padrão
            $("#myChartBar").show();
            renderGrafico("myChartBar","bar");

            $('.tipografico').on('click', function() {

                //Lipa espaço em branco no texto do link
                var tipo = $(this).text().trim();

                //Define um novo tipo de gráfico a ser gerado
                var novotipo = "";
                var novolocal = ";"
                
                //Testa o tipo de gráfico escolhido, define e exibte o novo tipo e oculta os demais
                switch (tipo){
                    case "Barra":
                        novotipo = "bar";
                        novolocal = "myChartBar";
                        $("#myChartBar").show();
                        $("#myChartColumn").hide();
                        $("#myChartPie").hide();
                        $("#myChartLine").hide();
                    break;
                    case "Coluna":
                        novotipo = "horizontalBar";
                        novolocal = "myChartColumn";
                        $("#myChartColumn").show();
                        $("#myChartBar").hide();
                        $("#myChartPie").hide();
                        $("#myChartLine").hide();
                    break;
                    case "Pizza":
                        novotipo = "pie";
                        novolocal = "myChartPie";
                        $("#myChartPie").show();
                        $("#myChartBar").hide();
                        $("#myChartColumn").hide();
                        $("#myChartLine").hide();
                    break;
                    case "Linha":
                        novotipo = "line";
                        novolocal = "myChartLine";
                        $("#myChartLine").show();
                        $("#myChartBar").hide();
                        $("#myChartColumn").hide();
                        $("#myChartPie").hide();
                    break;
                }

                renderGrafico(novolocal, novotipo);

                //var produto_id = this.value;

                //$("#medida_id").html('');

                // $.ajax({
                //     url:"{{route('admin.registroconsultacompra.ajaxgetmedidaproduto')}}",
                //     type: "GET",
                //     data: {
                //         produto_id: produto_id
                //     },

                //     dataType : 'json',
                //     success: function(result){
                //         $('#medida_id').html('<option value="" disabled>Medida...</option>');
                //         $.each(result.medidas,function(key,value){
                //             //console.log(value.medida_id);
                //             $("#medida_id").append('<option value="'+value.medida_id+'">'+value.medida_simbolo+'</option>');
                //         });
                //     },
                //     error: function(result){
                //         alert("Error ao retornar dados!");
                //     }
                // });

            });

            
        });
        

        function renderGrafico(local, tipo){
            var ctx = document.getElementById(local).getContext('2d');

            var myChart = new Chart(ctx, {
                type: tipo,
                data: {
                    //labels: ['GRÃOS', 'HORTALIÇAS', 'PROTEINA ANIMAL', 'VERDURAS'],
                    labels: [ {!! implode(',', $arrLabel) !!} ],
                    datasets: [{
                        label: 'Categoria',
                        data: [ {{ implode(',', $dataRecords) }} ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(100, 159, 64, 0.2)',
                            'rgba(100, 255, 192, 0.2)',
                            'rgba(183, 90, 255, 0.2)',
                            'rgba(255, 159, 100, 0.2)'
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
                            'rgba(255, 159, 100, 1)'
                        ],
                        borderWidth: 2,
                        barPercentage: 0.5,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: 'Gastos com compra (R$)'
                    },
                }
            });
        }        



        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                //labels: ["Direct", "Referral", "Social"],
                labels: [ {!! implode(',', $arrLabel) !!} ],
                datasets: [{
                //data: [55, 30, 15],
                data: [ {{ implode(',', $dataRecords) }} ],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#36b9df', '#ff0000'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
        });


        var ctx = document.getElementById('myLineChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Ags', 'Sep', 'Out', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Compra Normal',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        //data: [0, 10, 5, 2, 20, 30, 45],
                        //Digamos: pegar o preço do arroz comprados em todos os restaurantes em cada mês e fazer uma média
                        //Digamos: rest Liberdade, Coroadinho, São Jose de Ribamar, Bacuri (em imperatriz)
                        data: [4.50, 4.80, 5, 5.50, 5.80, 5.80, 5.80, 6, 6.2, 5.80, 4.90, 6],
                        fill: false
                    },
                    {
                        label: 'Compra AF',
                        backgroundColor: 'rgb(0, 0, 0)',
                        borderColor: 'rgb(255, 99, 132)',
                        //data: [0, 20, 10, 12, 0, 60, 85],
                        //Digamos o preço do arroz da AF
                        data: [4.50, 4.50, 4, 4.25, 4.40, 4.80, 5.80, 5.80, 6.2, 5.80, 6, 6],
                        fill: false
                    }
                ]
            },

            // Configuration options go here
            options: {

            }
        });


        var ctx = document.getElementById('graficoLinha').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                //labels: ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'],
                labels: ['s1','s2','s3','s4','s5','s6','s7','s8','s9','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50','s51','s52'],
                datasets: [
                    {
                        label: 'Compra Normal',
                        backgroundColor: 'rgb(255, 0, 0, 0.2)',
                        borderColor: 'rgb(255, 0, 0, 0.2)',
                        //data: [0, 10, 5, 2, 20, 30, 45],
                        //Digamos: pegar o preço do arroz comprados em todos os restaurantes em cada mês e fazer uma média
                        //Digamos: rest Liberdade, Coroadinho, São Jose de Ribamar, Bacuri (em imperatriz)
                        //data: [3.80, 4.80, 5, 5.50, 5.80, 5.80, 5.80, 6, 6.2, 5.80, 4.90, 6],
                        data: [ {{ implode(',', $dataNormal) }} ],
                        fill: true
                    },
                    {
                        label: 'Compra AF',
                        backgroundColor: 'rgb(0, 0, 255, 0.2)',
                        borderColor: 'rgb(0, 0, 255, 0.2)',
                        //data: [0, 20, 10, 12, 0, 60, 85],
                        //Digamos o preço do arroz da AF
                        //data: [3.50, 4.50, 4, 4.25, 4.40, 4.80, 5.80, 5.80, 6.2, 5.80, 6, 6],
                        data: [ {{ implode(',', $dataAf) }} ],
                        fill: true
                    }
                ]
            },

            // Configuration options go here
            options: {

            }
        });        

    </script>

@endsection
