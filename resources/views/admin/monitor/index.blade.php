@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>MONITOR</strong></h5>


    <!-- DataTales Example -->
    <div class="mb-4 shadow card">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableMonitor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">Id</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center" id="entidade">Regionais</th>
                            <th colspan="24" style="vertical-align: middle; text-align:center" id="mesesdoano">COMPRAS POR REGIONAL EM @php echo date("Y") @endphp</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">TOTAL<br>PARCIAL</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">TOTAL<br>GERAL</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">PERCENTAGEM</th>
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
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>NORMAL</th>
                            <th>AF</th>
                            <th>NORMAL</th>
                            <th>AF</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            // Acessando os array em php via javascript, ou seja, transformando-os em um array json
            var arrayCategorias =  @php echo $categoriaJSON; @endphp;
            var arrayProdutos = @php echo $produtosJSON; @endphp;

            console.log(arrayCategorias, arrayProdutos);

            var rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
            var periodoAno = new Date().getFullYear();
            
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

            

            var oTable = $('#dataTableMonitor').DataTable({
                fixedColumns: {
                    left: 2,
                },
                scrollCollapse: true,
                scrollY: '500px',
                scrollX: true,

                order: [[ 1, 'asc' ]],

                columnDefs: [
                    { orderable: false, targets: [26, 27, 28, 29, 30] }
                ],

                lengthMenu: [15, 20, 25, 30, 35, 40, 45, 50],
                
                processing: true,
                serverSide: true,
                
                ajax: {
                    url: rotaAjax,
                    data: function(d){
                        d.periodo = periodoAno;
                    },
                },

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

                pagingType: "full_numbers",

                initComplete: function (settings, json) {
                    //$("#dataTableMonitor_filter").css("width", "30%");
                }
            });

            


            //$('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Compras</label>');
            $('#dataTableMonitor_length').append('<select id="selectEntidade" class="form-control input-sm" style="margin-left:30px; height: 36px;"><option selected disabled value="0">Compras</option><option value="1">Regionais</option><option value="2">Municípios</option><option value="3">Restaurantes</option><option disabled>___________</option><option value="4">Categorias</option><option value="5">Produtos</option></select>');
            

            // Populando o selectCategorias a partir de um Array JSON(ou seja, um objeto) com jQuery
            // $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Categorias</label>');
            $('#dataTableMonitor_length').append('<select id="selectCategorias" class="form-control input-sm" style="margin-left:30px; height: 36px;"></select>');
            $('#selectCategorias').append($('<option selected></option>').val('0').html('Categorias'));
            $.each(arrayCategorias, function() {
                    $('#selectCategorias').append($('<option></option>').val(this.categoria_id).html(this.categoria_nome));
            });

            $("#selectCategorias").on("change", function(){
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
            });

            // Populando o selectProdutos a partir de um Array JSON(ou seja, um objeto) com jQuery
            // $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Produtos</label>');
            //$('#dataTableMonitor_length').append('<select id="selectProdutos" class="form-control input-sm" style="margin-left:30px; height: 36px;"></select>');
            //$('#selectProdutos').append($('<option selected></option>').val('0').html('Produtos'));
            //$.each(arrayProdutos, function() {
            //        $('#selectProdutos').append($('<option></option>').val(this.produto_id).html(this.produto_nome));
            //});

            // Populando o selectPeriodo a partir de um Array "padrão" com jQuery
            // $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Ano</label>');
            $('#dataTableMonitor_filter').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px; width: 80px; float:left"></select>');
            $('#selectPeriodo').append($('<option disabled></option>').val('').html('Ano'));
            $.each(anosexibicao, function(indx, valorano) {
                    $('#selectPeriodo').append($('<option></option>').val(valorano).html(valorano));
            });

            $('#dataTableMonitor_filter').append('<button type="button" id="btnAcao" class="btn btn-light" style="height: 36px; width: 80px; float:left; margin-left: 30px;"><i class="fas fa-search"></i></button>');
            $('#dataTableMonitor_filter').append('<a class="btn btn-light" style="height: 36px; width: 80px; float:left; margin-left: 30px;"><i class="far fa-file-pdf"></i></a>');

            
            $("#selectEntidade, #selectPeriodo").on('change', function(){
                var textEntidadeSelecionada = $("#selectEntidade").children("option:selected").text();
                var entidadeSelecionada = $("#selectEntidade").val();
                periodoAno = $("#selectPeriodo").val();

                switch (entidadeSelecionada){
                    case "1":
                        $("#selectCategorias, #selectProdutos").attr("disabled", false);
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
                    break;
                    case "2":
                        $("#selectCategorias, #selectProdutos").attr("disabled", false);
                        rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                    break;
                    case "3":
                        $("#selectCategorias, #selectProdutos").attr("disabled", false);
                        rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
                    break;
                    case "4":
                        $("#selectCategorias, #selectProdutos").attr("disabled", true);
                        rotaAjax = "{{route('admin.ajaxgetCategoriasComprasMensais')}}";
                    break;
                    case "5":
                        $("#selectCategorias, #selectProdutos").attr("disabled", true);
                        rotaAjax = "{{route('admin.ajaxgetProdutosComprasMensais')}}";
                    break;
                    default:
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";

                }
                $("#entidade").text(textEntidadeSelecionada);
                $("#mesesdoano").text("COMPRAS POR " + textEntidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                oTable.ajax.url(rotaAjax).load();
            });

            // Novo
            $("#selectCategorias").on('change', function(){
                $("#selectProdutos").css("display", "inline");
                // var valGrupoSelecionado = $("#selectEntidade").val();
                // var txtGrupoSelecionado = $("#selectEntidade").children("option:selected").text();
                // var valAnoSelecionado = $("#selectPeriodo").val();
                // alert("Grupo: " + $("#selectEntidade").val() + " Categorias: " + $("#selectCategorias").val() + " Ano: " + $("#selectPeriodo").val());
            });

            $("#btnAcao").on('click', function(){
                var valGrupoSelecionado     = $("#selectEntidade").val();
                var valCategoriaSelecionada = $("#selectCategorias").val();
                var valProdutosSelecionada  = $("#selectProdutos").val();
                alert(valGrupoSelecionado + " " + valCategoriaSelecionada + " " + valProdutosSelecionada);
            })

         });
    </script>
@endsection

