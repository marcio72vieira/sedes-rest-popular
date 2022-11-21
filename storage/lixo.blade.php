                {{-- Mapa mensal produto restaurante --}}
                <div class="card">
                    <div class="card-header" id="headingsete">
                      <h2 class="mb-0">
                        <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsesete" aria-expanded="true" aria-controls="collapsesete">
                          <strong>Mapa de produtos adquiridos por unidade por restaurante:</strong>
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
                                  <option value="{{$restaurante->id}}"> {{$restaurante->nome}} </option>
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