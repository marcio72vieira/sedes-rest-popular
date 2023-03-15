@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>RESTAURANTES</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.restaurante.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>


        <a class="btn btn-primary btn-danger" href="{{route('admin.restaurante.relpdfrestaurante')}}" role="button" style="margin-bottom: 10px" target="_blank">
          <i class="far fa-file-pdf"></i> pdf
        </a>


        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>OK!</strong> {{session('sucesso')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableRestaurante" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>Id</th>
                    <th>Município</th>
                    <th>Identificacao</th>
                    <th>Responsáveis / Contato / E-mail</th>
                    <th>Compras</th>
                    <th>Ativo</th>
                    <th style="width: 100px">Ações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Id</th>
                    <th>Município</th>
                    <th>Identificacao</th>
                    <th>Responsáveis / Contato / E-mail</th>
                    <th>Compras</th>
                    <th>Ativo</th>
                    <th style="width: 100px">Ações</th>
                    </tr>
                </tfoot>
                </table>

                {{-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro --}}
                <div class="modal fade" id="formDelete" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar restaurante</strong></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <h5 id='h5identificacao'></h5>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                <form id="formdelete" action="" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" role="button"> Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            // DataTable
            $('#dataTableRestaurante').DataTable({

                order: [[ 0, 'desc' ]],     // Exibe os registros em ordem decrescente pelo ID (coluna 0) (Regra de negócio: último registro cadastrado)
                columnDefs: [               // Impede que as colunas 3, 4, 5 e 6 sejam ordenadas pelo usuário
                    { orderable: false, targets: [3, 4, 5, 6] }
                ],
                //lengthMenu: [5, 10, 20, 50, 100, 200, 500], //Configura o número de entra de registro a serem exibido por pagina

                processing: true,
                serverSide: true,
                ajax: "{{route('admin.ajaxgetRestaurantes')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
                // Obs: Para fazer a ordenação, o nome das colunas abaixo, devem conicidir com o nome dos campos retornados pela query na recuperação dos registros desejados
                columns: [
                    { data: 'id' },
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

            // No script abaixo, uma função é disparada quando o usuário clicar exatamente [on('click', '.deleterestaurante')] em cima do ícone
            // deletar (definido como um botão no controller: RestauranteController) cuja a classe está definida como ".deleterestaurante".
            // Disparada esta função o id e o nome do restaurante são recuperados através dos dados armazenados nas propriedades
            // "data-idrestaurante" e "data-identificacaorestaurante", do mesmo ícone de botão deletar também definido no controller RestauranteController.
            // A "route" é uma string completa que possui o nome da rota juntamente com o id do restaurante. Infelizmente não tem
            // como referenciar uma variável javascript em um script PHP(Laravel), por isso houve a necessidade de fazer esse junção
            // com o recurso de substituição: route = route.replace('id', idrestaurante);
            $('#dataTableRestaurante').on('click', '.deleterestaurante', function(event){
                var idRestaurante = $(this).data('idrestaurante');
                var identificacaoRestaurante = $(this).data('identificacaorestaurante');
                var route = "{{route('admin.restaurante.destroy', 'id')}}";
                    route = route.replace('id', idRestaurante);

                // alert($(this).data('idrestaurante')); // alert($(this).data('identificacaoRestaurante')); // alert(route);

                $('#h5identificacao').text(identificacaoRestaurante);
                $('#formdelete').attr('action', route);
            });

         });
    </script>
@endsection

