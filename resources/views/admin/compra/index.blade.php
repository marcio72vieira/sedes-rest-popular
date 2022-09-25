@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>COMPRAS: Restaurante {{ $restaurante->identificacao }} em {{$restaurante->municipio->nome}}</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.restaurante.compra.create', $restaurante->id)}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        <a class="btn btn-primary float-right" href="{{route('admin.restaurante.index')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-undo-alt"></i>
            Restaurantes
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
                            <th>Semana</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Valor AF</th>
                            <th>Valor Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($compras as $compra)
                            <tr>
                                <td>{{$compra->id}}</td>
                                <td>{{$compra->semana}}</td>
                                <td>{{$compra->data_ini}} a {{$compra->data_ini}}</td>
                                <td>{{$compra->valorsemaf}}</td>
                                <td>{{$compra->valorcomaf}}</td>
                                <td>{{$compra->valortotal}}</td>
                                <td>
                                    <a href="{{route('admin.restaurante.compra.show', [$restaurante->id, $compra->id])}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.restaurante.compra.edit', [$restaurante->id, $compra->id])}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    <a href="" data-toggle="modal" data-target="#formDelete{{$compra->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>

                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$compra->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar compra</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>{{$compra->nome}}</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.restaurante.compra.destroy', [$restaurante->id, $compra->id])}}" method="POST" style="display: inline">
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
