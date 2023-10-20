@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>MONITOR</strong></h5>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableMonitor" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>Id</th>
                    <th>Regional</th>
                    <th>Município</th>
                    <th>Restaurante</th>
                    <th>Responsáveis / Contato / E-mail</th>
                    <th>Compras</th>
                    <th>Ativo</th>
                    <th style="width: 100px">Ações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Id</th>
                    <th>Regional</th>
                    <th>Município</th>
                    <th>Restaurante</th>
                    <th>Responsáveis / Contato / E-mail</th>
                    <th>Compras</th>
                    <th>Ativo</th>
                    <th style="width: 100px">Ações</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            // DataTable
            $('#dataTableMonitor').DataTable({

                order: [[ 0, 'desc' ]],     // Exibe os registros em ordem decrescente pelo ID (coluna 0) (Regra de negócio: último registro cadastrado)
                columnDefs: [               // Impede que as colunas 3, 4, 5 e 6 sejam ordenadas pelo usuário
                    { orderable: false, targets: [3, 4, 5, 6] }
                ],
                lengthMenu: [10, 20, 30, 40, 50, 100, 150, 200], //Configura o número de entra de registro a serem exibido por pagina

                processing: true,
                serverSide: true,
                ajax: "{{route('admin.ajaxgetMonitorRestaurantes')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
                // Obs: O corpo da tabela com o dados e os ícones das ações (show, edit e delete), é construido no método "ajaxgetRestaurantes" do controller RestauranteController
                // Obs: Para fazer a ordenação, o nome das colunas abaixo, devem conincidir com o nome dos campos retornados pela query na recuperação dos registros desejados
                columns: [
                    { data: 'id' },
                    { data: 'regional' },
                    { data: 'municipio' },
                    { data: 'identificacao' },
                    { data: 'responsaveis' },
                    { data: 'compras' },
                    { data: 'ativo' },
                    { data: 'actions'}
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
                pagingType: "full_numbers", // Todos os links de paginação   "simple_numbers" // Sómente anterior; seguinte e os núemros da página:

            });
         });
    </script>
@endsection

