@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Restaurante / Compras / Cadastrar</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">


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
                                            <option value="1" {{old('semana') == '1' ? 'selected' : ''}}>Um</option>
                                            <option value="2" {{old('semana') == '2' ? 'selected' : ''}}>Dois</option>
                                            <option value="3" {{old('semana') == '3' ? 'selected' : ''}}>Três</option>
                                            <option value="4" {{old('semana') == '4' ? 'selected' : ''}}>Quatro</option>
                                            <option value="5" {{old('semana') == '5' ? 'selected' : ''}}>Cinco</option>
                                        </select>
                                        @error('semana')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- data_ini --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="data_ini">Data Inicial<span class="small text-danger">*</span></label>
                                        <input type="date" id="data_ini" class="form-control" name="data_ini" value="{{old('data_ini')}}" required>
                                        @error('data_ini')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- data_fin --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="data_fin">Data Final<span class="small text-danger">*</span></label>
                                        <input type="date" id="data_fin" class="form-control" name="data_fin" value="{{old('data_fin')}}" required>
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
                                        <input type="text" class="form-control" id="valor" name="valor" value="{{old('valor')}}" required>
                                        @error('valor')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valoraf --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valoraf">Valor AF (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valoraf" name="valoraf" value="{{old('valoraf')}}" required>
                                        @error('valoraf')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valortotal --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valortotal">Valor Total (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valortotal" name="valortotal" value="{{old('valortotal')}}">
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

                    <form action="{{route('admin.restaurante.compra.store', $restaurante->id)}}" method="POST" autocomplete="off">
                        @csrf

                        <div class="pl-lg-4">

                            {{-- Inicio Cabeçalho linha de dados --}}
                            <div class="row">
                                {{-- Produto --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="produto_id">Produto<span class="small text-danger">*</span></label>
                                    </div>
                                </div>

                                {{-- Quantidade --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="quant">Quant.<span class="small text-danger">*</span></label>
                                    </div>
                                </div>

                                {{-- Unidade de Medida --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="medida_id">Medida<span class="small text-danger">*</span></label>
                                    </div>
                                </div>


                                {{-- Detalhe --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="detalhe">Detalhe<span class="small text-danger">*</span></label>
                                    </div>
                                </div>


                                 {{-- Preço --}}
                                 <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valorunit">Preço<span class="small text-danger">*</span></label>
                                    </div>
                                </div>

                                {{-- Agricultura Familiar --}}
                                <div class="col-lg-1" style="margin-right: -70px">
                                    <div class="form-group focused">
                                        <label for="af">AF</label>
                                    </div>
                                </div>

                                {{-- Valor --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valorparcial">Total<span class="small text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            {{-- Fim Cabeçalho linha de dados --}}

                            <div class="row linhaAtual">
                                {{-- produto_id --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="produto_id">Produto<span class="small text-danger">*</span></label>
                                        <select name="produto_id" id="produto_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($produtos  as $produto)
                                                <option value="{{$produto->id}}" {{old('produto_id') == $produto->id ? 'selected' : ''}}>{{$produto->nome}}</option>
                                            @endforeach
                                        </select>
                                        @error('produto_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- quant --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="quant">Quant.<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control valquant" id="quant" name="quant" value="{{old('quant')}}" required>
                                        @error('quant')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- medida_id --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="medida_id">Medida<span class="small text-danger">*</span></label>
                                        <select name="medida_id" id="medida_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($medidas  as $medida)
                                                <option value="{{$medida->id}}" {{old('medida_id') == $medida->id ? 'selected' : ''}}>{{$medida->simbolo}}</option>
                                            @endforeach
                                        </select>
                                        @error('medida_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                                {{-- detalhe --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="detalhe">Detalhe<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="detalhe" name="detalhe" value="{{old('detalhe')}}" required>
                                        @error('detalhe')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                                 {{-- valorunit --}}
                                 <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valorunit">Valor<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control valunit" id="valorunit" name="valorunit" value="{{old('valorunit')}}" required>
                                        @error('valorunit')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- af --}}
                                <div class="col-lg-1" style="margin-right: -70px">
                                    <div class="form-group focused">
                                        <label for="af">AF </label>
                                        <br>
                                        <input type="checkbox" id="af" name="af" value="{{old('af')}}" style="margin-top: 15px;">
                                    </div>
                                </div>

                                {{-- valorparcial --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valorparcial">Valor Total<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control valparc" id="valorparcial" name="valorparcial" value="{{old('valorparcial')}}" required>
                                        @error('valorparcial')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                                <div class="pl-lg-1" style="margin-top: 30px">
                                        <a class="btn btn-success" href="#" role="button"><i class="fas fa-plus"></i></a>
                                        &nbsp;&nbsp;
                                        <a class="btn btn-danger" href="#" role="button"><i class="fas fa-minus"></i></a>
                                </div>
                            </div>


                            {{-- inicio linha fake --}}
                            <div class="row linhaAtual">
                                {{-- produto_id --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <select name="produto_id" id="produto_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($produtos  as $produto)
                                                <option value="{{$produto->id}}" {{old('produto_id') == $produto->id ? 'selected' : ''}}>{{$produto->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- quant --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <input type="text" class="form-control valquant" id="quant" name="quant" value="{{old('quant')}}" required>
                                    </div>
                                </div>

                                {{-- medida_id --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <select name="medida_id" id="medida_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($medidas  as $medida)
                                                <option value="{{$medida->id}}" {{old('medida_id') == $medida->id ? 'selected' : ''}}>{{$medida->simbolo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                {{-- detalhe --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <input type="text" class="form-control" id="detalhe" name="detalhe" value="{{old('detalhe')}}" required>
                                    </div>
                                </div>


                                 {{-- valorunit --}}
                                 <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <input type="text" class="form-control valunit" id="valorunit" name="valorunit" value="{{old('valorunit')}}" required>
                                    </div>
                                </div>

                                {{-- af --}}
                                <div class="col-lg-1" style="margin-right: -70px">
                                    <div class="form-group focused">
                                        <input type="checkbox" id="af" name="af" value="{{old('af')}}" style="margin-top: 15px;">
                                    </div>
                                </div>

                                {{-- valorparcial --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <input type="text" class="form-control valparc" id="valorparcial" name="valorparcial" value="{{old('valorparcial')}}" required>
                                    </div>
                                </div>


                                <div class="pl-lg-1">
                                        <a class="btn btn-success" href="#" role="button"><i class="fas fa-plus"></i></a>
                                        &nbsp;&nbsp;
                                        <a class="btn btn-danger" href="#" role="button"><i class="fas fa-minus"></i></a>
                                </div>
                            </div>
                            {{-- fim linha fake --}}


                            <hr>
                            <br><br>
                            <!-- Button -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-center">
                                        <a class="btn btn-primary" href="{{route('admin.restaurante.compra.index', $restaurante->id)}}" role="button">Cancelar</a>
                                        <button type="submit" id="sent" class="btn btn-primary" style="width: 95px;"> Salvar </button>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            //Sites ref:
                // https://stackoverflow.com/questions/59133114/calculate-sum-from-number-type-input-fields-by-javascript?utm_source=pocket_mylist
                // https://stackoverflow.com/questions/33581989/pass-current-text-as-parameter-to-jquery-function
                // https://www.w3schools.com/jquery/jquery_traversing_siblings.asp
                // https://stackoverflow.com/questions/41160023/jquery-calculate-field-from-two-other-fields
                // https://stackoverflow.com/questions/2569699/how-can-one-select-specific-sibling-of-a-context-node-using-jquery
                // https://codeburst.io/how-to-position-html-elements-side-by-side-with-css-e1fae72ddcc
                // https://www.youtube.com/watch?v=gUqKf-U6Dx0
                // https://www.youtube.com/watch?v=7efeIJ7oFTc



            //valquant
            //valunit ou preço
            //valparc valor valorparcial valortotal

            //Interage através de cada texboxex cuja classe tem o nome de valunit
            $(".valunit").each(function() {


                $(this).focusout(function(){

                    precoUnitario = $(this).val();
                    //quantatual = $(this).parents(".linhaAtual").find(".valquant").css({"color": "red", "border": "1px solid red"});
                    quantatual = $(this).parents(".linhaAtual").find(".valquant").val();

                    valorParcial = $(this).parents(".linhaAtual").find(".valparc");

                    calculateMul(precoUnitario, quantatual, valorParcial);

                });
            });
        });

        function calculateMul(preco, quant, vlrparc) {

            //alert(preco * quant);

            $(vlrparc).val(preco * quant);


            /*
            //var sum = 0;
            var mul = 1;
            //iterate through each textboxes and add the values
            $(".valunit").each(function() {
                quantidade = $('.quant').val();
                alert(quantidade);

                //add only if the value is number
                if(!isNaN(this.value) && this.value.length!=0) {
                    //sum += parseFloat(this.value);
                    mul = parseFloat(this.value);
                }
            });
            //.toFixed() method will roundoff the final sum to 2 decimal places
            $("#sum").html(sum.toFixed(2));
            */
        }

        //$("div").focusout(function(){
        //  $(this).css("background-color", "#FFFFFF");
        //});
    </script>
@endsection

