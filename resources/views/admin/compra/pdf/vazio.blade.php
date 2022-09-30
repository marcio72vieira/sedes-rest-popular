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
            <a class="btn btn-success add-linha" href="#" role="button"><i class="fas fa-plus"></i></a>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="#" role="button"><i class="fas fa-minus"></i></a>
    </div>
</div>
