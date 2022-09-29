@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Restaurante / Compras / Cadastrar</h5>

    <div class="row">

       

        <div class="col-lg-12 order-lg-1">
            <form action="{{route('admin.restaurante.compra.store', $restaurante->id)}}" method="POST" autocomplete="off" style="padding: 4px">
                @csrf
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
                                                <input type="text" class="form-control text-right" id="valor" name="valor" value="{{old('valor')}}" readonly>
                                                @error('valor')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- valoraf --}}
                                        <div class="col-lg-3">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="valoraf">Valor AF (R$)<span class="small text-danger">*</span></label>
                                                <input type="text" class="form-control  text-right" id="valoraf" name="valoraf" value="{{old('valoraf')}}" readonly>
                                                @error('valoraf')
                                                    <small style="color: red">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- valortotal --}}
                                        <div class="col-lg-3">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="valortotal">Valor Total (R$)<span class="small text-danger">*</span></label>
                                                <input type="text" class="form-control text-right" id="valortotal" name="valortotal" value="{{old('valortotal')}}" readonly>
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
                                            <label class="form-control-label" for="preco">Preço<span class="small text-danger">*</span></label>
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
                                            <label class="form-control-label" for="precototal">Total<span class="small text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fim Cabeçalho linha de dados --}}

                                <div class="row linhaDados">
                                    {{-- produto_id --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
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

                                    {{-- quantidade --}}
                                    <div class="col-lg-1">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right quantidade" id="quantidade" name="quantidade" value="{{old('quantidade')}}" required>
                                            @error('quantidade')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
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
                                            @error('medida_id')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- detalhe --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control" id="detalhe" name="detalhe" value="{{old('detalhe')}}" required>
                                            @error('detalhe')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- preco --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right preco" id="preco" name="preco" value="{{old('preco')}}" required>
                                            @error('preco')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- af --}}
                                    <div class="col-lg-1" style="margin-right: -70px">
                                        <div class="form-group focused">
                                            <input type="checkbox" class="af" id="af" name="af" value="{{old('af')}}" style="margin-top: 15px;">
                                        </div>
                                    </div>

                                    {{-- precototal --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right precototal" id="precototal" name="precototal" value="{{old('precototal')}}" readonly>
                                            @error('precototal')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="pl-lg-1">
                                            <a class="btn btn-success" href="#" role="button"><i class="fas fa-plus"></i></a>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-danger" href="#" role="button"><i class="fas fa-minus"></i></a>
                                    </div>
                                </div>


                                {{-- inicio linha fake 1 --}}
                                <div class="row linhaDados">
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

                                    {{-- quantidade --}}
                                    <div class="col-lg-1">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right quantidade" id="quantidade" name="quantidade" value="{{old('quantidade')}}" required>
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


                                    {{-- preco --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right preco" id="preco" name="preco" value="{{old('preco')}}" required>
                                        </div>
                                    </div>

                                    {{-- af --}}
                                    <div class="col-lg-1" style="margin-right: -70px">
                                        <div class="form-group focused">
                                            <input type="checkbox" class="af" id="af" name="af" value="{{old('af')}}" style="margin-top: 15px;">
                                        </div>
                                    </div>

                                    {{-- precototal --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right precototal" id="precototal" name="precototal" value="{{old('precototal')}}" readonly>
                                        </div>
                                    </div>


                                    <div class="pl-lg-1">
                                            <a class="btn btn-success" href="#" role="button"><i class="fas fa-plus"></i></a>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-danger" href="#" role="button"><i class="fas fa-minus"></i></a>
                                    </div>
                                </div>
                                {{-- fim linha fake 1 --}}


                                {{-- inicio linha fake 2 --}}
                                <div class="row linhaDados">
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

                                    {{-- quantidade --}}
                                    <div class="col-lg-1">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right quantidade" id="quantidade" name="quantidade" value="{{old('quantidade')}}" required>
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


                                    {{-- preco --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right preco" id="preco" name="preco" value="{{old('preco')}}" required>
                                        </div>
                                    </div>

                                    {{-- af --}}
                                    <div class="col-lg-1" style="margin-right: -70px">
                                        <div class="form-group focused">
                                            <input type="checkbox" class="af" id="af" name="af" value="{{old('af')}}" style="margin-top: 15px;">
                                        </div>
                                    </div>

                                    {{-- precototal --}}
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <input type="text" class="form-control text-right precototal" id="precototal" name="precototal" value="{{old('precototal')}}" readonly>
                                        </div>
                                    </div>


                                    <div class="pl-lg-1">
                                            <a class="btn btn-success" href="#" role="button"><i class="fas fa-plus"></i></a>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-danger" href="#" role="button"><i class="fas fa-minus"></i></a>
                                    </div>
                                </div>
                                {{-- fim linha fake 2 --}}


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


                        {{-- </form> --}}

                    </div>

                </div>
            </form>
        </div>
        
    </div>

   
</div>
@endsection

@section('scripts')
    <script>

        $(document).ready(function(){
            //alert("JQuery carregado!");
            //.css({"color": "red", "border": "1px solid red"});
            //$(this).keyup(function(){

            //mask
            //$('.preco').mask('#.###,##', {reverse : true});

            $(".preco").each(function() {
                $(this).focusout(function(){
                    
                    valpreco = $(this).val();
                    
                    valquantidade = $(this).parents(".linhaDados").find(".quantidade").val();

                    precototal = $(this).parents(".linhaDados").find(".precototal");

                    produtoprecoquantidade = (valpreco * valquantidade).toFixed(2);

                    precototal.val(produtoprecoquantidade);  

                    total_precototal();

                    //total_precototalaf();

                });
            });


            //function that will get the total precototal by each class
            var total_precototal =  function() {
                var sum = 0;

                $('.precototal').each(function(){
                    //var num = $(this).val().replace(',','');
                    var num = $(this).val();
                    
                    if(num != 0) {
                        sum += parseFloat(num);
                    }
                });
                
                $('#valor').val(sum.toFixed(2));
            }



            /* $(".af").each(function() {
                $(this).change(function(){

                    let isChecked = $(this).is(':checked');
                    alert(isChecked); // true (if checked at the time)
                    if(isChecked){

                    }

                    valpreco = $(this).parents(".linhaDados").find(".preco").val();
                    
                    valquantidade = $(this).parents(".linhaDados").find(".quantidade").val();

                    produtoprecoquantidade = (valpreco * valquantidade).toFixed(2);

                    $("#valoraf").val(produtoprecoquantidade).toFixed(2);
                });
            }); */




            $('.af').each(function(){
                $(this).change(function(){
                    total_precototalaf();
                });
            });


            var total_precototalaf = function() {

                var sumaf = 0;

                $('.af').each(function() {
                    if($(this).is(':checked')){
                        precototal = $(this).parents(".linhaDados").find(".precototal").val();

                        sumaf += parseFloat(precototal);
                    }
                });

                $("#valoraf").val(sumaf.toFixed(2));


            }

           
        });

    </script>
@endsection

