@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>CATEGORIAS</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.categoria.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        <a class="btn btn-primary btn-danger" href="{{route('admin.categoria.relpdfcategoria')}}" role="button" style="margin-bottom: 10px" target="_blank">
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Nº Produtos</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->id}}</td>
                                <td>{{$categoria->nome}}</td>
                                <td>{{$categoria->qtdprodutosvinc($categoria->id)}}</td>
                                <td>@if($categoria->ativo == 1) <b>SIM</b> @else NÃO @endif</td>
                                <td>
                                    <a href="{{route('admin.categoria.listarprodutos', $categoria->id)}}" title="produtos desta categoria"><i class="fas fa-list text-success mr-2"></i></i></a>
                                    <a href="{{route('admin.categoria.show', $categoria->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.categoria.edit', $categoria->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    @if($categoria->qtdprodutosvinc($categoria->id) == 0)
                                        <a href="" data-toggle="modal" data-target="#formDelete{{$categoria->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                                    @else
                                        <a href="" title="há produtos vinculados!"><i class="fas fa-trash text-secondary mr-2"></i></a>
                                    @endif
                                    
                                    {{--<a data-idcategoria="{{$categoria->id}}" class="deletarcategoria" href="" data-toggle="modal" data-target="#formDelete{{$categoria->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>--}}
                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$categoria->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar categoria</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="alert alert-danger">ATENÇÃO! Esta operação não tem retorno!</p>
                                                    <h5>{{$categoria->nome}}</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.categoria.destroy', $categoria->id)}}" method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" role="button"> Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
   </div>
</div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection
