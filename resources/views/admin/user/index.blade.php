@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>USUÁRIOS</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.user.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>


        <a class="btn btn-primary btn-danger" href="{{route('admin.user.relpdfuser')}}" role="button" style="margin-bottom: 10px" target="_blank">
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
                <th>Usuário / Nome Completo</th>
                <th>Perfil</th>
                <th>Cidade</th>
                <th>E-mail / Telefone</th>
                <th>CPF / CRN</th>
                <th>Restaurante</th>
                <th>Ativo</th>
                <th style="width: 80px;">Ação</th>
            </tr>
          </thead>

          <tbody>
          @foreach($users as $user)
             <tr class="destaque">
                <td scope="row">{{$user->id}}</th>
                <td>{{$user->name}}  <br> {{$user->nomecompleto}}</td>
                {{-- <td>@if($user->perfil == 'adm') <b>ADMINISTRADOR</b> @elseif($user->perfil == 'nut') Nutricionista @else Nutricionista (inativo) @endif </td> --}}
                <td>@if($user->perfil == 'adm') <b>ADMINISTRADOR</b> @else Nutricionista @endif </td>
                <td>{{$user->municipio->nome}}</td>
                <td>{{$user->email}} <br> {{$user->telefone}}</td>
                <td>{{$user->cpf}} <br> {{$user->crn}} </td>
                <td>@isset($user->restaurante->identificacao) {{$user->restaurante->identificacao}} @endisset</td>
                <td style="text-align: center">
                    @if($user->perfil == "adm"  || $user->perfil == "nut")
                        <b><i class="fas fa-check text-success mr-2"></i></b>
                    @else
                        <b><i class="fas fa-times  text-danger mr-2"></i></b>
                    @endif
                </td>
                <td>
                    <a href="{{route('admin.user.show', $user->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                    <a href="{{route('admin.user.edit', $user->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                    @if($user->qtdrestaurantevinc($user->id) == 0 && $user->qtdcomprasvinc($user->id) == 0)
                        <a href="" data-toggle="modal" data-target="#formDelete{{$user->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                    @else
                        <a href="" title="Vinculado a um restaurante ou compra(s)"><i class="fas fa-trash text-secondary mr-2"></i></a>
                    @endif

                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                    <div class="modal fade" id="formDelete{{$user->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar Usuário</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <h5>{{$user->name}}</h5>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <form action="{{route('admin.user.destroy', $user->id)}}" method="POST" style="display: inline">
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
