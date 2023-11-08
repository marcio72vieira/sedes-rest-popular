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
            });

            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Compras</label>');
            $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municípios</option><option value="rest">Restaurantes</option><option disabled>___________</option><option value="rest">Categorias</option><option value="rest">Produtos</option></select>');
            
            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Ano</label>');
            $('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"></select>');
            $.each(anosexibicao, function(indx, valorano) {
                    $('#selectPeriodo').append($('<option></option>').val(valorano).html(valorano));
            });

            
            $("#selectGrupo, #selectPeriodo").on('change', function(){
                var entidadeSelecionada = $("#selectGrupo").children("option:selected").text();
                periodoAno = $("#selectPeriodo").val();

                switch (entidadeSelecionada){
                    case "Regionais":
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
                    break;
                    case "Municípios":
                        rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                    break;
                    case "Restaurantes":
                        rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
                    break;
                    case "Categorias":
                        rotaAjax = "{{route('admin.ajaxgetCategoriasComprasMensais')}}";
                    break;
                    case "Produtos":
                        rotaAjax = "{{route('admin.ajaxgetProdutosComprasMensais')}}";
                    break;
                    default:
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";

                }
                $("#entidade").text(entidadeSelecionada);
                $("#mesesdoano").text("COMPRAS POR " + entidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                oTable.ajax.url(rotaAjax).load();
            });
         });
    </script>
@endsection

