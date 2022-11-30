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
                        <strong>Compra semanal ou mensal por restaurante</strong>
                        <br>
                        <span>Recupera as compras realizadas na semana ou mês especificado pelo restaurante.</span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapseum" @if(session('error_compramensalrestaurante')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comprasemanalmensalrestaurante')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="restaurante_id" id="restaurante_id" class="form-control" required>
                              <option value="" selected disabled>Restaurante...</option>
                              @foreach($restaurantes  as $restaurante)
                                <option value="{{$restaurante->id}}"> {{$restaurante->identificacao}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="semana" id="semana" class="form-control">
                              <option value="" selected>Semana ...</option>
                              <option value="1" {{old('semana') == '1' ? 'selected' : ''}}>Um</option>
                              <option value="2" {{old('semana') == '2' ? 'selected' : ''}}>Dois</option>
                              <option value="3" {{old('semana') == '3' ? 'selected' : ''}}>Três</option>
                              <option value="4" {{old('semana') == '4' ? 'selected' : ''}}>Quatro</option>
                              <option value="5" {{old('semana') == '5' ? 'selected' : ''}}>Cinco</option>
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
                        <strong>Produtos comprados no mês por Restaurante</strong>
                        <br>
                        <span>
                            Recupera os produtos comprados pelo restaurante com suas respecitvas quantidades, unidades e valor total, no mês e ano especificado.
                        </span>
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


                {{-- Compra mensal municipio --}}
                <div class="card">
                  <div class="card-header" id="headingtres">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsetres" aria-expanded="true" aria-controls="collapsetres">
                        <strong>Produtos comprados no mês por Município</strong>
                        <br>
                        <span>
                            Recupera os produtos comprados pelos restaurantes de um município, em suas respectivas quantidadades, unidades e valor total, no mês e ano especificado.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsetres" @if(session('error_compramensalmunicipio')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.compramensalmunicipio')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_compramensalmunicipio'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_compramensalmunicipio')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Compra mensal regional produto --}}
                <div class="card">
                  <div class="card-header" id="headingseis">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseseis" aria-expanded="true" aria-controls="collapseseis">
                        <strong>Produtos comprados no mês pela Regional</strong>
                        <br>
                        <span>
                          Recupera os produtos comprados por todos os restaurantes de todos os municípios pertencentes a uma regional, em suas respectivas quantidadades, unidades e valor total, no mês e ano especificado.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapseseis" @if(session('error_compramensalregionalproduto')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.compramensalregionalproduto')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="regional_id" id="regional_id" class="form-control" required>
                              <option value="" selected disabled>Regional...</option>
                              @foreach($regioes  as $regional)
                                <option value="{{$regional->id}}"> {{$regional->nome}} </option>
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
                          @if(session('error_compramensalregionalproduto'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_compramensalregionalproduto')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>

                {{-- Compra mensal municipio valor --}}
                <div class="card">
                  <div class="card-header" id="headingquatro">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsequatro" aria-expanded="true" aria-controls="collapsequatro">
                        <strong>Valores Comprados no mês por Município</strong>
                        <br>
                        <span>
                            Recupera o valor total das compras realizadas pelos restaurantes de um município, no mês e ano especificados.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsequatro" @if(session('error_compramensalmunicipiovalor')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingquatro" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.compramensalmunicipiovalor')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_compramensalmunicipiovalor'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_compramensalmunicipiovalor')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Compra mensal regiao valor --}}
                <div class="card">

                  <div class="card-header" id="headingcinco">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsecinco" aria-expanded="true" aria-controls="collapsecinco">
                        <strong>Valores Comprados no mês por Região</strong>
                        <br>
                        <span>
                            Recupera o valor total das compras realizadas pelos municípios de uma região, no mês e ano especificados.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsecinco" @if(session('error_compramensalregiaovalor')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingcinco" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.compramensalregiaovalor')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="regiao_id" id="regiao_id" class="form-control" required>
                              <option value="" selected disabled>Região...</option>
                              @foreach($regioes  as $regiao)
                                <option value="{{$regiao->id}}"> {{$regiao->nome}} </option>
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
                          @if(session('error_compramensalregiaovalor'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_compramensalregiaovalor')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Mapa mensal produto restaurante --}}
                <div class="card">
                  <div class="card-header" id="headingsete">
                    <h2 class="mb-0" id="anchor-sete">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsesete" aria-expanded="true" aria-controls="collapsesete">
                        <strong>Mapa de produtos adquiridos por unidade no restaurante:</strong>
                        <br>
                        <span>
                          Recupera os produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsesete" @if(session('error_mapamensalprodutorestaurante')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalprodutorestaurante')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_mapamensalprodutorestaurante'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalprodutorestaurante')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Mapa mensal produto município --}}
                <div class="card">
                  <div class="card-header" id="headingoito">
                    <h2 class="mb-0" id="anchor-oito">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseoito" aria-expanded="true" aria-controls="collapseoito">
                        <strong>Mapa de produtos adquiridos por unidade no município:</strong>
                        <br>
                        <span>
                          Recupera os produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapseoito" @if(session('error_mapamensalprodutomunicipio')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalprodutomunicipio')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_mapamensalprodutomunicipio'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalprodutomunicipio')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>



                {{-- Mapa mensal produto regional --}}
                <div class="card">
                  <div class="card-header" id="headingnove">
                    <h2 class="mb-0" id="anchor-nove">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsenove" aria-expanded="true" aria-controls="collapsenove">
                        <strong>Mapa de produtos adquiridos por unidade na região:</strong>
                        <br>
                        <span>
                          Recupera os produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsenove" @if(session('error_mapamensalprodutoregional')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalprodutoregional')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="regional_id" id="regional_id" class="form-control" required>
                              <option value="" selected disabled>Regional...</option>
                              @foreach($regioes  as $regional)
                                <option value="{{$regional->id}}"> {{$regional->nome}} </option>
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
                          @if(session('error_mapamensalprodutoregional'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalprodutoregional')}}
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
