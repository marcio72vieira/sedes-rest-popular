@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>PRODUTOS</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.produto.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        <a class="btn btn-primary btn-danger" href="{{route('admin.produto.relpdfproduto')}}" role="button" style="margin-bottom: 10px" target="_blank">
            <i class="far fa-file-pdf"></i>pdf
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
                            <th>Categoria</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($produtos as $produto)
                            <tr>
                                <td>{{$produto->id}}</td>
                                <td>{{$produto->nome}}</td>
                                <td>{{$produto->categoria->nome}}</td>
                                <td>@if($produto->ativo == 1) <b>SIM</b> @else NÃO @endif</td>
                                <td>
                                    <a href="{{route('admin.produto.show', $produto->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.produto.edit', $produto->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    {{-- <a href="" data-toggle="modal" data-target="#formDelete{{$produto->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a> --}}
                                    @if($produto->qtdcomprasvinc($produto->id) == 0)
                                        <a href="" data-toggle="modal" data-target="#formDelete{{$produto->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                                    @else
                                        <a href="" title="há compras vinculadas!"><i class="fas fa-trash text-secondary mr-2"></i></a>
                                    @endif

                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$produto->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar produto</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="alert alert-danger">ATENÇÃO! Esta operação não tem retorno!</p>
                                                    <h5>{{$produto->nome}}</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.produto.destroy', $produto->id)}}" method="POST" style="display: inline">
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
