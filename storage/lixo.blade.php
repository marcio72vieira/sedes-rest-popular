                {{-- Mapa mensal categoria geral - inclui todas as regionais --}}
                <div class="card">
                  <div class="card-header" id="headingquatorze">
                    <h2 class="mb-0" id="anchor-quatorze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsequatorze" aria-expanded="true" aria-controls="collapsequatorze">
                        <strong>Mapa mensal GERAL de produtos adquiridos por categoria em unidade:</strong>
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

               