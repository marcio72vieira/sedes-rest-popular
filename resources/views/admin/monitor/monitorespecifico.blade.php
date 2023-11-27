@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong id="titulomonitor">MONITOR ESPECÍFICO</strong></h5>


    <!-- DataTales Example -->
    <div class="mb-4 shadow card">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableMonitor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle; text-align:center;">Id</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center" id="tipopesquisa">Tipo</th>
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
            Nenhum registro encontrado com os critérios especifiados!.
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

            // Definindo uma requisição padrão para inicializar o datatable
            //var rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
            var rotaAjax = "{{route('admin.ajaxgetRecordsEmpty')}}";
            var periodoAno = new Date().getFullYear();
            var valEntidadeSelecionada = 0;
            var valRegistro = 0;
            var valCategProd = 0;
            var valCategoriaSelecionada = 0;
            var valProdutoSelecionado = 0;
            var valAnoSelecionado = 2023;
            var txtEntidadeSelecionada = "";
            var txtCategoriaSelecionada = "";
            var txtProdutoSelecionado = "";
            var habilitaImpresao = 0;
            
            // Definindo os anos a serem exibidos a partir do ano de implementação do sistema
            var anoimplementacao = 2020;
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
                scrollY: '500px',
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
                        d.entidade = valEntidadeSelecionada;
                        d.registro = valRegistro;
                        d.catprod = valCategProd;
                        d.periodo = periodoAno;
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
            });

            

            // ELEMENTOS DA DIV dataTableMonitor_length (Div, criada dinamicamente)
            $('#dataTableMonitor_length').append('<select id="selectEntidade" class="form-control input-sm" style="margin-left:30px; height: 36px;"><option selected value="0">Entidades</option><option value="1">Regionais</option><option value="2">Municípios</option><option value="3">Restaurantes</option></select>');
            
            $("#selectEntidade").on("change", function(){
                
                // Define informações, carrega uma tabela vazia e esconde os controles de ano, carregamento e impresssão
                if($(this).val() == "0" ){
                    $("#entidade").text("Entidades");
                    $("#titulomonitor").text("MONITOR ESPECÍFICO");
                    $("#titulopesquisa").text("COMPRAS EM " + anoatual);

                    rotaAjax = "{{route('admin.ajaxgetRecordsEmpty')}}";
                    oTable.ajax.url(rotaAjax).load();

                    $("#controlesPeriodoCarregarPdf").css("display", "none");
                }

                // Remove dropdown REGISTROSDAENTIDADE e CATEGORIAPRODUTO (caso existam) para "resetar" seus valores
                $("#selectRegistrosDaEntidade, #selectCategoriaProduto").remove();

                // Exibe dropdown REGISTROSDAENTIDADE e CATEGORIAPRODUTO se for: Regional, Município ou Restaurante
                if($(this).val() == "1" || $(this).val() == "2" || $(this).val() == "3"){

                    // Exibe os "controles" Periodo, btnCarregar e Pdf para pesquisa e impressão
                    //---$("#controlesPeriodoCarregarPdf").css("display", "inline");

                    var nomeEntidadeEscolhida = $("#selectEntidade").children("option:selected").text();
                    var valorEntidadeEscolhida = $(this).val();
                    
                    $.ajax({
                        url: "{{route('admin.ajaxgetCarregaRegistrosDaEntidade')}}",
                        type: "GET",
                        data: {idEntidade: valorEntidadeEscolhida},
                        dataType : 'json',
                        success: function(result){
                            // Populando o selectRegistrosDaEntidade a partir da Entidade Selecionada
                            $('#dataTableMonitor_length').append('<select id="selectRegistrosDaEntidade" class="form-control input-sm" style="margin-left:30px; height: 36px;"></select>');
                            $('#selectRegistrosDaEntidade').append($('<option selected></option>').val('0').html(nomeEntidadeEscolhida));
                            $.each(result, function() {
                                $('#selectRegistrosDaEntidade').append($('<option></option>').val(this.id).html(this.nome));
                            });
                        },
                        error: function(result){
                            alert("Error ao retornar Registros desta Entidade!");
                        }
                    });
                    
                    // Criando o dropdown selectCategoriaProduto a partir da entidade escolhida com a DELEGAÇÃO DE EVENTOS
                    $("#dataTableMonitor_length").on("change", "#selectRegistrosDaEntidade", function(){
                        if($(this).val() == "0"){
                            $("#selectCategoriaProduto").remove();
                            $("#controlesPeriodoCarregarPdf").css("display", "none");
                        }else{
                            $("#selectCategoriaProduto").remove();
                            $('#dataTableMonitor_length').append('<select id="selectCategoriaProduto" class="form-control input-sm" style="margin-left:30px; height: 36px;"><option selected value="0">Escolha</option><option value="1">Categorias</option><option value="2">Produtos</option></select>');
                            //---var idCatSelecionada = $(this).val();

                            // Exibe/Oculta os controles de Período, Carregar e PDF conforme escolha do tipo de pesquisa (Categoria ou Produtos)
                            $("#selectCategoriaProduto").on("change", function(){
                                if($(this).val() == "0"){
                                    $("#controlesPeriodoCarregarPdf").css("display", "none");
                                }else{
                                    $("#controlesPeriodoCarregarPdf").css("display", "inline");
                                }
                            });
                        }
                    });
                } else{
                    // Removendo dropdown REGISTROSDAENTIDADE e CATEGORIAPRODUTO, caso Entidade (Entidde com valor 0) seja selecionada. para "resetar" seus valores
                    $("#selectRegistrosDaEntidade, #selectCategoriaProduto").remove();
                }
            });


            // ELEMENTOS DA DIV dataTableMonitor_filter
            $('#dataTableMonitor_filter').append('<div id="controlesPeriodoCarregarPdf" style="float:left; display:none"></div>');
            // Populando o selectPeriodo a partir de um Array "padrão" com jQuery
            $('#controlesPeriodoCarregarPdf').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px; width: 80px; float:left"></select>');
            $('#selectPeriodo').append($('<option disabled></option>').val('0').html('Ano'));
            $.each(anosexibicao, function(indx, valorano) {
                    $('#selectPeriodo').append($('<option></option>').val(valorano).html(valorano));
            });


            // Botões de CarregarDados e Impressão PDF. O valor do atributo href, é criado dinamicamente
            $('#controlesPeriodoCarregarPdf').append('<button type="button" class="btn btn-primary" id="btnCarregar" style="height: 36px; width: 80px; float:left; margin-left: 30px;" title="Carregar Dados"><i class="fas fa-search"></i></button>');
            $('#controlesPeriodoCarregarPdf').append('<a href="" id="btnPdf" class="btn btn-danger" style="height: 36px; width: 80px; float:left; margin-left: 30px; display: none" title="Relatório PDF" target="_blank"><i class="far fa-file-pdf"></i></a>');
            


            // Ocultando o botão PDF com a DELEGAÇÃO DE EVENTOS para os elementos dentro da div #dataTableMonitor_length e para
            // o elemento #selectPeriodo. Deixando o botão PDF disponível apenas se o resultado da pesquisa retornar dados.
            $("#dataTableMonitor_length").on("change", "#selectEntidade, #selectRegistrosDaEntidade, #selectCategoriaProduto", function(){
                $("#btnPdf").css("display", "none");
            });
            $("#selectPeriodo").on("change", function(){
                $("#btnPdf").css("display", "none");
            });


            $("#btnCarregar").on('click', function(){

                // Recupera os valores (se selecionados) dos elementos
                valEntidadeSelecionada  = $("#selectEntidade").val();
                valRegistro             = $("#selectRegistrosDaEntidade").val() == undefined ? 0 : $("#selectRegistrosDaEntidade").val();
                valCategProd            = $("#selectCategoriaProduto").val() == undefined ? 0 : $("#selectCategoriaProduto").val();
                valAno                  = $("#selectPeriodo").val();
                periodoAno              = valAno;

                //valCategoriaSelecionada = $("#selectRegistrosDaEntidade").val() == undefined ? 0 : $("#selectRegistrosDaEntidade").val() ;
                //valProdutoSelecionado   = $("#selectCategoriaProduto").val() == undefined ? 0 : $("#selectCategoriaProduto").val();

                //alert("Entidade: " + $("#selectEntidade").children("option:selected").text() + "  Valor: " + $("#selectRegistrosDaEntidade").children("option:selected").text() + "  Tipo: " + $("#selectCategoriaProduto").children("option:selected").text());
                //alert("Entidade: " + valEntidadeSelecionada + "  Valor: " + valRegistro + "  Tipo: " + valCategProd);
                
                if(valEntidadeSelecionada != 0 && valRegistro != 0 && valCategProd != 0){

                    rotaAjax = "{{route('admin.ajaxgetComprasPorCategoriasOuProdutos')}}";
                    
                    // Configura o texto da pesquisa
                    txtTipoPesquisa = $("#selectCategoriaProduto").children("option:selected").text();
                    $("#tipopesquisa").text(txtTipoPesquisa);
                    $("#titulopesquisa").text("COMPRAS POR " + txtTipoPesquisa.toUpperCase() + " EM " + periodoAno);
                    $("#titulomonitor").text("MONITOR ESPECÍFICO | COMPRAS POR " + txtTipoPesquisa.toUpperCase() + " EM " + periodoAno);
                    
                    oTable.ajax.url(rotaAjax).load();


                }else if(valEntidadeSelecionada != 0 && valCategoriaSelecionada != 0 && valProdutoSelecionado == 0){
                    
                    // Configura o texto da pesquisa
                    txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                    txtCategoriaSelecionada = $("#selectRegistrosDaEntidade").children("option:selected").text();
                    $("#entidade").text(txtEntidadeSelecionada);
                    $("#titulopesquisa").text("COMPRAS DE " + txtCategoriaSelecionada.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                    $("#titulomonitor").text("MONITOR ESPECÍFICO | COMPRAS DE " + txtCategoriaSelecionada.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);


                    // Define a rota de acordo com a Entidade e a Categoria escolhida
                    rotaAjax = "{{route('admin.ajaxgetCategoriasPorEntidadeComprasMensais')}}";
                    oTable.ajax.url(rotaAjax).load();

                }else {

                    // Configura o texto da pesquisa
                    txtEntidadeSelecionada  = $("#selectEntidade").children("option:selected").text();
                    txtProdutoSelecionado   = $("#selectCategoriaProduto").children("option:selected").text();
                    $("#entidade").text(txtEntidadeSelecionada);
                    $("#titulopesquisa").text("COMPRAS DE " + txtProdutoSelecionado.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                    $("#titulomonitor").text("MONITOR ESPECÍFICO | COMPRAS DE " + txtProdutoSelecionado.toUpperCase() + " POR " + txtEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);

                    // Define a rota de acordo com a Entidade, Categoria e Produto escolhido
                    rotaAjax = "{{route('admin.ajaxgetProdutosPorEntidadeComprasMensais')}}";
                    oTable.ajax.url(rotaAjax).load();

                }
                
            });

            // Exibe/Oculta o Botão para Ipressão PDF e ou Modal de acordo com o número de registros retornados.
            oTable.on( 'xhr', function () {
                var dataJSON = oTable.ajax.json();
                // Se retornar registros, configura a rota para impressão dos mesmos e exibe o botão PDF.
                if(dataJSON.iTotalRecords > 0){
                    var entidadepdf = valEntidadeSelecionada;
                    var categoriapdf =  valCategoriaSelecionada;
                    var produtopdf = valProdutoSelecionado;
                    var anopdf =  periodoAno;

                    var routepdf = "{{route('admin.monitor.relpdfmonitor', ['identidade', 'idcategoria', 'idproduto', 'idano'])}}";
                        routepdf = routepdf.replace('identidade', entidadepdf);
                        routepdf = routepdf.replace('idcategoria', categoriapdf);
                        routepdf = routepdf.replace('idproduto', produtopdf);
                        routepdf = routepdf.replace('idano', anopdf);

                    $('#btnPdf').attr('href', routepdf);
                    $("#btnPdf").css("display", "inline");

                // Se nenhum registro for retornado, exibe a modal
                }else if(dataJSON.iTotalRecords == 0 && valEntidadeSelecionada != 0){
                    $(".modalSemLancamento").modal("show");
                }else{
                    $("#btnPdf").css("display", "none");
                }
                
            });

            

         });
    </script>
@endsection

