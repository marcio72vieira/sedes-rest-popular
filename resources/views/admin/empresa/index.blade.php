@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>EMPRESAS</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.empresa.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
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
              <th>Representante</th>
              <th>Email</th>
              <th>Contato(s)</th>
              <th>Ativo</th>
              <th style="width: 110px">Ações</th>
            </tr>
          </thead>

          <tbody>
          @foreach($empresas as $empresa)
             <tr>
                <td>{{$empresa->id}}</td>
                <td>{{$empresa->nomefantasia}}</td>
                <td>{{$empresa->titular}}</td>
                <td>{{$empresa->email}}</td>
                <td>{{$empresa->celular}} / {{$empresa->fone}}</td>
                <td>{{$empresa->ativo == 1 ? 'SIM' : 'NÃO'}}</td>
                <td>@if($empresa->ativo == 1)
                      <a href="{{route('admin.empresa.nutricionista.index', $empresa->id)}}" title="cadastrar nutricionistas"><i class="fas fa-user-friends text-success mr-2"></i></a>
                    @else
                      <a href="#" title="cadastrar nutricionistas"><i class="fas fa-user-friends text-default mr-2"></i></a>
                    @endif
                    <a href="{{route('admin.empresa.show', $empresa->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                    <a href="{{route('admin.empresa.edit', $empresa->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                    {{--<a href="{{route('admin.empresa.ficha', $empresa->id)}}" title="ficha" target="_blank"><i class="far fa-file-pdf text-danger mr-2"></i></a>--}}
                    <a href="" data-toggle="modal" data-target="#formDelete{{$empresa->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                    
                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                    <div class="modal fade" id="formDelete{{$empresa->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar empresa</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <h5>{{$empresa->nomefantasia}}</h5>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <form action="{{route('admin.empresa.destroy', $empresa->id)}}" method="POST" style="display: inline">
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
