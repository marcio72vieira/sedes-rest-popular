                {{-- Comparativo mensal produtos por município - inclui todos os restaurante do município --}}
                <div class="card">
                  <div class="card-header" id="headingquinze">
                    <h2 class="mb-0" id="anchor-quinze">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapsequinze" aria-expanded="true" aria-controls="collapsequinze">
                        <strong>Comparativo mensal de produto adquiridos por município:</strong>
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
                            <select name="produto_id" id="produto_id" class="form-control" required>
                              <option value="" selected disabled>Produto...</option>
                              @foreach($produtos  as $produto)
                                <option value="{{$produto->id}}"> {{$produto->nome}} </option>
                              @endforeach
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

               