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
                        <strong>Mapa de produtos adquiridos por unidade no restaurante</strong>
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
                        <strong>Mapa de produtos adquiridos por unidade no município</strong>
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
                        <strong>Mapa de produtos adquiridos por unidade na região</strong>
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
          

                {{-- Mapa mensal produto geral - inclui todas as regionais --}}
                <div class="card">
                  <div class="card-header" id="headingdez">
                    <h2 class="mb-0" id="anchor-dez">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedez" aria-expanded="true" aria-controls="collapsedez">
                        <strong>Mapa mensal GERAL de produtos adquiridos por unidade</strong>
                        <br>
                        <span>
                          Recupera os produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF de todas as regionais
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsedez" @if(session('error_mapamensalgeralproduto')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalgeralproduto')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
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
                          @if(session('error_mapamensalgeralproduto'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalgeralproduto')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Mapa mensal categoria restaurante --}}
                <div class="card">
                  <div class="card-header" id="headingonze">
                    <h2 class="mb-0" id="anchor-onze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseonze" aria-expanded="true" aria-controls="collapseonze">
                        <strong>Mapa de produtos adquiridos por categorias em unidade no restaurante</strong>
                        <br>
                        <span>
                          Recupera as categorias dos produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapseonze" @if(session('error_mapamensalcategoriarestaurante')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalcategoriarestaurante')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_mapamensalcategoriarestaurante'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalcategoriarestaurante')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>
                


                {{-- Mapa mensal categoria municipio --}}
                <div class="card">
                  <div class="card-header" id="headingdoze">
                    <h2 class="mb-0" id="anchor-doze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedoze" aria-expanded="true" aria-controls="collapsedoze">
                        <strong>Mapa de produtos adquiridos por categorias em unidade no municipio</strong>
                        <br>
                        <span>
                          Recupera as categorias dos produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsedoze" @if(session('error_mapamensalcategoriamunicipio')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalcategoriamunicipio')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_mapamensalcategoriamunicipio'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalcategoriamunicipio')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Mapa mensal categoria regional --}}
                <div class="card">
                  <div class="card-header" id="headingtreze">
                    <h2 class="mb-0" id="anchor-treze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsetreze" aria-expanded="true" aria-controls="collapsetreze">
                        <strong>Mapa de produtos adquiridos por categorias em unidade na região</strong>
                        <br>
                        <span>
                          Recupera as categorias dos produtos adquiridos no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsetreze" @if(session('error_mapamensalcategoriaregional')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalcategoriaregional')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
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
                          @if(session('error_mapamensalcategoriaregional'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalcategoriaregional')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Mapa mensal categoria geral - inclui todas as regionais --}}
                <div class="card">
                  <div class="card-header" id="headingquatorze">
                    <h2 class="mb-0" id="anchor-quatorze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsequatorze" aria-expanded="true" aria-controls="collapsequatorze">
                        <strong>Mapa mensal GERAL de produtos adquiridos por categoria em unidade</strong>
                        <br>
                        <span>
                          Recupera os produtos adquiridos por categori no mês em suas unidades, quantidades e valores, bem como seus respectivos percentuais na AF de todas as regionais
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsequatorze" @if(session('error_mapamensalgeralcategoria')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.mapamensalgeralcategoria')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
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
                          @if(session('error_mapamensalgeralcategoria'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_mapamensalgeralcategoria')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>


                {{-- Comparativo mensal produtos por município - inclui todos os restaurante do município --}}
                <div class="card">
                  <div class="card-header" id="headingquinze">
                    <h2 class="mb-0" id="anchor-quinze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsequinze" aria-expanded="true" aria-controls="collapsequinze">
                        <strong>Comparativo mensal de produto adquiridos por município</strong>
                        <br>
                        <span>
                          Compara quantidades e valores das compras de um determinado produto em relação aos restaurantes de um Município específico.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsequinze" @if(session('error_comparativomensalprodutomunicipio')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comparativomensalprodutomunicipio')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="produto_id" class="form-control produto_id" required>
                              <option value="" selected disabled>Produto...</option>
                              @foreach($produtos  as $produto)
                                <option value="{{$produto->id}}"> {{$produto->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="medida_id" class="form-control medida_id" required>
                              <option value="" selected disabled disabled>Medida...</option>
                            </select>

                            &nbsp;&nbsp;&nbsp;

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
                          @if(session('error_comparativomensalprodutomunicipio'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalprodutomunicipio')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>



                {{-- Comparativo mensal produtos por regional - inclui todos os municípios da regional --}}
                <div class="card">
                  <div class="card-header" id="headingdezesseis">
                    <h2 class="mb-0" id="anchor-dezesseis">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedezesseis" aria-expanded="true" aria-controls="collapsedezesseis">
                        <strong>Comparativo mensal de produto adquiridos na região</strong>
                        <br>
                        <span>
                          Compara quantidades e valores das compras de um determinado produto em relação aos municípios de uma Regional específica.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsedezesseis" @if(session('error_comparativomensalprodutoregional')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comparativomensalprodutoregional')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="produto_id" class="form-control produto_id" required>
                              <option value="" selected disabled>Produto...</option>
                              @foreach($produtos  as $produto)
                                <option value="{{$produto->id}}"> {{$produto->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="medida_id" class="form-control medida_id" required>
                              <option value="" selected disabled disabled>Medida...</option>
                            </select>

                            &nbsp;&nbsp;&nbsp;

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
                          @if(session('error_comparativomensalprodutoregional'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalprodutoregional')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>



                {{-- Comparativo mensal GERAL de produtos - inclui todos as regionais --}}
                <div class="card">
                  <div class="card-header" id="headingdezessete">
                    <h2 class="mb-0" id="anchor-dezessete">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedezessete" aria-expanded="true" aria-controls="collapsedezessete">
                        <strong>Comparativo mensal GERAL de produto adquiridos</strong>
                        <br>
                        <span>
                          Compara quantidades e valores das compras de um determinado produto em relação a todas as regionais.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsedezessete" @if(session('error_comparativomensalgeralproduto')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comparativomensalgeralproduto')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="produto_id" id="produto_id" class="form-control  produto_id" required>
                              <option value="" selected disabled>Produto...</option>
                              @foreach($produtos  as $produto)
                                <option value="{{$produto->id}}"> {{$produto->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="medida_id" class="form-control medida_id" required>
                              <option value="" selected disabled disabled>Medida...</option>
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
                          @if(session('error_comparativomensalgeralproduto'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalgeralproduto')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>

                
                {{-- Comparativo mensal categorias por município - inclui todos os restaurante do município --}}
                <div class="card">
                  <div class="card-header" id="headingdezoito">
                    <h2 class="mb-0" id="anchor-dezoito">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedezoito" aria-expanded="true" aria-controls="collapsedezoito">
                        <strong>Comparativo mensal de categorias adquiridos por município</strong>
                        <br>
                        <span>
                          Compara quantidades e valores das compras de uma determinada categoria em relação aos restaurantes de um Município específico.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsedezoito" @if(session('error_comparativomensalcategoriamunicipio')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comparativomensalcategoriamunicipio')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="categoria_id" class="form-control categoria_id" required>
                              <option value="" selected disabled>Categoria...</option>
                              @foreach($categorias  as $categoria)
                                <option value="{{$categoria->id}}"> {{$categoria->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="medida_id" class="form-control medida_id" required>
                              <option value="" selected disabled disabled>Medida...</option>
                            </select>

                            &nbsp;&nbsp;&nbsp;

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
                          @if(session('error_comparativomensalcategoriamunicipio'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalcategoriamunicipio')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>   
                

                {{-- Comparativo mensal categorias por regional - inclui todos os municípios da regional --}}
                <div class="card">
                  <div class="card-header" id="headingdezenove">
                    <h2 class="mb-0" id="anchor-dezenove">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedezenove" aria-expanded="true" aria-controls="collapsedezenove">
                        <strong>Comparativo mensal de categoria adquirida na região</strong>
                        <br>
                        <span>
                          Compara quantidades e valores das compras de uma determinada categoria em relação aos municípios de uma Regional específica.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsedezenove" @if(session('error_comparativomensalcategoriaregional')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comparativomensalcategoriaregional')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="categoria_id" class="form-control categoria_id" required>
                              <option value="" selected disabled>Categoria...</option>
                              @foreach($categorias  as $categoria)
                                <option value="{{$categoria->id}}"> {{$categoria->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="medida_id" class="form-control medida_id" required>
                              <option value="" selected disabled disabled>Medida...</option>
                            </select>

                            &nbsp;&nbsp;&nbsp;

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
                          @if(session('error_comparativomensalcategoriaregional'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalcategoriaregional')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>
                

                {{-- Comparativo mensal GERAL de categorias - inclui todos as regionais --}}
                <div class="card">
                  <div class="card-header" id="headingvinte">
                    <h2 class="mb-0" id="anchor-vinte">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsevinte" aria-expanded="true" aria-controls="collapsevinte">
                        <strong>Comparativo mensal GERAL de categorias adquiridas</strong>
                        <br>
                        <span>
                          Compara quantidades e valores das compras de uma determinada categoria em relação a todas as regionais.
                        </span>
                      </button>
                    </h2>
                  </div>

                  <div id="collapsevinte" @if(session('error_comparativomensalgeralcategoria')) class="collapse show" @else class="collapse"  @endif aria-labelledby="headingtres" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.comparativomensalgeralcategoria')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="categoria_id" id="categoria_id" class="form-control  categoria_id" required>
                              <option value="" selected disabled>Categoria...</option>
                              @foreach($categorias  as $categoria)
                                <option value="{{$categoria->id}}"> {{$categoria->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="medida_id" class="form-control medida_id" required>
                              <option value="" selected disabled disabled>Medida...</option>
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
                          @if(session('error_comparativomensalgeralcategoria'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalgeralcategoria')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>                
      

                {{-- --}}
                {{-- NOVA CONSULTA AQUI --}}
                {{-- --}}
            </div>
        </div>
   </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
          //Recuperação dinâmica das unidades de medidas do produto a ser consultado
          $('.produto_id').on('change', function() {

            var produto_id = this.value;
            
            //selectmedidaid recebe o select (medida_id) mais próximo do elemento select (produto_id) selecionado no momento.
            var selectmedidaid = $(this).parents(".form-group").find(".medida_id");
            
            $(this).parents(".form-group").find(".medida_id").html('');

            $.ajax({
              url:"{{route('admin.registroconsultacompra.ajaxgetmedidaproduto')}}",
              type: "GET",
              data: {
                produto_id: produto_id
              },

              dataType : 'json',
              success: function(result){
                $(selectmedidaid).html('<option value="" disabled>Medida...</option>');
                $.each(result.medidas,function(key,value){
                  $(selectmedidaid).append('<option value="'+value.medida_id+'">'+value.medida_simbolo+'</option>');
                });
              },
              error: function(result){
                alert("Error ao retornar dados!");
              }
            });
          });


          //Recuperação dinâmica das unidades de medidas da categoria a ser consultada
          $('.categoria_id').on('change', function() {

            var categoria_id = this.value;

            //selectmedidaid recebe o select (medida_id) mais próximo do elemento select (categoria_id) selecionada no momento.
            var selectmedidaid = $(this).parents(".form-group").find(".medida_id");

            $(this).parents(".form-group").find(".medida_id").html('');

            $.ajax({
              url:"{{route('admin.registroconsultacompra.ajaxgetmedidacategoria')}}",
              type: "GET",
              data: {
                categoria_id: categoria_id
              },

              dataType : 'json',
              success: function(result){
                $(selectmedidaid).html('<option value="" disabled>Medida...</option>');
                $.each(result.medidas,function(key,value){
                  $(selectmedidaid).append('<option value="'+value.medida_id+'">'+value.medida_simbolo+'</option>');
                });
              },
              error: function(result){
                alert("Error ao retornar dados!");
              }
            });
          });
        });


        


        

        /* SCRIPT ORIGINAL UTILIZADO PARA UM ÚNICO SELECT PRODUTO_ID E MEDIDA_ID .
        Deverá haver os elementos select's com os respecitos id's: 
        <select name="produto_id" id="produto_id" class="form-control" required>
        <select name="medida_id" id="medida_id" class="form-control" required>
        
        $(document).ready(function() {
          //Recuperação dinâmica das unidades de medidas do produto a ser consultado
          $('#produto_id').on('change', function() {

            var produto_id = this.value;

            $("#medida_id").html('');

            $.ajax({
              url:"{{route('admin.registroconsultacompra.ajaxgetmedidaproduto')}}",
              type: "GET",
              data: {
                produto_id: produto_id
              },

              dataType : 'json',
              success: function(result){
                $('#medida_id').html('<option value="" disabled>Medida...</option>');
                $.each(result.medidas,function(key,value){
                  //console.log(value.medida_id);
                  $("#medida_id").append('<option value="'+value.medida_id+'">'+value.medida_simbolo+'</option>');
                });
              },
              error: function(result){
                alert("Error ao retornar dados!");
              }
            });
          });
        });
        */

        // var af_hidden = $(this).siblings("#af_hidden").val('sim');
        // var preco = $(this).parents(".linhaDados").find(".precototal").val();
        // $(this).parents(".form-group").find(".medida_id").html('').css("background-color", "yellow")
        // Formas de capturar o texto de um select
        // nomeproduto =  $("#meselect option:selected").text();
        // nomeproduto = $(this).find('option:selected').text();
        // nomeproduto = $(this).children("option:selected").text();
        // nomeproduto = $("option:selected", this).text();
    </script>
@endsection

