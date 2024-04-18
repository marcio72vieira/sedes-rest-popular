@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong id="titulomonitor">MONITOR GERAL</strong></h5>


    <!-- DataTales Example -->
    <div class="mb-4 shadow card">

        <div class="card-body">
            <div class="table-responsive">
                {{-- Com as classes row-border e order-column, as coluna Entidade fica destacada como padrão
                    <table class="table table-bordered row-border hover order-column" id="dataTableMonitor" width="100%" cellspacing="0"> --}}
                    <table class="table table-bordered hover" id="dataTableMonitor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle; text-align:center;">Id</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center" id="entidade">Entidade</th>
                            <th colspan="24" style="vertical-align: middle; text-align:center" id="titulopesquisa">COMPRAS EM @php echo date("Y") @endphp</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">TOTAL<br>PARCIAL</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">TOTAL<br>GERAL<br>(nm + af)</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">PORCENTO<br>%</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align:center">JAN</th>
                            <th colspan="2" style="text-align:center">FEV</th>
                            <th colspan="2" style="text-align:center">MAR</th>
                            <th colspan="2" style="text-align:center">ABR</th>
                            <th colspan="2" style="text-align:center">MAI</th>
                            <th colspan="2" style="text-align:center">JUN</th>
                            <th colspan="2" style="text-align:center">JUL</th>
                            <th colspan="2" style="text-align:center">AGS</th>
                            <th colspan="2" style="text-align:center">SET</th>
                            <th colspan="2" style="text-align:center">OUT</th>
                            <th colspan="2" style="text-align:center">NOV</th>
                            <th colspan="2" style="text-align:center">DEZ</th>
                        </tr>
                        <tr>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                            <th>nm</th>
                            <th>af</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal PeríodoVazio -->
    <div class="modal fade modalSemLancamento" id="exampleModalSemLancamento" tabindex="-1" aria-labelledby="exampleModalLabelSemLancamento" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelSemLancamento" style="color: rgb(46, 63, 250)">SEM LANÇAMENTOS!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                Nenhum registro encontrado com os dados fornecidos!
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>


    <!-- Modal PDF de Subgrupo -->
    <div class="modal fade modalSubgrupo" id="exampleModalSubgrupo" tabindex="-1" aria-labelledby="exampleModalLabelSubgrupo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelSubgrupo" style="color: rgb(46, 63, 250)"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <a href="" id="btnPdfSubgrupo" class="btn btn-danger" style="height: 36px; width: 40px;" title="" target="_blank"><i class="far fa-file-pdf"></i></a>
                <span id="labelButtonPdf"></span>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>


