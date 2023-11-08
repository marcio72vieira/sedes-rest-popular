@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>MONITOR DE COMPRAS</strong></h5>


    <!-- DataTales Example -->
    <div class="mb-4 shadow card">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableMonitor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">Id</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center" id="entidade">Regionais</th>
                            <th colspan="24" style="vertical-align: middle; text-align:center" id="mesesdoano">ANO: @php echo date("Y") @endphp</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">TOTAL<br>PARCIAL</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">TOTAL<br>GERAL</th>
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

            rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
            periodoAno = new Date().getFullYear();
            
            // anospesquisa = "{$anospesquisa}"; // {variavel}, desta forma evita erro de htmlspecialchar
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

            
            // DataTable. Aqui, estamos atribuindo todo o dataTable à uma variável, para posterior manipulação caso seja necessário
            var oTable = $('#dataTableMonitor').DataTable({
                //## Fixando colunas e cabeçalhos
                fixedColumns: {
                    left: 2,
                    //right: 5,
                },
                //paging: false,
                scrollCollapse: true,
                scrollY: '400px',
                scrollX: true,

                //## Exibindo button
                //dom: "Blfrtip",
                //    "buttons": [
                //        'copy', 'csv', 'excel', 'pdf', 'print'
                //    ],


                order: [[ 1, 'asc' ]],     // Exibe os registros em ordem decrescente pelo ID (coluna 0) (Regra de negócio: último registro cadastrado)

                columnDefs: [               // Impede que as colunas 3, 4, 5 e 6 sejam ordenadas pelo usuário
                    { orderable: false, targets: [26, 27, 28, 29, 30] }
                ],

                lengthMenu: [10, 15, 20, 25, 30, 35, 40, 45, 50], //Configura o número de entra de registro a serem exibido por pagina
                // pageLength: 5, //Define a quantidade de registros a serem exibidos independente da escolha feita em: lengthMenu


                processing: true,   // Indicador de processamento
                serverSide: true,

                //ajax: "{{route('admin.ajaxgetRegionaisComprasMensais')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
                /* ajax: {
                    url: "{{route('admin.ajaxgetRegionaisComprasMensais')}}",
                    data: function(d){
                        //d.grupoEnviado = "Regionais";
                        d.periodo = $("#selectPeriodo").val();
                    }
                }, 
                */

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
                //pagingType: "simple_numbers",
                pagingType: "full_numbers", // Todos os links de paginação   "simple_numbers" // Sómente anterior; seguinte e os núemros da página:
                //scrollY: 450,

                // Quando a tabela estiver completamente inicializada(carregada), executa a função abaixo
                initComplete: function (settings, json) {
                    /*
                    // "#dataTableMonitor_length" é o nome atribuido dinamicamente à div onde está localizado o menu de 
                    // de opçoes length. Nesse caso nesta div adicionando um select na toolbar do datatable
                    $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Escolha</label>');
                    $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
                    $("#selectGrupo").on('change', function(){
                        alert($(this).children("option:selected").text());
                        //alert(oTable.ajax.data);
                        //oTable.ajax.reload();
                        //oTable.draw();
                    });
                    */
                    //$('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Período:</label>');
                    //$('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"><option value="2023" selected>2023</option><option value="2024">2024</option><option value="2025">2025</option></select>');
                }

            });

            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Compras por:</label>');
            $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
            
            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Período:</label>');
            //$('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"><option value="2023" selected>2023</option><option value="2024">2024</option><option value="2025">2025</option></select>'); // OU
            $('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"></select>');
            $.each(anosexibicao, function(indx, valorano) {
                    $('#selectPeriodo').append($('<option></option>').val(valorano).html(valorano));
            });

            
            $("#selectGrupo, #selectPeriodo").on('change', function(){
                //alert($(this).children("option:selected").text());
                //alert(oTable.ajax.data);
                var entidadeSelecionada = $(this).children("option:selected").text();
                //var rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                periodoAno = $("#selectPeriodo").val();

                switch (entidadeSelecionada){
                    case "Regionais":
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
                    break;
                    case "Municipios":
                        rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                    break;
                    case "Restaurantes":
                        rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
                    break;
                    default:
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";

                }
                $("#entidade").text(entidadeSelecionada);
                $("#mesesdoano").text("ANO: " + periodoAno);
                //oTable.ajax.url("{{route('admin.ajaxgetMunicipiosComprasMensais')}}");
                oTable.ajax.url(rotaAjax).load();
                //oTable.ajax.reload();
            });
         });

    </script>
@endsection

