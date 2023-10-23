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
                            <th rowspan="3" style="vertical-align: middle; text-align:center">Regionais</th>
                            <th colspan="24" style="vertical-align: middle; text-align:center">MÊSES</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">TOTAL</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">PERCENT</th>
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

            // Mudar o valor dessa rota conforme escolha do select an toolbar do datatable
            // var route = "{{route('admin.ajaxgetMonitorRestaurantes')}}";

            // DataTable
            $('#dataTableMonitor').DataTable({

                order: [[ 1, 'asc' ]],     // Exibe os registros em ordem decrescente pelo ID (coluna 0) (Regra de negócio: último registro cadastrado)

                // columnDefs: [               // Impede que as colunas 3, 4, 5 e 6 sejam ordenadas pelo usuário
                //     { orderable: false, targets: [3, 4, 5] }
                // ],

                lengthMenu: [10, 20, 30, 40, 50, 100, 150, 200], //Configura o número de entra de registro a serem exibido por pagina
                // pageLength: 5, //Define a quantidade de registros a serem exibidos independente da escolha feita em: lengthMenu


                processing: true,
                serverSide: true,

                //ajax: "{{route('admin.ajaxgetMonitorRestaurantes')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
                ajax: "{{route('admin.ajaxgetRegionaisComprasMensais')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
                // ajax: {
                //     url: "{{route('admin.ajaxgetMonitorComprasMensais')}}",
                //     data: function(d){
                //         d.grupoEnviado = "Regionais";
                //     }
                // },


                columns: [
                    { data: 'id' },
                    { data: 'regional' },
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
                pagingType: "simple_numbers",
                //pagingType: "full_numbers", // Todos os links de paginação   "simple_numbers" // Sómente anterior; seguinte e os núemros da página:
                //scrollY: 450,

            });

            // Adicionando um select na toolbar do datatable
            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Escolha</label>');
            $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
            $("#selectGrupo").on('change', function(){
                alert($(this).children("option:selected").text());
            });

         });

    </script>
@endsection

