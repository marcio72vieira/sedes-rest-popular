@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>NUTRICIONISTAS da Empresa: {{$empresa->nomefantasia}}</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.empresa.nutricionista.create', $empresa->id)}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        <a class="btn btn-primary float-right" href="{{route('admin.empresa.index')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-undo-alt"></i>
            Empresas
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
                <th>Email</th>
                <th>Fone</th>
                <th>CPF</th>
                <th>CRN</th>
                <th>Ativo</th>
                <th style="width: 165px;">Ação</th>
            </tr>
          </thead>

          <tbody>
          @foreach($nutricionistas as $nutricionista)
             <tr>
                <td scope="row">{{$nutricionista->id}}</td>
                <td>{{$nutricionista->nomecompleto}}</td>
                <td>{{$nutricionista->email}}</td>
                <td>{{$nutricionista->telefone}}</td>
                <td>{{$nutricionista->cpf}}</td>
                <td>{{$nutricionista->crn}}</td>
                <td>@if($nutricionista->ativo == 1) <b>SIM</b> @else NÃO @endif</td>
                <td>
                    <a href="{{route('admin.empresa.nutricionista.show', [$empresa->id, $nutricionista->id])}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                    <a href="{{route('admin.empresa.nutricionista.edit', [$empresa->id, $nutricionista->id])}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                    <a href="" data-toggle="modal" data-target="#formDelete{{$nutricionista->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>

                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                    <div class="modal fade" id="formDelete{{$nutricionista->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar Usuário</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <h5>{{$nutricionista->name}}</h5>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <form action="{{route('admin.empresa.nutricionista.destroy', [$empresa->id, $nutricionista->id])}}" method="POST" style="display: inline">
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