</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            // Acessando os array em php(enviados pela view) via javascript, ou seja, transformando-os em um array json
            var arrayCategorias =  @php echo $categoriaJSON; @endphp;

            // Definindo uma requisição padrão para inicializar o datatable
            //var rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
            var rotaAjax = "{{route('admin.ajaxgetRecordsEmpty')}}";
            var periodoAno = new Date().getFullYear();
            var valEntidadeSelecionada = 0;
            var valCategoriaSelecionada = 0;
            var valProdutoSelecionado = 0;
            var valAnoSelecionado = 2023;
            var txtEntidadeSelecionada = "";
            var txtCategoriaSelecionada = "";
            var txtProdutoSelecionado = "";
            var habilitaImpresao = 0;

            // Definindo os anos a serem exibidos a partir do ano de implementação do sistema
            var anoimplementacao = 2023;
            var anoatual = new Date().getFullYear();
            var anos = [];
            var anosexibicao = [];
            var qtdanosexibicao = 0;

            if(anoimplementacao >= anoatual){
                anosexibicao.push(anoatual);
            }else{
                qtdanosexibicao = anoatual -  anoimplementacao;
                for(var a = qtdanosexibicao; a >= 0; a-- ){
                    anos.push(anoatual - a);
                }
                anosexibicao = anos.reverse();
            }


            // Definindo o datatabble e suas propriedades e atribuindo à variável oTable(objeto dataTable)
            var oTable = $('#dataTableMonitor').DataTable({
                // Define "congelamento" de colunas e rolagens vertical/horizontal. Necessário importar CSS correspondente
                fixedColumns: {
                    left: 2,
                },
                scrollCollapse: true,
                scrollY: '1000px',
                scrollX: true,

                // Ordena os dados em ordem alfabética pela coluna 1
                order: [[ 1, 'asc' ]],

                // Colunas que não serão ordenadas
                columnDefs: [
                    { orderable: false, targets: [26, 27, 28, 29, 30] }
                ],

                // Menu da quantidade de registros a serem exibidos
                lengthMenu: [15, 20, 25, 30, 35, 40, 45, 50],

                // Indica a mensagem de processamento e que os dados virão de um servidor
                processing: true,
                serverSide: true,

                // Requisição ajax indicando a rota e os parâmetros a serem enviados
                // Como as variáveis que definem os parâmetros são globais ("var") quaisquer modifiações nos mesmos refletem aqui
                ajax: {
                    url: rotaAjax,
                    data: function(d){
                        d.periodo = periodoAno;
                        d.entidade = valEntidadeSelecionada;
                        d.categoria = valCategoriaSelecionada;
                        d.produto = valProdutoSelecionado;
                    },
                },

                // Define as colunas(campos) da tabela que irão receber os dados vindo do servidor. Os nomes deverão corresponder.
                columns: [
                    { data: 'id',
                        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                            //$(nTd).html("<a href='/tickets/"+oData.id+"'>"+oData.id+"</a>");
                            // Só invoca a chamada de Subgrupo se for escolhido: Regionais, Municípios ou Categorias
                            if(valEntidadeSelecionada == 1 || valEntidadeSelecionada == 2 || valEntidadeSelecionada == 4) {
                                $(nTd).hover(
                                    //function(){ $(this).css({"background-color":"#cc1c0c", "color":"#ffffff", "cursor":"pointer" }); },
                                    //function(){ $(this).css({"background-color":"white", "color":"#858796"}); }

                                    function(){ $(this).html("<i class='far fa-file-pdf text-danger'></i>").css("cursor","pointer");},
                                    function(){ $(this).html(oData.id);}
                                );
                                $(nTd).on('click', function(){
                                    switch(valEntidadeSelecionada){
                                        case "1":
                                            $("#exampleModalLabelSubgrupo").text("REGIONAL: " + oData.nomeentidade);
                                            $("#labelButtonPdf").text(" Listar Municípios desta Regional.");
                                            $("#btnPdfSubgrupo").attr("title", "PDF dos valores por Municípios");
                                            relPdfSubgrupo(oData.id);   // id da entidade principal para pesquisa de seu subbrupo
                                        break;
                                        case "2":
                                            $("#exampleModalLabelSubgrupo").text("MUNICÍPIO: " + oData.nomeentidade);
                                            $("#labelButtonPdf").text(" Listar Restaurantes deste Município.");
                                            $("#btnPdfSubgrupo").attr("title", "PDF dos valores por Restaurantes");
                                            relPdfSubgrupo(oData.id);   // id da entidade principal para pesquisa de seu subbrupo
                                        break;
                                        case "4":
                                            $("#exampleModalLabelSubgrupo").text("CATEGORIA: " + oData.nomeentidade);
                                            $("#labelButtonPdf").text(" Listar Produtos desta Categoria.");
                                            $("#btnPdfSubgrupo").attr("title", "PDF dos valores por Produtos");
                                            relPdfSubgrupo(oData.id);   // id da entidade principal para pesquisa de seu subbrupo
                                        break;
                                    }
                                    $(".modalSubgrupo").modal("show");
                                });
                            }
                        }
                    },
                    { data: 'nomeentidade' },
                    { data: 'jannormal' },
                    { data: 'janaf' },
                    { data: 'fevnormal' },
                    { data: 'fevaf' },
                    { data: 'marnormal' },
                    { data: 'maraf' },
                    { data: 'abrnormal' },
                    { data: 'abraf' },
                    { data: 'mainormal' },
                    { data: 'maiaf' },
                    { data: 'junnormal' },
                    { data: 'junaf' },
                    { data: 'julnormal' },
                    { data: 'julaf' },
                    { data: 'agsnormal' },
                    { data: 'agsaf' },
                    { data: 'setnormal' },
                    { data: 'setaf' },
                    { data: 'outnormal' },
                    { data: 'outaf' },
                    { data: 'novnormal' },
                    { data: 'novaf' },
                    { data: 'deznormal' },
                    { data: 'dezaf' },
                    { data: 'totalnormal' },
                    { data: 'totalaf' },
                    { data: 'totalgeral' },
                    { data: 'percentagemnormal' },
                    { data: 'percentagemaf' },
                ],

                // Traduzindo as informações de exibição, pesquisa e paginação
                language: {
                    "lengthMenu": "Mostrar _MENU_ registos",
                    "search": "Procurar:",
                    "info": "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
                    "infoFiltered":   "(Filtrados _TOTAL_ de um total de _MAX_ registros)",
                    "paginate": {
                        "first": "Primeiro",
                        "previous": "Anterior",
                        "next": "Seguinte",
                        "last": "Último"
                    },
                    "zeroRecords": "Não foram encontrados resultados",
                },

                // Definindo o tipo de exibição de paginação(completa)
                pagingType: "full_numbers",

                // Executa uma função assim que o dataTable estiver carregado complementante
                // initComplete: function (settings, json) {
                //      wire:$("#dataTableMonitor_filter").css("width", "30%");
                // }
            });



            // ELEMENTOS DA DIV dataTableMonitor_length (Div, criada dinamicamente)
            //$('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Entidades</label>');
            $('#dataTableMonitor_length').append('<select id="selectEntidade" class="form-control input-sm" style="margin-left:30px; height: 36px;"><option selected value="0">Entidades</option><option value="1">Regionais</option><option value="2">Municípios</option><option value="3">Restaurantes</option><option disabled>___________</option><option value="4">Categorias</option><option value="5">Produtos</option></select>');

            $("#selectEntidade").on("change", function(){

                // Define informações, carrega uma tabela vazia e esconde os controles de ano, carregamento e impresssão
                if($(this).val() == "0" ){
                    $("#entidade").text("Entidades");
                    $("#titulomonitor").text("MONITOR GERAL");
                    $("#titulopesquisa").text("COMPRAS EM " + anoatual);

                    rotaAjax = "{{route('admin.ajaxgetRecordsEmpty')}}";
                    oTable.ajax.url(rotaAjax).load();

                    // Define sempre o ano atual como sendo o ano padrão de pesquisa antes de ocultar a div com o seletor
                    $('#selectPeriodo option[value="' + anoatual +'"]').prop('selected', true);
                    $("#controlesPeriodoCarregarPdf").css("display", "none");

                    // Evita exibição da modal de forma desnecessária na avaliação da condição: "dataJSON.iTotalRecords == 0 && valEntidadeSelecionada != 0"
                    // no trecho de código no final deste script.
                    valEntidadeSelecionada = 0;
                }

                // Remove dropdown CATEGORIAS e PRODUTOS(caso existam) para "resetar" seus valores
                $("#selectCategorias, #selectProdutos").remove();

                // Exibe dropdown CATEGORIAS se Entidade for: Regional, Município ou Restaurante
                if($(this).val() == "1" || $(this).val() == "2" || $(this).val() == "3"){

                    // Exibe os "controles" Periodo, btnCarregar e Pdf para pesquisa e impressão
                    $("#controlesPeriodoCarregarPdf").css("display", "inline");

                    // Populando o selectCategorias a partir de um Array JSON com jQuery
                    $('#dataTableMonitor_length').append('<select id="selectCategorias" class="form-control input-sm" style="margin-left:30px; height: 36px;"></select>');
                    $('#selectCategorias').append($('<option selected></option>').val('0').html('Categorias'));
                    $.each(arrayCategorias, function() {
                            $('#selectCategorias').append($('<option></option>').val(this.categoria_id).html(this.categoria_nome));
                    });

                    // Criando e populadno o dropdown selectProdutos a partir da categoria escolhida
                    $("#selectCategorias").on("change", function(){
                        if($(this).val() == "0"){
                            $("#selectProdutos").remove();
                        }else{
                            $("#selectProdutos").remove();
                            var idCatSelecionada = $(this).val();
                            $.ajax({
                                url: "{{route('admin.ajaxgetProdutosDaCategoriaComprasMensais')}}",
                                type: "GET",
                                data: {idcategoria: idCatSelecionada},
                                dataType : 'json',
                                success: function(result){
                                    $('#dataTableMonitor_length').append('<select id="selectProdutos" class="form-control input-sm" style="margin-left:30px; height: 36px;"></select>');
                                    $('#selectProdutos').append($('<option selected></option>').val('0').html('Produtos'));
                                    $.each(result, function() {
                                        $('#selectProdutos').append($('<option></option>').val(this.produto_id).html(this.produto_nome));
                                    });
                                },
                                error: function(result){
                                    alert("Error ao retornar produtos desta Categoria!");
                                }
                            });
                        }
                    });
                } else if($(this).val() == "4" || $(this).val() == "5"){
                    // Exibe os "controles" Periodo, btnCarregar e Pdf para pesquisa e impressão E REMOVE DROPDOWN's Categorias e Produtos
                    $("#controlesPeriodoCarregarPdf").css("display", "inline");
                    $("#selectCategorias, #selectProdutos").remove();
                } else{
                    // Removendo dropdown CATEGORIAS e PRODUTOS, caso Entidade (Entidde com valor 0) seja selecionada. para "resetar" seus valores
                    $("#selectCategorias, #selectProdutos").remove();
                }
            });


            // ELEMENTOS DA DIV dataTableMonitor_filter
            // Sem classe "hover" na tabela
            // $('#dataTableMonitor_filter').append('<div id="controlesPeriodoCarregarPdf" style="float:left; display:none;"></div>');
            // ELEMENTOS DA DIV dataTableMonitor_filter
            // Com implementação da classe "hover" na tabela
            $('#dataTableMonitor_filter').append('<div id="controlesPeriodoCarregarPdf" style="float:left; margin-left: -430px; display:none;"></div>');
            // Populando o selectPeriodo a partir de um Array "padrão" com jQuery
            $('#controlesPeriodoCarregarPdf').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px; width: 80px; float:left"></select>');
            $('#selectPeriodo').append($('<option disabled></option>').val('0').html('Ano'));
            $.each(anosexibicao, function(indx, valorano) {
                    $('#selectPeriodo').append($('<option></option>').val(valorano).html(valorano));
            });


            // Botões de CarregarDados e Impressão PDF. O valor do atributo href, é criado dinamicamente
            // $('#controlesPeriodoCarregarPdf').append('<a href="" id="btnPdfPrimeiroSemestre" class="btn btn-danger" style="height: 36px; width: 20px; float:left; margin-left: 30px; display: none" title="Relatório PDF primerio semestre" target="_blank"><i class="fas fa-file-alt" style="margin-left: -7px"></i></a>');
            $('#controlesPeriodoCarregarPdf').append('<button type="button" class="btn btn-primary" id="btnCarregar" style="height: 36px; width: 40px; float:left; margin-left: 30px;" title="Carregar Dados"><i class="fas fa-search"></i></button>');
            $('#controlesPeriodoCarregarPdf').append(`<select id="selectMes" class="form-control input-sm" style="height: 36px; width: 150px; float:left; margin-left: 30px; display: none">
                        <option value="0" selected>Emitir PDF</option>
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
                        <option value="" disabled>_______________</option>
                        <option value="13">Todos os meses</option>
                    </select>`);

            $('#controlesPeriodoCarregarPdf').append('<a href="" id="btnPdf" class="btn btn-danger" style="height: 36px; width: 40px; float:left; margin-left: 30px; display: none" title="Relatório PDF" target="_blank"><i class="far fa-file-pdf"></i></a>');





            // Ocultando o botão PDF com a DELEGAÇÃO DE EVENTOS para os elementos dentro da div #dataTableMonitor_length e para
            // o elemento #selectPeriodo. Deixando o botão PDF disponível apenas se o resultado da pesquisa retornar dados.
            $("#dataTableMonitor_length").on("change", "#selectEntidade, #selectCategorias, #selectProdutos", function(){
                //$("#btnPdfPrimeiroSemestre").css("display", "none");
                $("#btnPdf").css("display", "none");
                $("#selectMes").css("display", "none");

            });
            $("#selectPeriodo").on("change", function(){
                //$("#btnPdfPrimeiroSemestre").css("display", "none");
                $("#btnPdf").css("display", "none");
                $("#selectMes").css("display", "none");
            });


            $("#btnCarregar").on('click', function(){

                // Recupera os valores (se selecionados) dos elementos
                valEntidadeSelecionada  = $("#selectEntidade").val();
                valCategoriaSelecionada = $("#selectCategorias").val() == undefined ? 0 : $("#selectCategorias").val() ;
                valProdutoSelecionado   = $("#selectProdutos").val() == undefined ? 0 : $("#selectProdutos").val();
                valAnoSelecionado       = $("#selectPeriodo").val();
                periodoAno  = valAnoSelecionado;

                // Exibe select para escolha do mês do relatório pdf
                $("#selectMes").css("display", "inline");

                // Define o valor da seleção para "Emitir PDF"
                $("#selectMes").val("0").change();

                // Oculta o botão emitir PDF. Só o exibe quando o select selectMes for alterado.
                $("#btnPdf").css("display", "none");

                // Recupera os textos selecionados dos elementos
                // txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                // txtCategoriaSelecionada = $("#selectCategorias").children("option:selected").text();
                // txtProdutoSelecionado   = $("#selectProdutos").children("option:selected").text();
                // txtAnoSelecionado       = $("#selectPeriodo").children("option:selected").text();

                // Se apenas a entidade foi selecionada
                if(valEntidadeSelecionada != 0 && valCategoriaSelecionada == 0 && valProdutoSelecionado == 0){

                    switch (valEntidadeSelecionada){

                        // Define a rota de acordo com a Entidade escolhida
                        case "1":
                            rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
                        break;
                        case "2":
                            rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                        break;
                        case "3":
                            rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
                        break;
                        case "4":
                            rotaAjax = "{{route('admin.ajaxgetCategoriasComprasMensais')}}";
                        break;
                        case "5":
                            rotaAjax = "{{route('admin.ajaxgetProdutosComprasMensais')}}";
                        break;
                        default:
                            rotaAjax = "{{route('admin.ajaxgetRecordsEmpty')}}";
                    }

                    // Configura o texto da pesquisa
                    txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                    $("#entidade").text(txtEntidadeSelecionada);
                    $("#titulopesquisa").text("COMPRAS POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                    $("#titulomonitor").text("MONITOR GERAL | COMPRAS POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);

                    oTable.ajax.url(rotaAjax).load();


                // Se entidade e categoria foi selecionada
                }else if(valEntidadeSelecionada != 0 && valCategoriaSelecionada != 0 && valProdutoSelecionado == 0){

                    // Configura o texto da pesquisa
                    txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                    txtCategoriaSelecionada = $("#selectCategorias").children("option:selected").text();
                    $("#entidade").text(txtEntidadeSelecionada);
                    $("#titulopesquisa").text("COMPRAS DE " + txtCategoriaSelecionada.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                    $("#titulomonitor").text("MONITOR GERAL | COMPRAS DE " + txtCategoriaSelecionada.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);


                    // Define a rota de acordo com a Entidade e a Categoria escolhida
                    rotaAjax = "{{route('admin.ajaxgetCategoriasPorEntidadeComprasMensais')}}";
                    oTable.ajax.url(rotaAjax).load();

                // Se entidade, categoria e produtos foram selecionados
                }else {

                    // Configura o texto da pesquisa
                    txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                    txtProdutoSelecionado   = $("#selectProdutos").children("option:selected").text();
                    $("#entidade").text(txtEntidadeSelecionada);
                    $("#titulopesquisa").text("COMPRAS DE " + txtProdutoSelecionado.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                    $("#titulomonitor").text("MONITOR GERAL | COMPRAS DE " + txtProdutoSelecionado.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);

                    // Define a rota de acordo com a Entidade, Categoria e Produto escolhido
                    rotaAjax = "{{route('admin.ajaxgetProdutosPorEntidadeComprasMensais')}}";
                    oTable.ajax.url(rotaAjax).load();

                }

            });


            // Acessando os Dados Retornados pela Requisição AJAx para o DATATABLE
            // oTable.on( 'xhr', function () {
            //      var dataJSON = oTable.ajax.json();
            //      console.log( dataJSON);
            //      console.log( dataJSON.iTotalRecords);
            //      console.log( dataJSON.aaData[3].id);
            //      console.log( dataJSON.aaData[3].nomeentidade);
            //      alert(dataJSON.aaData.length);
            // });

            // Exibe/Oculta o Select dos meses juntamente com o Botão para Ipressão PDF e ou Modal(caso não exista dados retornados) de acordo com o número de registros retornados.
            oTable.on( 'xhr', function () {
                // dataJSON recebe o retorno da requisição xhtmlrequest(xhr)
                var dataJSON = oTable.ajax.json();
                // Se retornar registros, configura a rota para impressão dos mesmos e exibe select meses e o botão PDF.
                if(dataJSON.iTotalRecords > 0){
                    var entidadepdf = valEntidadeSelecionada;
                    var categoriapdf =  valCategoriaSelecionada;
                    var produtopdf = valProdutoSelecionado;
                    var anopdf =  periodoAno;
                    var mespdf =  $("#selectMes").val();   // mespdf, recebe o valor do selectMes, que inicialmente terá o valor 13(todos os meses, pois o mesmo está selectd por padrão)


                    // Exibe select para escolha do mês do relatório pdf
                    // $("#selectMes").css("display", "inline");

                    $("#selectMes").on('change', function(){
                        mespdf =  $(this).find('option:selected').val();   // mespdf, recebe o valor do selectMes, que inicialmente terá o valor 13(todos os meses, pois o mesmo está selectd por padrão)

                        switch(mespdf){

                            case "1":
                            case "2":
                            case "3":
                            case "4":
                            case "5":
                            case "6":
                            case "7":
                            case "8":
                            case "9":
                            case "10":
                            case "11":
                            case "12":
                                var routepdf = "{{route('admin.monitor.relpdfmonitorgeralmensal', ['identidade', 'idcategoria', 'idproduto', 'idmes', 'idano'])}}";
                                    routepdf = routepdf.replace('identidade', entidadepdf);
                                    routepdf = routepdf.replace('idcategoria', categoriapdf);
                                    routepdf = routepdf.replace('idproduto', produtopdf);
                                    routepdf = routepdf.replace('idmes', mespdf);
                                    routepdf = routepdf.replace('idano', anopdf);

                                    $('#btnPdf').attr('href', routepdf);
                                    $("#btnPdf").css("display", "inline");
                            break;

                            case "13":
                                var routepdf = "{{route('admin.monitor.relpdfmonitorgeral', ['identidade', 'idcategoria', 'idproduto', 'idano'])}}";
                                routepdf = routepdf.replace('identidade', entidadepdf);
                                routepdf = routepdf.replace('idcategoria', categoriapdf);
                                routepdf = routepdf.replace('idproduto', produtopdf);
                                routepdf = routepdf.replace('idano', anopdf);

                                $('#btnPdf').attr('href', routepdf);
                                $("#btnPdf").css("display", "inline");
                            break;

                            default:
                                $("#btnPdf").css("display", "none");

                        }
                    });


                    // $('#btnPdf').attr('href', routepdf);




                    /*
                    var routepdfprimeirosemestre = "{{route('admin.monitor.relpdfmonitorgeralprimeirosemestre', ['identidade', 'idcategoria', 'idproduto', 'idano'])}}";
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('identidade', entidadepdf);
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('idcategoria', categoriapdf);
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('idproduto', produtopdf);
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('idano', anopdf);

                    $('#btnPdfPrimeiroSemestre').attr('href', routepdfprimeirosemestre);
                    $("#btnPdfPrimeiroSemestre").css("display", "inline");
                    */


                // Se nenhum registro for retornado, exibe a modal
                }else if(dataJSON.iTotalRecords == 0 && valEntidadeSelecionada != 0){
                    $(".modalSemLancamento").modal("show");
                }else{
                    // $("#btnPdfPrimeiroSemestre").css("display", "none");
                    $("#btnPdf").css("display", "none");
                    $("#selectMes").css("display", "inline");
                }

            });

            // Destaca com o fundo azul, uma ou mais linha ao serem clicadas
            oTable.on('click', 'tbody tr', function (e) {
                e.currentTarget.classList.toggle('selected');
            });

            // Fechar modal: $("#MyPopup").modal("hide");


            function relPdfSubgrupo(validregistro) {

                // Recupera os valores (se selecionados) dos elementos nos respectivos selects
                valEntidadeSelecionada  = $("#selectEntidade").val();
                valCategoriaSelecionada = $("#selectCategorias").val() == undefined ? 0 : $("#selectCategorias").val() ;
                valProdutoSelecionado   = $("#selectProdutos").val() == undefined ? 0 : $("#selectProdutos").val();
                valAnoSelecionado       = $("#selectPeriodo").val();
                periodoAno              = valAnoSelecionado;


                var entidadepdfsubgrup = valEntidadeSelecionada;
                var validregistroselecionado = validregistro;
                var categoriapdfsubgrup =  valCategoriaSelecionada;
                var produtopdfsubgrup = valProdutoSelecionado;
                var anopdfsubgrup =  periodoAno;

                var routepdfsubgroup = "{{route('admin.monitor.relpdfmonitorgeralsubgrupo', ['identidade', 'idregistro' , 'idcategoria', 'idproduto', 'idano'])}}";
                    routepdfsubgroup = routepdfsubgroup.replace('identidade', entidadepdfsubgrup);
                    routepdfsubgroup = routepdfsubgroup.replace('idregistro', validregistroselecionado);
                    routepdfsubgroup = routepdfsubgroup.replace('idcategoria', categoriapdfsubgrup);
                    routepdfsubgroup = routepdfsubgroup.replace('idproduto', produtopdfsubgrup);
                    routepdfsubgroup = routepdfsubgroup.replace('idano', anopdfsubgrup);

                $("#btnPdfSubgrupo").attr("href", routepdfsubgroup);
                $("#btnPdfSubgrupo").on("click", function(){$(".modalSubgrupo").modal("hide")});

            }


            /*
            // OBTENDO O ÍNDICE DA COLUNA E O SENTIDO (asc ou desc) QUE FOI ESCOLHIDA PARA ORDENAÇÃO PELO CLICK DO USUÁRIO
            // Obtendo o índice da coluna e o sentido (asc ou desc) que foi escolhida para ordenação pelo click do usuário.
            oTable.on( 'order.dt', function () {
                // Recebe um array 2D com o índice da coluna e a ordem (asc ou desc), no formato: [[índice_numerico_coluna],["ordem"]]
                var ordering = oTable.order();  //
                console.log( 'Table ordering changed: ' + JSON.stringify(ordering) );
                console.log(ordering);
                var ndxColumnEOrder =  ordering;
                //alert ("Número da Coluna: " + ndxColumnEOrder[0][0] + "  Ordem da Coluna: " + ndxColumnEOrder[0][1] );

                //alert(getNameColumnHeader(ndxColumnEOrder[0][0]));
                alert(getNameColumnHeader(ndxColumnEOrder));

            });

            function getNameColumnHeader(arrayColumnOrder){
                var nameColumn = "";
                var orderColumn = "";

                switch(arrayColumnOrder[0][0]) {
                    case 0:
                        nameColumn =  "id";
                        sortColumn = arrayColumnOrder[0][1]; // recebe a string "asc" ou "desc"
                    break;
                    case 1:
                        nameColumn =  "nomeentidade";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 2:
                        nameColumn =  "jannormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 3:
                        nameColumn =  "janaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 4:
                        nameColumn =  "fevnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 5:
                        nameColumn =  "fevaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 6:
                        nameColumn =  "marnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 7:
                        nameColumn =  "maraf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 8:
                        nameColumn =  "abrnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 9:
                        nameColumn =  "abraf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 10:
                        nameColumn =  "mainormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 11:
                        nameColumn =  "maiaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 12:
                        nameColumn =  "junnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 13:
                        nameColumn =  "junaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 14:
                        nameColumn =  "julnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 15:
                        nameColumn =  "julaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 16:
                        nameColumn =  "agsnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 17:
                        nameColumn =  "agsaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 18:
                        nameColumn =  "setnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 19:
                        nameColumn =  "setaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 20:
                        nameColumn =  "outnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 21:
                        nameColumn =  "outaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 22:
                        nameColumn =  "novnormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 23:
                        nameColumn =  "novaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 24:
                        nameColumn =  "deznormal";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    case 25:
                        nameColumn =  "dezaf";
                        sortColumn = arrayColumnOrder[0][1];
                    break;
                    default:
                        nameColumn = "Outras Colunas";
                        sortColumn = arrayColumnOrder[0][1];
                }

                return nameColumn + " " + sortColumn;
            }
            */

         });

    </script>
@endsection

