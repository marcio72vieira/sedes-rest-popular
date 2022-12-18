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
                        <a class="dropdown-toggle font-weight-bold text-primary" href="#" role="button" id="dropdownMenuTipografico"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                            Estilo
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuTipografico">
                            <div class="dropdown-header">Estilo do Gráfico:</div>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="bar"><span><i class="fas fa-chart-bar"></i></span> Coluna</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="horizontalBar"><span><i class="fas fa-stream"></i> Barra</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="pie"><span><i class="fas fa-chart-pie"></i> Pizza</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="line"><span><i class="fas fa-chart-line"></i> Linha</a>
                            <a class="dropdown-item estilografico psdlink" data-estilo-grafico="doughnut"><span><i class="fas fa-circle-notch"></i> Rosca</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle font-weight-bold text-primary" href="#" role="button" id="dropdownMenuDados"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                            Dados
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuDados">
                            <div class="dropdown-header">Dados:</div>
                            <a class="dropdown-item tipodadosgraficopadrao psdlink">Produtos</a>
                            <a class="dropdown-item tipodadosgraficopadrao psdlink">Categorias</a>
                            <a class="dropdown-item tipodadosgraficopadrao psdlink">Regionais</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="areaparagraficos">
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
                            //Dados vindo da view via método compact
                            if(count($dataRecords))  {
                                echo "<tr><td colspan='2' class='titulotraducao'>GASTOS GERAIS COM PRODUTOS (R$)</td></tr>";
                                echo "<tr><td class='subtitulolabeltraducao'>Nome</td><td class='subtitulovalortraducao'>Valor</td>";
                                echo "</tr>";
                                foreach ($dataRecords as $key => $value) {
                                    echo "<tr class='destaque'><td class='dadoslabel'>".$key."</td><td class='dadosvalor'>".number_format($value, 2, ',', '.')."</td></tr>";
                                }
                            }
                        @endphp
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Content Row GRÁFICOS -->

    <!-- INÍCIO MEUS GRÁFICOS -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
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
                                <a class="dropdown-item" href="#">Produtos</a>
                                <a class="dropdown-item" href="#">Categorias</a>
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
        </div>
    </div>
    <!-- FIM MEUS GRÁFICOS -->


    <!-- INÍCIO OUTROS DADOS -->
    <div class="row">
        {{-- Outros dados --}}
        <div class="col-xl-5 col-lg-6">
            <div class="card shadow mb-4">
                <div>
                    <h5 class="card-header" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">Visualização Rápida</h5>
                    <div class="card-header"  style="float: right; margin-top: -41px;">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDados"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                Dados
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuDados">
                                <div class="dropdown-header">Dados:</div>
                                <a class="dropdown-item">Usuários</a>
                                <a class="dropdown-item">Categorias</a>
                                <a class="dropdown-item">Regionais</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="width: 100%; height: 20%; background-color: white;">
                        <div>
                            <table class="tabelatraducao">
                                @php
                                    //Dados vindo da view via método compact
                                    if(count($dataRecords))  {
                                        echo "<tr><td colspan='4' class='titulotraducao'>USUÁRIOS</td></tr>";
                                        echo "<tr>
                                            <td class='subtitulolabeltraducao'>Nome</td><td class='subtitulovalortraducao'>Valor</td>
                                            <td class='subtitulolabeltraducao'>Nome</td><td class='subtitulovalortraducao'>Valor</td>
                                        </tr>";
                                        foreach ($dataRecords as $key => $value) {
                                            echo "<tr class='destaque'>
                                                    <td class='dadoslabel'>".$key."</td>
                                                    <td class='dadosvalor'>".number_format($value, 2, ',', '.')."</td>
                                                    <td class='dadoslabel'>".$key."</td>
                                                    <td class='dadosvalor'>".number_format($value, 2, ',', '.')."</td>
                                            </tr>";
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
                    <h5 class="card-header" style="font-weight:bold; font-size: 1rem; color: #4e73df; display:block; width:100%; float: left;">Informações</h5>
                    <div class="card-header"  style="float: right; margin-top: -41px;">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuDados"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none">
                                Dados
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuDados">
                                <div class="dropdown-header">Dados:</div>
                                <a class="dropdown-item" href="#">Produtos</a>
                                <a class="dropdown-item" href="#">Categorias</a>
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
        </div>
    </div>
    <!-- FIM OUTROS DADOS -->

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

    
        // Obtendo os valores das médias de preços por semana AF e NORMAL
        if(count($dataRecordsMediaPrecoAf)){
            $dataAf =  array_values($dataRecordsMediaPrecoAf);
        }
        if(count($dataRecordsMediaPrecoNorm)){
            $dataNormal =  array_values($dataRecordsMediaPrecoNorm);
        }
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

            //ALTERAÇÃO DO ESTILO DE GRÁFICO
            $('.estilografico').on('click', function() {
    
                //Define o estilo do gráfico
                estilo = $(this).data('estilo-grafico');
               
                //Logo que a página é carregada, tipodado não está definido, então renderiza-se o gráfico padrão (bar) com os dados padrão (produtos)
                if(tipodados == ""){
                    renderGrafico(estilo);
                }else{
                    renderGraficoDinamico(estilo, tipodados, valorLabels, valorData);
                }
                
            });


            //Escolha de outro tipo de dados além do tipo padrão: "Produtos"
            $(".tipodadosgraficopadrao").on("click", function(){

                //Lipa espaço em branco no texto do link tipodados
                tipodados = $(this).text().trim();

                var urltipo = "";

                //Faz requisição para obter novos dados
                $.ajax({
                    url:"{{route('admin.dashboard.ajaxrecuperadadosgrafico')}}",
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

                        //Iterando sobre o array['dados']
                        $.each(result['dados'], function(key,value){
                            valorLabels.push(key);
                            valorData.push(value);
                        });

                        //Se tipo é igual a espaço em branco, é porque nenhum outro estilo de gráfico foi escolhido, permanecendo portanto o padrão "bar"
                        if(estilo == ""){estilo = "bar";}
                        
                        //Renderiza gráfico passando as informações necessárias
                        renderGraficoDinamico(estilo, tipodados, valorLabels, valorData);

                        //Atualiza a tabela tradução
                        $(".tabelatraducao").html('');
                        $(".tabelatraducao").append('<tr><td colspan="2" class="titulotraducao">'+ result['titulo'] +'</td></tr>');
                        $(".tabelatraducao").append('<tr><td class="subtitulolabeltraducao">Nome</td><td class="subtitulovalortraducao">Valor</td></tr>');

                        //Itera sobre os dados retornados pela requisição Ajax
                        $.each(result['dados'], function(key,value){
                            $(".tabelatraducao").append('<tr class="destaque"><td class="dadoslabel">' + key + '</td><td class="dadosvalor">' + number_format(value,2,",",".") + '</td></tr>');
                        });
                    },
                    error: function(result){
                        alert("Error ao retornar dados!");
                    }
                });
            });
        });


        //Renderiza Gráfico com dados padrão Produtos e o estilo igual a "bar" (Dados vindos via método compac, da view).
        //Esta função é executada uma única vez, logo que a página é carregada
        function renderGrafico(estilo){

            //Limpa a área do grafico para evitar sobreposição de informações
            $('#myChartArea').remove();
            $('#areaparagraficos').append('<canvas id="myChartArea"><canvas>');            

            const ctx = document.getElementById('myChartArea').getContext('2d');
            const myChart = new Chart(ctx, {
                type: estilo,
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
                            'rgba(255, 159, 100, 0.5)'
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
                        barPercentage: 0.5, //Determina a largura da coluna ou barra
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

            //Configurações personalizadas se grafico é do tipo linha
            if(myChart.config.type == 'line'){
                myChart.data.datasets[0].backgroundColor = 'rgb(255, 0, 0, 0.5)';
                myChart.data.datasets[0].borderColor = 'rgb(0, 0, 0, 0.2)';
                myChart.data.datasets[0].borderWidth = 3;
                myChart.data.datasets[0].fill = true;
                myChart.options.elements.line.tension = 0;
                myChart.update();
            }

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
        }



        function renderGraficoDinamico(estilo, tipodados, valorLabels, valorData){

            //Limpa a área do grafico para evitar sobreposição de informações
            $('#myChartArea').remove();
            $('#areaparagraficos').append('<canvas id="myChartArea"><canvas>');

            const ctx = document.getElementById('myChartArea').getContext('2d');
            const myChart = new Chart(ctx, {
                type: estilo,
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
                            'rgba(255, 159, 100, 0.5)'
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
                        barPercentage: 0.5, //Determina a largura da coluna ou barra
                        fill: false,

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

            //Configurações personalizadas se grafico é do tipo linha
            if(myChart.config.type == 'line'){
                myChart.data.datasets[0].backgroundColor = 'rgb(255, 0, 0, 0.5)';
                myChart.data.datasets[0].borderColor = 'rgb(0, 0, 0, 0.2)';
                myChart.data.datasets[0].borderWidth = 3;
                myChart.data.datasets[0].fill = true;
                myChart.options.elements.line.tension = 0;
                myChart.update();
            }

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
        }



        // Meu gráfico
        var ctx = document.getElementById('graficoLinha').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'],
                //labels: ['s1','s2','s3','s4','s5','s6','s7','s8','s9','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50','s51','s52'],
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


        //Formatador de números
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

    </script>

@endsection
