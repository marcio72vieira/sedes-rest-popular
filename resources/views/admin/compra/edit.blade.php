@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Restaurante / Compras / Editar</h5>

    <div class="row">



        <div class="col-lg-12 order-lg-1">
            <form method="POST" action="{{route('admin.restaurante.compra.update', [$restaurante->id, $compra->id])}}" autocomplete="off" style="padding: 4px">
                @csrf
                @method('PUT')

                <div class="card shadow mb-4">
                    {{-- campo input para ser gravado juntamente com os demais campos do model Compra --}}
                    <input type="hidden" name="restaurante_id" value="{{ $restaurante->id }}">

                    {{--campos inputs para serem gravados juntamente com os demais campos para a tabela bigtable_data
                        além dos demais dispostos estrategicamente para fazer jus à logica de captura de seus respectivos
                        valores, com a função  'siblings do Jquery'. Obs: estes campos serão comuns para todos as entradas
                        de produtos_id que o usuário escolha, por isso não ha a necessidade de colocá-los como campos do
                        tipo array[] Exemplo: produto_id[]; produto_nome_hidden[] ou medida_id[] ou medida_id_hidden[] etc...
                        pois seus valores serão comuns a todas as entradas de produtos.--}}


                    <input type="hidden" name="restaurante_id_hidden" id="restaurante_id_hidden" value="{{ $restaurante->id }}">
                    <input type="hidden" name="identificacao_hidden" id="identificacao_hidden" value="{{ $restaurante->identificacao }}">

                    <input type="hidden" name="regional_id_hidden" id="regional_id_hidden" value="{{ $restaurante->municipio->regional->id }}">
                    <input type="hidden" name="regional_nome_hidden" id="regional_nome_hidden" value="{{ $restaurante->municipio->regional->nome }}">

                    <input type="hidden" name="municipio_id_hidden" id="municipio_id_hidden" value="{{ $restaurante->municipio->id }}">
                    <input type="hidden" name="municipio_nome_hidden" id="municipio_nome_hidden" value="{{ $restaurante->municipio->nome }}">

                    <input type="hidden" name="bairro_id_hidden" id="bairro_id_hidden" value="{{ $restaurante->bairro->id }}">
                    <input type="hidden" name="bairro_nome_hidden" id="bairro_nome_hidden" value="{{ $restaurante->bairro->nome }}">

                    <input type="hidden" name="empresa_id_hidden" id="empresa_id_hidden" value="{{ $restaurante->empresa->id }}">
                    <input type="hidden" name="razaosocial_hidden" id="razaosocial_hidden" value="{{ $restaurante->empresa->razaosocial }}">
                    <input type="hidden" name="nomefantasia_hidden" id="nomefantasia_hidden" value="{{ $restaurante->empresa->nomefantasia }}">
                    <input type="hidden" name="cnpj_hidden" id="cnpj_hidden" value="{{ $restaurante->empresa->cnpj }}">

                    <input type="hidden" name="nutricionista_id_hidden" id="nutricionista_id_hidden" value="{{ $restaurante->nutricionista->id }}">
                    <input type="hidden" name="nutricionista_nomecompleto_hidden" id="nutricionista_nomecompleto_hidden" value="{{ $restaurante->nutricionista->nomecompleto }}">
                    <input type="hidden" name="nutricionista_cpf_hidden" id="nutricionista_cpf_hidden" value="{{ $restaurante->nutricionista->cpf }}">
                    <input type="hidden" name="nutricionista_crn_hidden" id="nutricionista_crn_hidden" value="{{ $restaurante->nutricionista->crn }}">
                    <input type="hidden" name="nutricionista_empresa_id_hidden" id="nutricionista_empresa_id_hidden" value="{{ $restaurante->nutricionista->empresa->id }}">

                    <input type="hidden" name="user_id_hidden" id="user_id_hidden" value="{{ $restaurante->user->id }}">
                    <input type="hidden" name="user_nomecompleto_hidden" id="user_nomecompleto_hidden" value="{{ $restaurante->user->nomecompleto }}">
                    <input type="hidden" name="user_cpf_hidden" id="user_cpf_hidden" value="{{ $restaurante->user->cpf }}">
                    <input type="hidden" name="user_crn_hidden" id="user_crn_hidden" value="{{ $restaurante->user->crn }}">

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Compras</h5>
                                    <p class="card-text">
                                        <strong>Município:</strong> {{$restaurante->municipio->nome}}<br>
                                        <strong>Restaurante:</strong> {{$restaurante->identificacao }}<br>
                                        <strong>Nutricionista da Empresa:</strong> {{$restaurante->nutricionista->nomecompleto}}<br>
                                        <strong>Nutricionista da Sedes:</strong> {{$restaurante->user->nomecompleto}}<br>
                                    </p>
                                    <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        {{-- semana --}}
                                        <div class="col-lg-3 offset-lg-2">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="semana">Nº Semana<span class="small text-danger">*</span></label>
                                                <select name="semana" id="semana" class="form-control" required>
                                                    <option value="" selected disabled>Escolha ...</option>
                                                    <option value="1" {{old('semana', $compra->semana) == '1' ? 'selected' : ''}}>Um</option>
                                                    <option value="2" {{old('semana', $compra->semana) == '2' ? 'selected' : ''}}>Dois</option>
                                                    <option value="3" {{old('semana', $compra->semana) == '3' ? 'selected' : ''}}>Três</option>
                                                    <option value="4" {{old('semana', $compra->semana) == '4' ? 'selected' : ''}}>Quatro</option>
                                                    <option value="5" {{old('semana', $compra->semana) == '5' ? 'selected' : ''}}>Cinco</option>
                                                </select>
                                                <input type="hidden" name="semana_hidden" id="semana_hidden"  value="">
                                                <input type="hidden" name="semana_nome_hidden" id="semana_nome_hidden"  value="">
                                                @error('semana')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- data_ini --}}
                                        <div class="col-lg-3">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="data_ini">Data Inicial<span class="small text-danger">*</span></label>
                                                <input type="date" id="data_ini" class="form-control" name="data_ini" value="{{old('data_ini', $compra->data_ini)}}" required>
                                                <input type="hidden" name="data_ini_hidden" id="data_ini_hidden"  value="">
                                                @error('data_ini')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- data_fin --}}
                                        <div class="col-lg-3">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="data_fin">Data Final<span class="small text-danger">*</span></label>
                                                <input type="date" id="data_fin" class="form-control" name="data_fin" value="{{old('data_fin', $compra->data_fin)}}" required>
                                                <input type="hidden" name="data_fin_hidden" id="data_fin_hidden"  value="">
                                                @error('data_fin')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- valor --}}
                                        <div class="col-lg-3  offset-lg-2">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="valor">Valor (R$)<span class="small text-danger">*</span></label>
                                                <input type="text" class="form-control text-right" id="valor" name="valor" value="{{old('valor', $compra->valor)}}" readonly>
                                                <input type="hidden" name="valor_hidden" id="valor_hidden"  value="">
                                                @error('valor')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- valoraf --}}
                                        <div class="col-lg-3">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="valoraf">Valor AF (R$)<span class="small text-danger">*</span></label>
                                                <input type="text" class="form-control  text-right" id="valoraf" name="valoraf" value="{{old('valor', $compra->valoraf)}}" readonly>
                                                <input type="hidden" name="valoraf_hidden" id="valoraf_hidden"  value="">
                                                @error('valoraf')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- valortotal --}}
                                        <div class="col-lg-3">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="valortotal">Valor Total (R$)<span class="small text-danger">*</span></label>
                                                <input type="text" class="form-control text-right" id="valortotal" name="valortotal" value="{{old('valor', $compra->valortotal)}}" readonly>
                                                <input type="hidden" name="valortotal_hidden" id="valortotal_hidden"  value="">
                                                @error('valortotal')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">

                        {{--<form action="{{route('admin.restaurante.compra.store', $restaurante->id)}}" method="POST" autocomplete="off">
                            @csrf --}}

                            <div class="pl-lg-4">

                                {{-- Inicio Cabeçalho linha de dados --}}
                                <div class="row linhaCabecalho">
                                    {{-- Produto --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="produto_id"><strong>Produto</strong><span class="small text-danger">*</span></label>
                                        </div>
                                    </div>

                                    {{-- Quantidade --}}
                                    <div class="col-lg-1">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="quant"><strong>Quant.</strong><span class="small text-danger">*</span></label>
                                        </div>
                                    </div>

                                    {{-- Unidade de Medida --}}
                                    <div class="col-lg-1">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="medida_id"><strong>Medida</strong>
                                                <span class="small text-danger">*</span>
                                                <span>
                                                    <a href="" data-toggle="modal" data-target="#exampleModalListaMedidas" class="listaMedidas" title="Lista de medidas adotadas"><i class="fas fa-question-circle"></i></a>
                                                </span>
                                            </label>
                                        </div>
                                    </div>


                                    {{-- Detalhe --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="detalhe"><strong>Detalhe</strong></label>
                                        </div>
                                    </div>


                                    {{-- Preço --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="preco"><strong>Preço</strong><span class="small text-danger">*</span></label>
                                        </div>
                                    </div>

                                    {{-- Agricultura Familiar --}}
                                    <div class="col-lg-1" style="margin-right: -70px">
                                        <div class="form-group focused">
                                            <label for="af"><strong>AF</strong></label>
                                        </div>
                                    </div>

                                    {{-- Valor --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="precototal"><strong>Total</strong><span class="small text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fim Cabeçalho linha de dados --}}

                                {{-- Inicio corpo de dados --}}
                                @foreach ($compra->produtos as $item)
                                    <div id="corpoDados">

                                        <div class="row linhaDados destaque">
                                            {{-- produto_id --}}
                                            <div class="col-lg-2">
                                                <div class="form-group focused">
                                                    <select name="produto_id[]" id="produto_id" class="form-control produto_id" required>
                                                        <option value="" selected disabled>Escolha...</option>
                                                        @foreach($produtos  as $produto)
                                                            <option value="{{$produto->id}}" {{old('produto_id', $item->pivot->produto_id) == $produto->id ? 'selected' : ''}}
                                                                data-idcategoria = "{{$produto->categoria->id}}"
                                                                data-nomecategoria = "{{$produto->categoria->nome}}">{{$produto->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="produto_nome_hidden[]" id="produto_nome_hidden"  value="">
                                                    <input type="hidden" name="categoria_id_hidden[]" id="categoria_id_hidden" value="">
                                                    <input type="hidden" name="categoria_nome_hidden[]" id="categoria_nome_hidden" value="">
                                                    @error('produto_id')
                                                        <small style="color: red">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- quantidade --}}
                                            <div class="col-lg-1">
                                                <div class="form-group focused">
                                                    <input type="text" class="form-control text-right quantidade" id="quantidade" name="quantidade[]" value="{{old('quantidade', $item->pivot->quantidade)}}" required>
                                                    @error('quantidade')
                                                        <small style="color: red">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- medida_id --}}
                                            <div class="col-lg-1">
                                                <div class="form-group focused">
                                                    <select name="medida_id[]" id="medida_id" class="form-control medida_id" required>
                                                        <option value="" selected disabled>Escolha...</option>
                                                        @foreach($medidas  as $medida)
                                                            <option value="{{$medida->id}}" {{old('medida_id', $item->pivot->medida_id) ==$medida->id ? 'selected' : ''}}  data-nomemedida = "{{$medida->nome}}">{{$medida->simbolo}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="medida_nome_hidden[]" id="medida_nome_hidden" value="">
                                                    <input type="hidden" name="medida_simbolo[]" id="medida_simbolo"  value="">
                                                    @error('medida_id')
                                                        <small style="color: red">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                            {{-- detalhe --}}
                                            <div class="col-lg-2">
                                                <div class="form-group focused">
                                                    <input type="text" class="form-control" id="detalhe" name="detalhe[]" value="{{old('detalhe', $item->pivot->detalhe)}}">
                                                    @error('detalhe')
                                                        <small style="color: red">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                            {{-- preco --}}
                                            <div class="col-lg-2">
                                                <div class="form-group focused">
                                                    <input type="text" class="form-control text-right preco" id="preco" name="preco[]" value="{{old('preco', $item->pivot->preco)}}" required>
                                                    @error('preco')
                                                        <small style="color: red">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- af --}}
                                            <div class="col-lg-1" style="margin-right: -70px">
                                                <div class="form-group focused">
                                                    <input type="checkbox" class="af" id="af" name="af[]" value="sim" {{$item->pivot->af == 'sim' ? 'checked' : ''}} style="margin-top: 15px;">
                                                    <input type="hidden" name="af_hidden[]" id="af_hidden" value="{{$item->pivot->af}}">
                                                </div>
                                            </div>

                                            {{-- precototal --}}
                                            <div class="col-lg-2">
                                                <div class="form-group focused">
                                                    <input type="text" class="form-control text-right precototal" id="precototal" name="precototal[]" value="{{old('precototal', $item->pivot->precototal)}}" readonly>
                                                    @error('precototal')
                                                        <small style="color: red">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="pl-lg-1">
                                                    <a class="btn btn-success add-linha" href="#" role="button"><i class="fas fa-plus"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a class="btn btn-danger removelinha" href="#" role="button"><i class="fas fa-minus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Fim corpo de dados --}}

                                <hr>
                                <br><br>
                                <!-- Button -->
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col text-center">
                                            <a class="btn btn-primary" href="{{route('admin.restaurante.compra.index', mrc_encrypt_decrypt('encrypt', $restaurante->id))}}" role="button">Cancelar</a>
                                            <button type="submit" id="sent" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        {{-- </form> --}}

                    </div>

                </div>
            </form>
        </div>

    </div>


</div>

{{-- início modal's --}}
<!-- Modal campos vazios-->
<div class="modal fade modalCamposVazios" id="exampleModalCamposVazios" tabindex="-1" aria-labelledby="exampleModalLabelCamposVazios" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelCamposVazios" style="color: red">CAMPOS VAZIOS!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Para adicionar um novo item, considere preencher todos os campos que sejam obrigatórios.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

<!-- Modal itens duplicados-->
<div class="modal fade modalItensDuplicados" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" style="color: red">ITENS DE PRODUTOS DUPLICADOS!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Cadastre os itens duplicados em outro registro, considerando o mesmo Nº Semana, Data Inicial e Data Final.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Modal lista de medidas adotadas -->
  <div class="modal fade modalListaMedidas" id="exampleModalListaMedidas" tabindex="-1" aria-labelledby="exampleModalLabelListaMedidas" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelListaMedidas">LISTA DE MEDIDAS (Unidades de Medidas)</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
                <thead style="background-color: #f6f6fa;">
                  <tr>
                    <th scope="col">Medida</th>
                    <th scope="col">Símbolo (abreviação)</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($medidas  as $medida)
                        <tr class="destaque">
                            <td>{{$medida->nome}}</td>
                            <td>{{$medida->simbolo}}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
{{-- fim modal--}}


@endsection

@section('scripts')
    <script>

        $(document).ready(function(){

            /***************************/
            /* INICIO REMOVE linhaDados*/
            /***************************/
            //Oculta o primeiro botão com a classe '.removerlinha, pois na compra deverá haver pelo menos um produto cadastrado
            $(".removelinha:first").css("display","none");

            //Remove todas as linhas em que o botão com a classe '.removelinha' for clicado e depois recalcula os valores
            $(document).on('click', '.removelinha', function () {
                $(this).parent().parent().remove();

                calculaTotais();
            });
            /***************************/
            /*  FIM REMOVE linhaDados  */
            /***************************/



            /*********************************************************************************/
            /* INICIO CARREGA OS DADOS PARA PRODUTOS E MEDIDAS LOGO QUE A PÁGINA É CARREGADA  */
            /*********************************************************************************/
            $(".produto_id").each(function() {
                nomeproduto = $("option:selected", this).text();
                $(this).siblings("#produto_nome_hidden").val(nomeproduto);

                idcategoria = $(this).find(':selected').data('idcategoria')
                $(this).siblings("#categoria_id_hidden").val(idcategoria);

                nomecategoria = $(this).find(':selected').data('nomecategoria');
                $(this).siblings("#categoria_nome_hidden").val(nomecategoria);

                semana = $("#semana").val();
                $("#semana_hidden").val(semana);
                semanaescolhida = $("#semana option:selected").text();
                $("#semana_nome_hidden").val(semanaescolhida);

                datainicial = $("#data_ini").val();
                $("#data_ini_hidden").val(datainicial);

                datafinal = $("#data_fin").val();
                $("#data_fin_hidden").val(datafinal);

                valor = $("#valor").val();
                $("#valor_hidden").val(valor);

                valoraf = $("#valoraf").val();
                $("#valoraf_hidden").val(valoraf);

                valortotal = $("#valortotal").val();
                $("#valortotal_hidden").val(valortotal);
            });

            $(".medida_id").each(function() {
                simbolomedida = $("option:selected", this).text();
                $(this).siblings("#medida_simbolo").val(simbolomedida);

                nomemedida = $(this).find(':selected').data('nomemedida');
                $(this).siblings("#medida_nome_hidden").val(nomemedida);
            });
            /*********************************************************************************/
            /* FIM CARREGA OS DADOS DOS PRODUTOS E MEDIDAS LOGO QUE A PÁGINA É CARREGADA  */
            /*********************************************************************************/



            /*******************************************************************/
            /*   CASO O USUÁRIO QUEIRA ALTERAR A SEMANA, DATA_INI OU DATA_FIN  */
            /*******************************************************************/
            // Se o usuário mudar a semana
            $("#semana").change(function() {
                semana = $("#semana").val();
                $("#semana_hidden").val(semana);
                semanaescolhida = $("#semana option:selected").text();
                $("#semana_nome_hidden").val(semanaescolhida);
            });

            $("#data_ini").change(function() {
                datainicial = $("#data_ini").val();
                $("#data_ini_hidden").val(datainicial);
            });

            $("#data_fin").change(function() {
                datafinal = $("#data_fin").val();
                $("#data_fin_hidden").val(datafinal);
            });
            /**********************************************************************/
            /*  FIM CASO O USUÁRIO QUEIRA ALTERAR A SEMANA, DATA_INI OU DATA_FIN  */
            /**********************************************************************/



            /***********************************************/
            /*  INICIO Adiciona linhaDados DINAMICAMENTE   */
            /***********************************************/
            $(document).on('click', '.add-linha', function () {
            //$('form').on('click', '.add-linha', function () {

                var linhaDados =  "<div class='row linhaDados'>";
                        linhaDados += "<div class='col-lg-2'><div class='form-group focused'><select name='produto_id[]' id='produto_id' class='form-control produto_id' required><option value='' selected disabled>Escolha...</option>@foreach($produtos  as $produto)<option value='{{$produto->id}}' {{old('produto_id') == $produto->id ? 'selected' : ''}}  data-idcategoria = '{{$produto->categoria->id}}' data-nomecategoria = '{{$produto->categoria->nome}}'>{{$produto->nome}}</option>@endforeach</select>  <input type='hidden' name='produto_nome_hidden[]' id='produto_nome_hidden' value=''> <input type='hidden' name='categoria_id_hidden[]' id='categoria_id_hidden' value=''> <input type='hidden' name='categoria_nome_hidden[]' id='categoria_nome_hidden' value=''></div></div>";
                        linhaDados += "<div class='col-lg-1'><div class='form-group focused'><input type='text' class='form-control text-right quantidade' id='quantidade' name='quantidade[]' value='{{old('quantidade')}}' required></div></div>";
                        linhaDados += "<div class='col-lg-1'><div class='form-group focused'><select name='medida_id[]' id='medida_id' class='form-control medida_id' required><option value='' selected disabled>Escolha...</option>@foreach($medidas  as $medida)<option value='{{$medida->id}}' {{old('medida_id') == $medida->id ? 'selected' : ''}} data-nomemedida = '{{$medida->nome}}'>{{$medida->simbolo}}</option>@endforeach</select>  <input type='hidden' name='medida_nome_hidden[]' id='medida_nome_hidden' value=''> <input type='hidden' name='medida_simbolo[]' id='medida_simbolo'  value=''></div></div>";
                        linhaDados += "<div class='col-lg-2'><div class='form-group focused'><input type='text' class='form-control' id='detalhe' name='detalhe[]' value='{{old('detalhe')}}'></div></div>";
                        linhaDados += "<div class='col-lg-2'><div class='form-group focused'><input type='text' class='form-control text-right preco' id='preco' name='preco[]' value='{{old('preco')}}' required></div></div>";
                        linhaDados += "<div class='col-lg-1' style='margin-right: -70px'><div class='form-group focused'><input type='checkbox' class='af' id='af' name='af[]' value='sim' style='margin-top: 15px;'><input type='hidden' name='af_hidden[]' id='af_hidden' value='nao'></div></div>";
                        linhaDados += "<div class='col-lg-2'><div class='form-group focused'><input type='text' class='form-control text-right precototal' id='precototal' name='precototal[]' value='{{old('precototal')}}' readonly></div></div>";
                        linhaDados += "<div class='pl-lg-1'><a class='btn btn-success add-linha' href='#' role='button' style='margin-right: 10px'><i class='fas fa-plus'></i></a>&nbsp;&nbsp;<a class='btn btn-danger removelinha' href='#' role='button'><i class='fas fa-minus'></i></a></div>";
                    linhaDados += "</div>";

                // Recupera os valores dos campos da linha de dados atual.
                var campo_produto    = $(this).parents(".linhaDados").find(".produto_id").val();
                var campo_quantidade = $(this).parents(".linhaDados").find(".quantidade").val();
                var campo_medida     = $(this).parents(".linhaDados").find(".medida_id").val();
                var campo_preco      = $(this).parents(".linhaDados").find(".preco").val();
                var campo_af         = $(this).parents(".linhaDados").find(".af").is(':checked');

                var campo_precototal = $(this).parents(".linhaDados").find(".precototal");

                var totalLinhaDados = $('.linhaDados').length;


                // Se todos os campos obrigatórios foram preechidos, realiza os cálculos e acrescenta uma nova linha.
                if  (campo_produto != null && campo_quantidade != '' && campo_medida != null  && campo_preco != '') {
                    // Acrescenta uma nova linha
                    // $("#corpoDados").append(linhaDados);

                    // Na situação anterior (comentada, utilizada no create), sempre que uma nova linha é adicionada,
                    // esta linha é adicionada logo após a primeira linha independente de qual botão add era clicado.
                    $(".linhaDados").eq(totalLinhaDados - 1).after(linhaDados);

                } else {
                    // Caso possua algum campo obrigatório não preenchido
                    // alert("Preencha todos os campos!");
                    $(".modalCamposVazios").modal("show");
                }


                // Adiciona o texto do produto, categoria, semana inicial e final valores etc... assim que uma nova
                // linha é adicionada e perde o foco do preço
                $(".produto_id").focusout(function(){
                    $(".produto_id").each(function() {

                        nomeproduto = $("option:selected", this).text();
                        $(this).siblings("#produto_nome_hidden").val(nomeproduto)

                        idcategoria = $(this).find(':selected').data('idcategoria')
                        $(this).siblings("#categoria_id_hidden").val(idcategoria);

                        nomecategoria = $(this).find(':selected').data('nomecategoria');
                        $(this).siblings("#categoria_nome_hidden").val(nomecategoria);

                        semana = $("#semana").val();
                        $("#semana_hidden").val(semana);
                        semanaescolhida = $("#semana option:selected").text();
                        $("#semana_nome_hidden").val(semanaescolhida);

                        datainicial = $("#data_ini").val();
                        $("#data_ini_hidden").val(datainicial);

                        datafinal = $("#data_fin").val();
                        $("#data_fin_hidden").val(datafinal);

                        valor = $("#valor").val();
                        $("#valor_hidden").val(valor);

                        valoraf = $("#valoraf").val();
                        $("#valoraf_hidden").val(valoraf);

                        valortotal = $("#valortotal").val();
                        $("#valortotal_hidden").val(valortotal);

                    });
                });

                $(".medida_id").change(function(){
                    $(".medida_id").each(function() {
                        simbolomedida = $("option:selected", this).text();
                        $(this).siblings("#medida_simbolo").val(simbolomedida);

                        nomemedida = $(this).find(':selected').data('nomemedida');
                        $(this).siblings("#medida_nome_hidden").val(nomemedida);
                    });
                });
                /// FIM Adicionando o texto do produto_id, da medida_id e o simbolo da medida dos campos selects


                // Funciona para as linhas criadas dinamicamente. Quando quantidade  perde o foco
                // Alterar quantidade
                $(".quantidade").each(function() {
                    $(this).focusout(function(){

                        // Substitui vírgula por ponto e reetira qualquer caracter que não seja digito ou ponto
                        $(this).val(this.value.replace(',','.'));
                        $(this).val(this.value.replace(/[^0-9.]+/g, ""));

                        //Obtém o conteúdo da caixa quantidade
                        quantidade =  $(this).val();

                        //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                        if(!$.isNumeric(quantidade)) {
                            quantidade = 0;
                        }

                        //Obtém o conteúdo da caixa preco
                        preco = $(this).parents(".linhaDados").find(".preco").val();

                        //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                        if(!$.isNumeric(preco)) {
                            preco = 0.00;
                        }

                        //Multiplica quantidade vezes o preco
                        quantXpreco = (quantidade * preco).toFixed(2);

                        //Obtém o conteúdo da caixa precototal
                        precototal = $(this).parents(".linhaDados").find(".precototal");

                        //Atribui o valor do cálculo quantXpreco a caixa precototal
                        precototal.val(quantXpreco);


                        calculaTotais();

                    });
                });


                // Funciona para as linhas criadas dinamicamente. Quando preço perde o foco
                // Alterar preço
                $(".preco").each(function() {
                    $(this).focusout(function(){

                        // Substitui vírgula por ponto e reetira qualquer caracter que não seja digito ou ponto
                        $(this).val(this.value.replace(',','.'));
                        $(this).val(this.value.replace(/[^0-9.]+/g, ""));

                        //Obtém o conteúdo da caixa quantidade
                        quantidade =  $(this).parents(".linhaDados").find(".quantidade").val();

                        //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                        if(!$.isNumeric(quantidade)) {
                            quantidade = 0;
                        }

                        //Obtém o conteúdo da caixa preco
                        preco = $(this).val();

                        //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                        if(!$.isNumeric(preco)) {
                            preco = 0.00;
                        }

                        //Multiplica quantidade vezes o preco
                        quantXpreco = (quantidade * preco).toFixed(2);

                        //Obtém o conteúdo da caixa precototal
                        precototal = $(this).parents(".linhaDados").find(".precototal");

                        //Atribui o valor do cálculo quantXpreco a caixa precototal
                        precototal.val(quantXpreco);


                        calculaTotais();

                    });
                });




                //Funciona para as linhas criadas dinamicamente
                //Checar af (Agricultura Familiar)
                $('.af').change(function(){

                    var valCompraAF = 0;
                    var valCompraNormal = 0;
                    var valGeral = 0;

                    $(".af").each(function() {

                        if($(this).is(':checked')){

                            var preco = $(this).parents(".linhaDados").find(".precototal").val();
                            // var val = parseFloat(preco);
                            var val = (isNaN(preco) || (preco == '')) ? parseFloat(0.00) : parseFloat(preco);
                            valCompraAF += val;

                            var af_hidden = $(this).siblings("#af_hidden").val('sim');

                        }   else {

                            var preco = $(this).parents(".linhaDados").find(".precototal").val();
                            // val = parseFloat(preco);
                            var val = (isNaN(preco) || (preco == '')) ? parseFloat(0.00) : parseFloat(preco);
                            valCompraNormal += val;

                            var af_hidden = $(this).siblings("#af_hidden").val('nao');

                        }
                    });


                    valGeral = (valCompraAF + valCompraNormal);

                    $("#valor").val(valCompraNormal.toFixed(2));
                    $("#valoraf").val(valCompraAF.toFixed(2));
                    $("#valortotal").val(valGeral.toFixed(2));

                });




                // Remoção de linha
                $('.removelinha').each(function() {
                    $(this).click(function() {

                        $(this).parent().parent().remove();

                        calculaTotais();

                    });
                });

            });
            /**************************/
            /* FIM Adiciona linhaDados*/
            /**************************/






            /*******************************************/
            /* INICIO Só Funciona para a primeira linha /
            /*******************************************/
            $(".quantidade").focusout(function() {

                // Substitui vírgula por ponto e reetira qualquer caracter que não seja digito ou ponto
                $(this).val(this.value.replace(',','.'));
                $(this).val(this.value.replace(/[^0-9.]+/g, ""));

                //Obtém o conteúdo da caixa quantidade
                quantidade =  $(this).val();

                //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                if(!$.isNumeric(quantidade)) {
                    quantidade = 0;
                }

                //Obtém o conteúdo da caixa preco
                preco = $(this).parents(".linhaDados").find(".preco").val();

                //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                if(!$.isNumeric(preco)) {
                    preco = 0.00;
                }

                //Multiplica quantidade vezes o preco
                quantXpreco = (quantidade * preco).toFixed(2);

                //Obtém o conteúdo da caixa precototal
                precototal = $(this).parents(".linhaDados").find(".precototal");

                //Atribui o valor do cálculo quantXpreco a caixa precototal
                precototal.val(quantXpreco);


                calculaTotais();

            });


            $(".preco").focusout(function() {

                // Substitui vírgula por ponto e reetira qualquer caracter que não seja digito ou ponto
                $(this).val(this.value.replace(',','.'));
                $(this).val(this.value.replace(/[^0-9.]+/g, ""));

                //Obtém o conteúdo da caixa quantidade
                quantidade =  $(this).parents(".linhaDados").find(".quantidade").val();

                //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                if(!$.isNumeric(quantidade)) {
                    quantidade = 0;
                }

                //Obtém o conteúdo da caixa preco
                preco = $(this).val();

                //Verifica se o conteúdo não é um número. Se não for um número, atribui zero a caixa ao seu valor
                if(!$.isNumeric(preco)) {
                    preco = 0.00;
                }

                //Multiplica quantidade vezes o preco
                quantXpreco = (quantidade * preco).toFixed(2);

                //Obtém o conteúdo da caixa precototal
                precototal = $(this).parents(".linhaDados").find(".precototal");

                //Atribui o valor do cálculo quantXpreco a caixa precototal
                precototal.val(quantXpreco);


                calculaTotais();

            });


            $('.af').change(function(){

                var valCompraAF = 0;
                var valCompraNormal = 0;
                var valGeral = 0;

                $(".af").each(function() {

                    if($(this).is(':checked')){

                        var preco = $(this).parents(".linhaDados").find(".precototal").val();
                        // var val = parseFloat(preco);
                        var val = (isNaN(preco) || (preco == '')) ? parseFloat(0.00) : parseFloat(preco);
                        valCompraAF += val;

                        var af_hidden = $(this).siblings("#af_hidden").val('sim');

                    }   else {

                        var preco = $(this).parents(".linhaDados").find(".precototal").val();
                        // val = parseFloat(preco);
                        var val = (isNaN(preco) || (preco == '')) ? parseFloat(0.00) : parseFloat(preco);
                        valCompraNormal += val;

                        var af_hidden = $(this).siblings("#af_hidden").val('nao');

                    }
                });


                valGeral = (valCompraAF + valCompraNormal);

                $("#valor").val(valCompraNormal.toFixed(2));
                $("#valoraf").val(valCompraAF.toFixed(2));
                $("#valortotal").val(valGeral.toFixed(2));

            });







            // Executa a função normal como no create se caso algum produto ou medida forem alterados ou adicionados
            $(".produto_id").focusout(function(){
                $(".produto_id").each(function() {
                    nomeproduto = $("option:selected", this).text();
                    $(this).siblings("#produto_nome_hidden").val(nomeproduto);

                    idcategoria = $(this).find(':selected').data('idcategoria')
                    $(this).siblings("#categoria_id_hidden").val(idcategoria);

                    nomecategoria = $(this).find(':selected').data('nomecategoria');
                    $(this).siblings("#categoria_nome_hidden").val(nomecategoria);

                    semana = $("#semana").val();
                    $("#semana_hidden").val(semana);
                    semanaescolhida = $("#semana option:selected").text();
                    $("#semana_nome_hidden").val(semanaescolhida);

                    datainicial = $("#data_ini").val();
                    $("#data_ini_hidden").val(datainicial);

                    datafinal = $("#data_fin").val();
                    $("#data_fin_hidden").val(datafinal);

                    valor = $("#valor").val();
                    $("#valor_hidden").val(valor);

                    valoraf = $("#valoraf").val();
                    $("#valoraf_hidden").val(valoraf);

                    valortotal = $("#valortotal").val();
                    $("#valortotal_hidden").val(valortotal);

                });
            });

            // Carrega os valores assim que a página é carregada para cada uma das medidas_id
            $(".medida_id").change(function(){
                $(".medida_id").each(function() {
                    simbolomedida = $("option:selected", this).text();
                    $(this).siblings("#medida_simbolo").val(simbolomedida);

                    nomemedida = $(this).find(':selected').data('nomemedida');
                    $(this).siblings("#medida_nome_hidden").val(nomemedida);
                });
            });
            /// Fim Adicionando o nome do produto no campo select

            /****************************************/
            /* FIM Só Funciona para a primeira linha /
            /****************************************/


            //Calcula os totais
            var calculaTotais = function() {

                var valCompraAF = 0;
                var valCompraNormal = 0;
                var valGeral = 0;

                $(".af").each(function() {

                    if($(this).is(':checked')){

                        var preco = $(this).parents(".linhaDados").find(".precototal").val();
                        // var val = parseFloat(preco);
                        var val = (isNaN(preco) || (preco == '')) ? parseFloat(0.00) : parseFloat(preco);
                        valCompraAF += val;

                        var af_hidden = $(this).siblings("#af_hidden").val('sim');

                    }   else {

                        var preco = $(this).parents(".linhaDados").find(".precototal").val();
                        // val = parseFloat(preco);
                        var val = (isNaN(preco) || (preco == '')) ? parseFloat(0.00) : parseFloat(preco);
                        valCompraNormal += val;

                        var af_hidden = $(this).siblings("#af_hidden").val('nao');

                    }
                });


                valGeral = (valCompraAF + valCompraNormal);

                $("#valor").val(valCompraNormal.toFixed(2));
                $("#valoraf").val(valCompraAF.toFixed(2));
                $("#valortotal").val(valGeral.toFixed(2));
            }


            // Verifica se há produtos duplicados ao tentar salvar os dados
            $("#sent").click(function(event) {
                // Cria um array inicialmente vazio, de produtos selecionados
                var produtosSelecionados = [];

                // Recupera todos os valores dos produtos selecionaod e adiciona ao array criado
                $(".produto_id").each(function(){
                    var produtoCorrente = $(this).parents(".linhaDados").find(".produto_id").val();
                    produtosSelecionados.push(produtoCorrente);
                });

                // Cria um objeto conjunto (Set)[Obs: um conjunto não permite elementos duplicados] a partir do array "produtosSelecionados"
                var conjuntoProdutos =  new Set(produtosSelecionados);

                // Compara se a quantidade de elementos do objeto (através do size) é diferente da quantidade de elementos do array (através do lenght)
                // e atribui o valor(booleano) à variável existeItensDuplicados. Se o valor for 'false' é porque os tamanhos são diferentes, logo há itens duplicados.
                var existeItensDuplicados = conjuntoProdutos.size !== produtosSelecionados.length;

                if(existeItensDuplicados){
                    $(".modalItensDuplicados").modal("show");
                    event.preventDefault();
                }
            });


            // function temProdutoDuplicado(arr) {
            //     alert(arr.length);
            //     // Cria um conjunto (Um conjunto não possui elementos repetidos) a partir de um array
            //     const produtos =  new Set(arr);
            //     return produtos.size !== arr.length;
            //     //var conjunto  = new Set(arr).size !== arr.length;
            //     //alert(conjunto);
            // }





            //Comentários diversos
            //Obs: campo_precototal.val(calculo).toFixed(2) forma errada, dá error!
            //Obs: campo_precototal.val(calculo.toFixed(2)) maneira correta!
            //.css({"color": "red", "border": "1px solid red"});
            //mask
            //$('.preco').mask('#.###,##', {reverse : true});

            //remover uma classe específica
            //$("#container").removeClass("color");
            //aplicar um estilo em um elemento específico
            //$("p:eq(1)").css("background-color","yellow");
            //Adiciona um elemento após um elemento específico
            //$('#list li:eq(1)').after('<li>Position 3</li>');

        });

    </script>
@endsection

