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
                      </button>
                    </h2>
                    @if(session('error_compramensalrestaurante'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Atenção! </strong> {{session('error_compramensalrestaurante')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                  </div>
              
                  <div id="collapseum" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
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
                        </form>
                    </div>
                  </div>
                </div>
                
                {{-- Produção Restaurante Mês Ano --}}
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedois" aria-expanded="true" aria-controls="collapsedois">
                        <strong>Produção mês por Restaurantes</strong>
                      </button>
                    </h2>
                    @if(session('error_prodrestmesano'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Atenção! </strong> {{session('error_prodrestmesano')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                  </div>
              
                  <div id="collapsedois" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
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
                        </form>
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapsetres" aria-expanded="false" aria-controls="collapsetres">
                        Collapsible Group Item #2
                      </button>
                    </h2>
                  </div>
                  <div id="collapsetres" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="sr-only">Email</label>
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">pesquisar</button>
                        </form>
                    </div>
                  </div>
                </div>

              </div>
        </div>
   </div>
</div>
@endsection
