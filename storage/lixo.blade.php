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
                            <select name="produto_id" id="produto_id" class="form-control" required>
                              <option value="" selected disabled>Produto...</option>
                              @foreach($produtos  as $produto)
                                <option value="{{$produto->id}}"> {{$produto->nome}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;
                            <select name="regional_id" id="regional_id" class="form-control" required>
                              <option value="" selected disabled>Município...</option>
                              @foreach($regionals  as $regional)
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
                          @if(session('error_comparativomensalgeralproduto'))
                              <p class="alert-danger alert-dismissible fade show" role="alert" style="margin-left: 30px; margin-bottom: 5px; padding: 5px">
                                  <strong>Atenção! </strong> {{session('error_comparativomensalgeralproduto')}}
                              </p>
                          @endif
                        </form>
                    </div>
                  </div>
                </div>

               