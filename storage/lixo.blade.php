                {{-- Mapa mensal categoria municipio --}}
                <div class="card">
                  <div class="card-header" id="headingdoze">
                    <h2 class="mb-0" id="anchor-doze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsedoze" aria-expanded="true" aria-controls="collapsedoze">
                        <strong>Mapa de produtos adquiridos por categorias em unidade no municipio:</strong>
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
                              <option value="" selected disabled>Restaurante...</option>
                              @foreach($municipios  as $municipio)
                                <option value="{{$municipio->id}}"> {{$municipio->identificacao}} </option>
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
               