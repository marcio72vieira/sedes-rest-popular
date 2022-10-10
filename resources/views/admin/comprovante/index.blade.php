@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>COMPROVANTES Ref. à conpra de nº {{ $compra->id }}</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.compra.comprovante.create', [$compra->id])}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        {{-- Obs: Eu não tenho uma rota do tipo compra.index mas sim restaurante.compra.index, visto que compra é aninhada --}}
        <a class="btn btn-primary float-right" href="{{route('admin.restaurante.compra.index', [$compra->restaurante_id])}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-undo-alt"></i>
            Listar Compras do restaurante: {{ $compra->restaurante->identificacao }}
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
                            <th>Compra</th>
                            <th>Valor</th>
                            <th>Valor AF</th>
                            <th>Valor Total</th>
                            <th>Comprovantes</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($comprovantes as $comprovante)
                            <tr>
                                <td>{{$comprovante[0]}}</td>
                                <td>{{$comprovante[0]}}</td>
                                {{--
                                <td>@if($categoria->ativo == 1) <b>SIM</b> @else NÃO @endif</td>
                                <td>
                                    <a href="{{route('admin.categoria.show', $categoria->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.categoria.edit', $categoria->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    <a data-idcategoria="{{$categoria->id}}" class="deletarcategoria" href="" data-toggle="modal" data-target="#formDelete{{$categoria->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>

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
                                                    <h5>{{$categoria->nome}}</h5>
                                                    <span class="mensagem" style="color: #f00;"></span>
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
                                --}}
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
