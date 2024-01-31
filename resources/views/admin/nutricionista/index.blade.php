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
            Listar Empresas
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
                <th>CPF / CRN</th>
                <th>Restaurante</th>
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
                <td>{{$nutricionista->cpf}} <br> {{$nutricionista->crn}}</td>
                <td>@isset($nutricionista->restaurante->identificacao) {{$nutricionista->restaurante->identificacao}} @endisset</td>
                <td>@if($nutricionista->ativo == 1) <b><i class="fas fa-check text-success mr-2"></i></b> @else <b><i class="fas fa-times  text-danger mr-2"></i></b> @endif</td>
                <td>
                    <a href="{{route('admin.empresa.nutricionista.show', [$empresa->id, $nutricionista->id])}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                    <a href="{{route('admin.empresa.nutricionista.edit', [$empresa->id, $nutricionista->id])}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>

                    <!-- Remanejamento de Nutricionista de uma Empresa para Outra empresa. O mesmo não deve está vinculado a um restaurante -->
                    @if($nutricionista->qtdrestaurantevinc($nutricionista->id) == 0)
                        <a href="" data-toggle="modal" data-target="#formRemaneje{{$nutricionista->id}}" title="remanejar"><i class="fas fa-retweet text-danger mr-2"></i></a>
                    @else
                        <a href="" title="Vinculado a um restaurante"><i class="fas fa-retweet text-secondary mr-2"></i></a>
                    @endif

                    <!-- Deleção de Nutricionista de uma Empresa. O mesmo não deve está vinculado a um restaurante e nem ter realizado compras -->
                    @if($nutricionista->qtdrestaurantevinc($nutricionista->id) == 0 && $nutricionista->qtdcomprasvinc($nutricionista->id) == 0)
                        <a href="" data-toggle="modal" data-target="#formDelete{{$nutricionista->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                    @else
                        <a href="" title="Vinculado a um restaurante ou compra(s)"><i class="fas fa-trash text-secondary mr-2"></i></a>
                    @endif


                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                    <div class="modal fade" id="formDelete{{$nutricionista->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar Nutricionista</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <h5>{{$nutricionista->nomecompleto}}</h5>
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


                    <!-- MODAL formRemaneje OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                    <div class="modal fade" id="formRemaneje{{$nutricionista->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="formRemanejeLabel"><strong>Remanejar Nutricionista</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                Remanejar:
                                <h5>{{$nutricionista->nomecompleto}}</h5>

                                da Empresa:
                                <h5>{{$nutricionista->empresa->nomefantasia}}</h5>

                                para Empresa:
                                <div class="form-group focused">
                                    <select name="empresa_id" id="empresa_id" class="form-control" required>
                                        <option value="" selected disabled>Escolha...</option>
                                        @foreach($empresas  as $empresa)
                                            <option value="{{$empresa->id}}" {{$nutricionista->empresa->id == $empresa->id ? 'disabled' : ''}}>{{$empresa->nomefantasia}}</option>
                                        @endforeach
                                    </select>
                                    @error('empresa_id')
                                        <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
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
