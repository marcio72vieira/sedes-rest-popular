@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800">Restaurante / Editar</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{$restaurante->identificacao}}<br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form action="{{route('admin.restaurante.update', $restaurante->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" >
                        @csrf
                        @method('PUT')

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- identificacao --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="identificacao">Identificação da Unidade<span class="small text-danger">*</span></label>
                                        <input type="text" id="identificacao" class="form-control" name="identificacao" value="{{old('identificacao', $restaurante->identificacao)}}" required>
                                        @error('identificacao')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- user_id (Usuário Nutricionista) --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="user_id">Nutricionista da SEDES<span class="small text-danger">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($users  as $user)
                                                <option value="{{$user->id}}" {{old('user_id', $restaurante->user->id) == $user->id ? 'selected' : ''}}>{{$user->nomecompleto}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                {{-- empresa_id --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="empresa_id">Empresa<span class="small text-danger">*</span></label>
                                        <select name="empresa_id" id="empresa_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($empresas  as $empresa)
                                                <option value="{{$empresa->id}}" {{old('empresa_id', $restaurante->empresa->id) == $empresa->id ? 'selected' : ''}}>{{$empresa->nomefantasia}}</option>
                                            @endforeach
                                        </select>
                                        @error('empresa_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>



                                {{-- nutricionista_id --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nutricionista_id">Nutricionista da Empresa<span class="small text-danger">*</span></label>

                                        @if(count($errors) > 0)
                                            <select name="nutricionista_id" id="nutricionista_id" class="form-control" required>
                                                <option value="" selected disabled>Escolha nutricionista...</option>
                                                @foreach($nutricionistas  as $nutricionista)
                                                    @if($nutricionista->municipio_id == old('municipio_id'))
                                                        <option value="{{$nutricionista->id}}" {{old('nutricionista_id') == $nutricionista->id ? 'selected' : ''}}>{{$nutricionista->nomecompleto}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select name="nutricionista_id" id="nutricionista_id" class="form-control" required>
                                                <option value="" selected disabled>Escolha nutricionista...</option>
                                                @foreach($nutricionistas  as $nutricionista)
                                                    {{--Só mostra os nutricionistas cujo id da empresa do nutricionista é igual ao id da empresa do restaurante--}}
                                                    @if($nutricionista->empresa_id == $restaurante->empresa_id)
                                                        <option value="{{$nutricionista->id}}" {{old('nutricionista_id', $restaurante->nutricionista->id) == $nutricionista->id ? 'selected' : ''}}>{{$nutricionista->nomecompleto}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif

                                        @error('bairro_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <br>

                            <h5>Endereço</h5>

                            <div class="row">
                                {{-- logradouro --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="logradouro">Rua; Av; Travessa, etc...<span class="small text-danger">*</span></label>
                                        <input type="text" id="logradouro" class="form-control" name="logradouro" value="{{old('logradouro', $restaurante->logradouro)}}" required>
                                        @error('logradouro')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- numero --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="numero">Número<span class="small text-danger">*</span></label>
                                        <input type="text" id="numero" class="form-control" name="numero" value="{{old('numero', $restaurante->numero)}}" required>
                                        @error('numero')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- complemento --}}
                                <div class="col-lg-5">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="complemento">Complemento</label>
                                        <input type="text" id="complemento" class="form-control" name="complemento" value="{{old('complemento', $restaurante->complemento)}}">
                                        @error('complemento')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                {{-- municipio_id --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="municipio_id">Município<span class="small text-danger">*</span></label>
                                        <select name="municipio_id" id="municipio_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($municipios  as $municipio)
                                                <option value="{{$municipio->id}}" {{old('municipio_id', $restaurante->municipio->id) == $municipio->id ? 'selected' : ''}}>{{$municipio->nome}}</option>
                                            @endforeach
                                        </select>
                                        @error('municipio_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- bairro_id --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="bairro_id">Bairro<span class="small text-danger">*</span></label>

                                        @if(count($errors) > 0)
                                            <select name="bairro_id" id="bairro_id" class="form-control" required>
                                                <option value="" selected disabled>Escolha o Bairro...</option>
                                                @foreach($bairros  as $bairro)
                                                    @if($bairro->municipio_id == old('municipio_id'))
                                                        <option value="{{$bairro->id}}" {{old('bairro_id') == $bairro->id ? 'selected' : ''}}>{{$bairro->nome}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select name="bairro_id" id="bairro_id" class="form-control" required>
                                                <option value="" selected disabled>Escolha o Bairro...</option>
                                                @foreach($bairros  as $bairro)
                                                    @if($bairro->municipio_id == $restaurante->municipio_id)
                                                        <option value="{{$bairro->id}}" {{old('bairro_id', $restaurante->bairro->id) == $bairro->id ? 'selected' : ''}}>{{$bairro->nome}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif

                                        @error('bairro_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cep --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cep">CEP<span class="small text-danger">*</span></label>
                                        <input type="text" id="cep" class="form-control" name="cep" value="{{old('cep', $restaurante->cep)}}" required>
                                        @error('cep')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ativo --}}
                                <div class="col-lg-2 offset-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="ativo">Ativo ? <span class="small text-danger">*</span></label>
                                        <div style="margin-top: 5px">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{old('ativo', $restaurante->ativo) == '1' ? 'checked' : ''}}  required>
                                                <label class="form-check-label" for="ativosim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{old('ativo', $restaurante->ativo) == '0' ? 'checked' : ''}}  required>
                                                <label class="form-check-label" for="ativonao">Não</label>
                                            </div>
                                            @error('ativo')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <a class="btn btn-primary" href="{{route('admin.restaurante.index')}}" role="button">Cancelar</a>
                                    <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
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

{{-- A vantagem de colocar scripts no final da página, é que vocẽ pode usar as diretivas do blade diretamente no javascript
    pois a página como um todo, é uma página blade.php --}}
@section('scripts')

    <script>
        $(document).ready(function() {
            //Recuperação dinâmica dos nutricionistas de uma empresa
            $('#empresa_id').on('change', function() {
                var empresa_id = this.value;
                $("#nutricionista_id").html('');
                $.ajax({
                    url:"{{route('admin.getnutricionistasempresas')}}",
                    type: "POST",
                    data: {
                        empresa_id: empresa_id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType : 'json',
                    success: function(result){
                        $('#nutricionista_id').html('<option value="">Escolha Nutricionista...</option>');
                        $.each(result.nutricionistas,function(key,value){
                            $("#nutricionista_id").append('<option value="'+value.id+'">'+value.nomecompleto+'</option>');
                        });
                    }
                });
            });


            //Recuperação dinâmica dos bairros de um município
            $('#municipio_id').on('change', function() {
                var municipio_id = this.value;
                $("#bairro_id").html('');
                $.ajax({
                    url:"{{route('admin.getbairrosrestaurante')}}",
                    type: "POST",
                    data: {
                        municipio_id: municipio_id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType : 'json',
                    success: function(result){
                        $('#bairro_id').html('<option value="">Escolha o Bairro...</option>');
                        $.each(result.bairros,function(key,value){
                            $("#bairro_id").append('<option value="'+value.id+'">'+value.nome+'</option>');
                        });
                    }
                });
            });

        });
    </script>
@endsection
