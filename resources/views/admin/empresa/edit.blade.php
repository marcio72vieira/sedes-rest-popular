@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800">Empresa / Editar</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{$empresa->nomefantasia}}<br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form action="{{route('admin.empresa.update', $empresa->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" >
                        @csrf
                        @method('PUT')

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- razaosocial --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="razaosocial">Razão Social<span class="small text-danger">*</span></label>
                                        <input type="text" id="razaosocial" class="form-control" name="razaosocial" value="{{old('razaosocial', $empresa->razaosocial)}}" required>
                                        @error('razaosocial')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- nomefantasia --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nomefantasia">Nome de Fantasia<span class="small text-danger">*</span></label>
                                        <input type="text" id="nomefantasia" class="form-control" name="nomefantasia" value="{{old('nomefantasia', $empresa->nomefantasia)}}" required>
                                        @error('nomefantasia')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- titular --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="titular">Representante<span class="small text-danger">*</span></label>
                                        <input type="text" id="titular" class="form-control" name="titular" value="{{old('titular', $empresa->titular)}}" required>
                                        @error('titular')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cargotitular --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cargotitular">Cargo<span class="small text-danger">*</span></label>
                                        <input type="text" id="cargotitular" class="form-control" name="cargotitular" value="{{old('cargotitular', $empresa->cargotitular)}}" required>
                                        @error('cargotitular')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                {{-- cnpj --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cnpj">CNPJ<span class="small text-danger">*</span></label>
                                        <input type="text" id="cnpj" class="form-control" name="cnpj" value="{{old('cnpj', $empresa->cnpj)}}" required>
                                        @error('cnpj')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="email">1º E-mail<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" value="{{old('email', $empresa->email)}}" required>
                                        @error('email')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- celular --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="celular">Celular<span class="small text-danger">*</span></label>
                                        <input type="text" id="celular" class="form-control mask-cell" name="celular" placeholder="(99) 9999-9999" value="{{old('celular', $empresa->celular)}}" required>
                                        @error('celular')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- fone --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="fone">1º Telefone<span class="small text-danger">*</span></label>
                                        <input type="text" id="fone" class="form-control mask-cell" name="fone" placeholder="(99) 9999-9999" value="{{old('fone', $empresa->fone)}}">
                                        @error('fone')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <hr>

                            <h5>Endereço</h5>

                            <div class="row">
                                {{-- logradouro --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="logradouro">Rua; Av; Travessa, etc...<span class="small text-danger">*</span></label>
                                        <input type="text" id="logradouro" class="form-control" name="logradouro" value="{{old('logradouro', $empresa->logradouro)}}" required>
                                        @error('logradouro')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- numero --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="numero">Número<span class="small text-danger">*</span></label>
                                        <input type="text" id="numero" class="form-control" name="numero" value="{{old('numero', $empresa->numero)}}" required>
                                        @error('numero')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- complemento --}}
                                <div class="col-lg-5">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="complemento">Complemento</label>
                                        <input type="text" id="complemento" class="form-control" name="complemento" value="{{old('complemento', $empresa->complemento)}}">
                                        @error('complemento')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                {{-- municipio --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="municipio">Município</label>
                                        <input type="text" id="municipio" class="form-control" name="municipio" value="{{old('municipio', $empresa->municipio)}}">
                                        @error('municipio')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- bairro --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="bairro">bairro</label>
                                        <input type="text" id="bairro" class="form-control" name="bairro" value="{{old('bairro', $empresa->bairro)}}">
                                        @error('bairro')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cep --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cep">CEP<span class="small text-danger">*</span></label>
                                        <input type="text" id="cep" class="form-control" name="cep" value="{{old('cep', $empresa->cep)}}" required>
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
                                                <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{old('ativo', $empresa->ativo) == '1' ? 'checked' : ''}}  required>
                                                <label class="form-check-label" for="ativosim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{old('ativo', $empresa->ativo) == '0' ? 'checked' : ''}}  required>
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
                                    <a class="btn btn-primary" href="{{route('admin.empresa.index')}}" role="button">Cancelar</a>
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
            $('#municipio_id').on('change', function() {
                var municipio_id = this.value;
                $("#bairro_id").html('');
                $.ajax({
                    url:"{{route('admin.getbairros')}}",
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
                            //$("#bairro_id").append('<option value="'+value.id+'" {{old("bairro_id") == "'+value.id+'" ? "selected" : ""}}     >'+value.nome'+</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
