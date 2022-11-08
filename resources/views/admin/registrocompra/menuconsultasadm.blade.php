@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>CONSULTAS</h5>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="accordion" id="accordionExample">

                {{-- Compra Mensal por Restaurante --}}
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseum" aria-expanded="true" aria-controls="collapseum">
                        <strong>Compra mensal por restaurante</strong>
                        <br>
                        <span>Recupera todas as compras realizadas no restaurante durante o mês/ano!</span>
                      </button>
                    </h2>
                  </div>
              
                  <div id="collapseum" @if(session('error_compramensalrestaurante')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.compramensalrestaurante')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="restaurante_id" id="restaurante_id" class="form-control" required>
                              <option value="" selected disabled>Restaurante...</option>
                              @foreach($restaurantes  as $restaurante)
                                <option value="{{$restaurante->id}}"> {{$restaurante->identificacao}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="mes_id" id="mes_id" class="form-control" required>
                              <option value="" selected disabled>Mês...</option>
                              @foreach($mesespesquisa as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="ano_id" id="ano_id" class="form-control" required>
                              <option value="" selected disabled>Ano...</option>
                              @foreach($anospesquisa as $value)
                                <option value="{{ $value}}"> {{ $value }} </option>
                              @endforeach
                            </select>
                          </div>
                          <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
                          @if(session('error_compramensalrestaurante'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_compramensalrestaurante')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>
                
                {{-- Produção Restaurante Mês Ano --}}
                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedois" aria-expanded="true" aria-controls="collapsedois">
                        <strong>Produção mensal por Restaurantes</strong>
                        <br>
                        <span>Recupera a quantidade e valor dos produtos comprados, por unidade, no restaurante no mês e ano específico!</span>
                      </button>
                    </h2>
                  </div>
              
                  <div id="collapsedois" @if(session('error_prodrestmesano')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.producaorestmesano')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="restaurante_id" id="restaurante_id" class="form-control" required>
                              <option value="" selected disabled>Restaurante...</option>
                              @foreach($restaurantes  as $restaurante)
                                <option value="{{$restaurante->id}}"> {{$restaurante->identificacao}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="mes_id" id="mes_id" class="form-control" required>
                              <option value="" selected disabled>Mês...</option>
                              @foreach($mesespesquisa as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="ano_id" id="ano_id" class="form-control" required>
                              <option value="" selected disabled>Ano...</option>
                              @foreach($anospesquisa as $value)
                                <option value="{{ $value}}"> {{ $value }} </option>
                              @endforeach
                            </select>
                          </div>
                          <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
                          @if(session('error_prodrestmesano'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_prodrestmesano')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Produção mensal municipio --}}
                <div class="card">
                  <div class="card-header" id="headingtres">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsetres" aria-expanded="true" aria-controls="collapsetres">
                        <strong>Produção mensal por Município</strong>
                        <br>
                        <span>Recupera a quantidade e valor dos produtos comprados, por unidade, no município no mês e ano específico!</span>
                      </button>
                    </h2>
                  </div>
              
                  <div id="collapsetres" @if(session('error_prodmunicipio')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.producaomensalmunicipio')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="municipio_id" id="municipio_id" class="form-control" required>
                              <option value="" selected disabled>Município...</option>
                              @foreach($municipios  as $municipio)
                                <option value="{{$municipio->id}}"> {{$municipio->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="mes_id" id="mes_id" class="form-control" required>
                              <option value="" selected disabled>Mês...</option>
                              @foreach($mesespesquisa as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="ano_id" id="ano_id" class="form-control" required>
                              <option value="" selected disabled>Ano...</option>
                              @foreach($anospesquisa as $value)
                                <option value="{{ $value}}"> {{ $value }} </option>
                              @endforeach
                            </select>
                          </div>
                          <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
                          @if(session('error_prodmunicipio'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_prodmunicipio')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>

                
              </div>
        </div>
   </div>
</div>
@endsection
