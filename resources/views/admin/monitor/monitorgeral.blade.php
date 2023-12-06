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

                // Define as colunas(campos) da tabela que irão receber os dados vindo do servidor. Os nomes deverão corresponder
                columns: [
                    { data: 'id' },
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
            $('#controlesPeriodoCarregarPdf').append('<button type="button" class="btn btn-primary" id="btnCarregar" style="height: 36px; width: 40px; float:left; margin-left: 30px;" title="Carregar Dados"><i class="fas fa-search"></i></button>');
            $('#controlesPeriodoCarregarPdf').append('<a href="" id="btnPdf" class="btn btn-danger" style="height: 36px; width: 40px; float:left; margin-left: 30px; display: none" title="Relatório PDF" target="_blank"><i class="far fa-file-pdf"></i></a>');
            $('#controlesPeriodoCarregarPdf').append('<a href="" id="btnPdfPrimeiroSemestre" class="btn btn-danger" style="height: 36px; width: 20px; float:left; margin-left: 30px; display: none" title="Relatório PDF primerio semestre" target="_blank"><i class="fas fa-file-alt" style="margin-left: -7px"></i></a>');


            // Ocultando o botão PDF com a DELEGAÇÃO DE EVENTOS para os elementos dentro da div #dataTableMonitor_length e para
            // o elemento #selectPeriodo. Deixando o botão PDF disponível apenas se o resultado da pesquisa retornar dados.
            $("#dataTableMonitor_length").on("change", "#selectEntidade, #selectCategorias, #selectProdutos", function(){
                $("#btnPdf").css("display", "none");
                $("#btnPdfPrimeiroSemestre").css("display", "none");

            });
            $("#selectPeriodo").on("change", function(){
                $("#btnPdf").css("display", "none");
                $("#btnPdfPrimeiroSemestre").css("display", "none");
            });


            $("#btnCarregar").on('click', function(){

                // Recupera os valores (se selecionados) dos elementos
                valEntidadeSelecionada  = $("#selectEntidade").val();
                valCategoriaSelecionada = $("#selectCategorias").val() == undefined ? 0 : $("#selectCategorias").val() ;
                valProdutoSelecionado   = $("#selectProdutos").val() == undefined ? 0 : $("#selectProdutos").val();
                valAnoSelecionado       = $("#selectPeriodo").val();
                periodoAno  = valAnoSelecionado;

                // Recupera os textos selecionados dos elementos
                // txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                // txtCategoriaSelecionada = $("#selectCategorias").children("option:selected").text();
                // txtProdutoSelecionado   = $("#selectProdutos").children("option:selected").text();
                // txtAnoSelecionado       = $("#selectPeriodo").children("option:selected").text();

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

            // Exibe/Oculta o Botão para Ipressão PDF e ou Modal de acordo com o número de registros retornados.
            oTable.on( 'xhr', function () {
                var dataJSON = oTable.ajax.json();
                // Se retornar registros, configura a rota para impressão dos mesmos e exibe o botão PDF.
                if(dataJSON.iTotalRecords > 0){
                    var entidadepdf = valEntidadeSelecionada;
                    var categoriapdf =  valCategoriaSelecionada;
                    var produtopdf = valProdutoSelecionado;
                    var anopdf =  periodoAno;

                    var routepdf = "{{route('admin.monitor.relpdfmonitorgeral', ['identidade', 'idcategoria', 'idproduto', 'idano'])}}";
                        routepdf = routepdf.replace('identidade', entidadepdf);
                        routepdf = routepdf.replace('idcategoria', categoriapdf);
                        routepdf = routepdf.replace('idproduto', produtopdf);
                        routepdf = routepdf.replace('idano', anopdf);

                    $('#btnPdf').attr('href', routepdf);
                    $("#btnPdf").css("display", "inline");


                    var routepdfprimeirosemestre = "{{route('admin.monitor.relpdfmonitorgeralprimeirosemestre', ['identidade', 'idcategoria', 'idproduto', 'idano'])}}";
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('identidade', entidadepdf);
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('idcategoria', categoriapdf);
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('idproduto', produtopdf);
                        routepdfprimeirosemestre = routepdfprimeirosemestre.replace('idano', anopdf);

                    $('#btnPdfPrimeiroSemestre').attr('href', routepdfprimeirosemestre);
                    //$("#btnPdfPrimeiroSemestre").css("display", "inline");


                // Se nenhum registro for retornado, exibe a modal
                }else if(dataJSON.iTotalRecords == 0 && valEntidadeSelecionada != 0){
                    $(".modalSemLancamento").modal("show");
                }else{
                    $("#btnPdf").css("display", "none");
                    $("#btnPdfPrimeiroSemestre").css("display", "none");
                }

            });

            // Destaca com o fundo azul, uma ou mais linha ao serem clicadas
            oTable.on('click', 'tbody tr', function (e) {
                e.currentTarget.classList.toggle('selected');
            });

         });
    </script>
@endsection

