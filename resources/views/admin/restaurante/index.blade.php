@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>RESTAURANTES</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.restaurante.create')}}" role="button" style="margin-bottom: 10px">
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
              {{--<th>Município - Bairro</th>--}}
              <th>Município</th>
              <th>Identificacao</th>
              {{--<th>Empresa</th>--}}
              <th>Responsáveis / Contato / E-mail</th>
              <th>Ativo</th>
              <th style="width: 90px">Ações</th>
            </tr>
          </thead>

          <tbody>
          @foreach($restaurantes as $restaurante)
             <tr>
                <td>{{$restaurante->id}}</td>
                {{-- <td>{{$restaurante->municipio->nome}} - {{$restaurante->bairro->nome}}</td>--}}
                <td>{{$restaurante->municipio->nome}}</td>
                <td>{{$restaurante->identificacao}}</td>
                {{--<td>{{$restaurante->empresa->nomefantasia}}</td>--}}
                {{--<td>{{$restaurante->ativo == 1 ? 'SIM' : 'NÃO'}}</td>--}}
                <td>
                  <span style="font-size: 10px; color: blue">SEDES:</span>  {{$restaurante->user->nomecompleto}} / {{$restaurante->user->telefone}} / {{$restaurante->user->email}}<br>  
                  <span style="font-size: 10px; color: blue">EMPRESA:</span> {{$restaurante->nutricionista->nomecompleto}} / {{$restaurante->nutricionista->telefone}} / {{$restaurante->nutricionista->email}}
                </td>
                <td>@if($restaurante->ativo == 1) <b><i class="fas fa-check text-success mr-2"></i></b> @else <b><i class="fas fa-times  text-danger mr-2"></i></b> @endif</td>
                <td>
                    <a href="" title="compras"><i class="fas fa-shopping-cart"></i></a>
                    <a href="{{route('admin.restaurante.show', $restaurante->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                    <a href="{{route('admin.restaurante.edit', $restaurante->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                    {{--<a href="{{route('admin.restaurante.ficha', $restaurante->id)}}" title="ficha" target="_blank"><i class="far fa-file-pdf text-danger mr-2"></i></a>--}}
                    <a href="" data-toggle="modal" data-target="#formDelete{{$restaurante->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>

                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                    <div class="modal fade" id="formDelete{{$restaurante->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar restaurante</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <h5>{{$restaurante->identificacao}}</h5>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <form action="{{route('admin.restaurante.destroy', $restaurante->id)}}" method="POST" style="display: inline">
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
