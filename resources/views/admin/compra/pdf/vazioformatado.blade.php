<div class='col-lg-2'><div class='form-group focused'><select name='produto_id' id='produto_id' class='form-control' required><option value='' selected disabled>Escolha...</option>@foreach($produtos  as $produto)<option value='{{$produto->id}}' {{old('produto_id') == $produto->id ? 'selected' : ''}}>{{$produto->nome}}</option>@endforeach</select></div></div>

<div class='col-lg-1'><div class='form-group focused'><input type='text' class='form-control text-right quantidade' id='quantidade' name='quantidade' value='{{old('quantidade')}}' required></div></div>

<div class='col-lg-1'><div class='form-group focused'><select name='medida_id' id='medida_id' class='form-control' required><option value='' selected disabled>Escolha...</option>@foreach($medidas  as $medida)<option value='{{$medida->id}}' {{old('medida_id') == $medida->id ? 'selected' : ''}}>{{$medida->simbolo}}</option>@endforeach</select></div></div>

<div class='col-lg-2'><div class='form-group focused'><input type='text' class='form-control' id='detalhe' name='detalhe' value='{{old('detalhe')}}' required></div></div>

<div class='col-lg-2'><div class='form-group focused'><input type='text' class='form-control text-right preco' id='preco' name='preco' value='{{old('preco')}}' required></div></div>

<div class='col-lg-1' style='margin-right: -70px'><div class='form-group focused'><input type='checkbox' class='af' id='af' name='af' value='{{old('af')}}' style='margin-top: 15px;'></div></div>

<div class='col-lg-2'><div class='form-group focused'><input type='text' class='form-control text-right precototal' id='precototal' name='precototal' value='{{old('precototal')}}' readonly></div></div>

<div class='pl-lg-1'><a class='btn btn-success add-linha' href='#' role='button'><i class='fas fa-plus'></i></a>&nbsp;&nbsp;<a class='btn btn-danger' href='#' role='button'><i class='fas fa-minus'></i></a></div>
