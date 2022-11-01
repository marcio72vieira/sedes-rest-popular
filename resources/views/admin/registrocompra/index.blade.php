@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>RESTAURANTES</strong></h5>

    <form action="{{route('admin.registrocompra.index')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
      <div class="form-group mx-sm-3 mb-2">
        <select name="regional_id" id="regional_id" class="form-control">
          <option value="" disabled>Região...</option>
          @foreach($regionais  as $regional)
            <option value="{{$regional->id}}" {{($regional->id == $idRegional ? 'selected' : '')}}> {{$regional->nome}} </option>
          @endforeach
          <option value="" disabled>-------------</option>
          <option value="100" {{($idRegional == 100 ? 'selected' : '')}}>TODAS</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
    </form>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Regional</th>
              {{--<th>Município - Bairro</th>--}}
              <th>Município</th>
              <th>Identificacao</th>
              {{--<th>Empresa</th>--}}
              <th>Responsáveis / Contato / E-mail</th>
              <th>Compras</th>
              <th>Ativo</th>
              <th style="width: 100px">Compras</th>
            </tr>
          </thead>

          <tbody>
          @foreach($restaurantes as $restaurante)
             <tr>
                <td>{{$restaurante->id}}</td>
                <td>{{$restaurante->municipio->regional->nome}}</td>
                {{-- <td>{{$restaurante->municipio->nome}} - {{$restaurante->bairro->nome}}</td>--}}
                <td>{{$restaurante->municipio->nome}}</td>
                <td>{{$restaurante->identificacao}}</td>
                <td>
                  <span style="font-size: 10px; color: blue">SEDES:</span>  {{$restaurante->user->nomecompleto}} / {{$restaurante->user->telefone}} / {{$restaurante->user->email}}<br>
                  <span style="font-size: 10px; color: blue">EMPRESA:</span> {{$restaurante->nutricionista->nomecompleto}} / {{$restaurante->nutricionista->telefone}} / {{$restaurante->nutricionista->email}}
                </td>
                <td style="text-align: center">{{$restaurante->qtdcomprasvinc($restaurante->id)}}</td>
                <td style="text-align: center">
                  @if($restaurante->ativo == 1) 
                    <b><i class="fas fa-check text-success mr-2"></i></b> 
                  @else 
                    <b><i class="fas fa-times  text-danger mr-2"></i></b> 
                  @endif
                </td>
                <td>
                  @if($restaurante->ativo == 1)
                    <a class="btn btn-light" href="{{route('admin.restaurante.compra.index', $restaurante->id)}}" title="compras"><i class="fas fa-shopping-cart text-success  mr-2"></i> registrar</a>
                  @else
                    <a class="btn btn-light" href="#" title="restaurante inativo"><i class="fas fa-times-circle text-danger mr-2"></i> registrar</a>
                  @endif
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
