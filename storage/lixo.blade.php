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
