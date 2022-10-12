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

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ERRO!!!</strong> {{session('error')}}
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
                            <th>Compra</th>
                            <th>Comprovantes</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($comprovantes as $comprovante)
                            <tr>
                                <td>{{$comprovante->id}}</td>
                                <td>{{$comprovante->compra_id}}</td>
                                <td style="text-align: center">
                                    <a href="{{asset('/storage/'.$comprovante->url)}}" target="_blank">
                                        <img src="{{asset('template/img/icopdf.png')}}" width="20">
                                    </a>
                                </td>
                                <td>
                                    <a data-idcomprovante="{{$comprovante->id}}" class="deletarcomprovante" href="" data-toggle="modal" data-target="#formDelete{{$comprovante->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>

                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$comprovante->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar comprovante</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>{{$comprovante->id}} da compra {{$comprovante->compra_id}}</h5>
                                                    <span class="mensagem" style="color: #f00;"></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.compra.comprovante.destroy', [$compra->id, $comprovante->id])}}" method="POST" style="display: inline">
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
