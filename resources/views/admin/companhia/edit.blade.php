@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800">Companhia / Editar</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{$companhia->nomefantasia}}<br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form action="{{route('admin.companhia.update', $companhia->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" >
                        @csrf
                        @method('PUT')

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- razaosocial --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="razaosocial">Razão Social<span class="small text-danger">*</span></label>
                                        <input type="text" id="razaosocial" class="form-control" name="razaosocial" value="{{old('razaosocial', $companhia->razaosocial)}}" required>
                                        @error('razaosocial')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- nomefantasia --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nomefantasia">Nome de Fantasia<span class="small text-danger">*</span></label>
                                        <input type="text" id="nomefantasia" class="form-control" name="nomefantasia" value="{{old('nomefantasia', $companhia->nomefantasia)}}" required>
                                        @error('nomefantasia')
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
                                        <input type="text" id="cnpj" class="form-control" name="cnpj" value="{{old('cnpj', $companhia->cnpj)}}" required>
                                        @error('cnpj')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- codigocnae --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="codigocnae">Cód. CNAE<span class="small text-danger">*</span></label>
                                        <input type="text" id="codigocnae" class="form-control" name="codigocnae" value="{{old('codigocnae', $companhia->codigocnae)}}" required>
                                        @error('codigocnae')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- documentocnpj--}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="file">Documento CNPJ (arquivo do tipo .pdf)<span class="small text-danger">*</span></label>
                                        <input type="file" id="file" style="display:block" name="file" placeholder="Aqui">
                                        @error('file')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{--
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="documentocnpjAntigo">Documento CNPJ (arquivo do tipo .pdf)<span class="small text-danger">*</span></label>
                                        <input type="text" id="documentocnpjAntigo" class="form-control" name="documentocnpjAntigo" value="{{old('documentocnpjAntigo', $companhia->documentocnpj)}}" readonly>
                                        @error('documentocnpjAntigo')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                --}}
                            </div>

                            <div class="row">
                                {{-- titularum --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="titularum">1º Representante<span class="small text-danger">*</span></label>
                                        <input type="text" id="titularum" class="form-control" name="titularum" value="{{old('titularum', $companhia->titularum)}}" required>
                                        @error('titularum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cargotitum --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cargotitum">Cargo<span class="small text-danger">*</span></label>
                                        <input type="text" id="cargotitum" class="form-control" name="cargotitum" value="{{old('cargotitum', $companhia->cargotitum)}}" required>
                                        @error('cargotitum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                {{-- titulardois --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="titulardois">2º Representante<span class="small text-danger">*</span></label>
                                        <input type="text" id="titulardois" class="form-control" name="titulardois" value="{{old('titulardois', $companhia->titulardois)}}">
                                        @error('titulardois')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cargotitdois --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cargotitdois">Cargo<span class="small text-danger">*</span></label>
                                        <input type="text" id="cargotitdois" class="form-control" name="cargotitdois" value="{{old('cargotitdois', $companhia->cargotitdois)}}">
                                        @error('cargotitdois')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- banco_id
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="banco_id">Banco<span class="small text-danger">*</span></label>
                                        <select name="banco_id" id="banco_id" class="form-control" required>
                                            <option value="" selected disabled>Escolha...</option>
                                            @foreach($bancos  as $banco)
                                                <option value="{{$banco->id}}" {{old('banco_id', $companhia->banco_id) == $banco->id ? 'selected' : ''}}>{{$banco->nome}}</option>
                                            @endforeach
                                        </select>
                                        @error('banco_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>--}}

                                {{-- agencia --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="agencia">Agência<span class="small text-danger">*</span></label>
                                        <input type="text" id="agencia" class="form-control" name="agencia" value="{{old('agencia', $companhia->agencia)}}" required>
                                        @error('agencia')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- conta --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="conta">Conta Corrente<span class="small text-danger">*</span></label>
                                        <input type="text" id="conta" class="form-control" name="conta" value="{{old('conta', $companhia->conta)}}" required>
                                        @error('conta')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- celular --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="celular">Celular<span class="small text-danger">*</span></label>
                                        <input type="text" id="celular" class="form-control mask-cell" name="celular" placeholder="(99) 9999-9999" value="{{old('celular', $companhia->celular)}}" required>
                                        @error('celular')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- foneum --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="foneum">1º Telefone<span class="small text-danger">*</span></label>
                                        <input type="text" id="foneum" class="form-control mask-cell" name="foneum" placeholder="(99) 9999-9999" value="{{old('foneum', $companhia->foneum)}}">
                                        @error('foneum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- fonedois --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="fonedois">2º Telefone</label>
                                        <input type="text" id="fonedois" class="form-control mask-cell" name="fonedois" placeholder="(99) 9999-9999" value="{{old('fonedois', $companhia->fonedois)}}">
                                        @error('fonedois')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- emailum --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="emailum">1º E-mail<span class="small text-danger">*</span></label>
                                        <input type="emailum" id="emailum" class="form-control" name="emailum" value="{{old('emailum', $companhia->emailum)}}" required>
                                        @error('emailum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- emaildois --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="emaildois">2º E-mail<span class="small text-danger">*</span></label>
                                        <input type="emaildois" id="emaildois" class="form-control" name="emaildois" value="{{old('emaildois', $companhia->emaildois)}}">
                                        @error('emaildois')
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
                                        <input type="text" id="logradouro" class="form-control" name="logradouro" value="{{old('logradouro', $companhia->logradouro)}}" required>
                                        @error('logradouro')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- numero --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="numero">Número<span class="small text-danger">*</span></label>
                                        <input type="text" id="numero" class="form-control" name="numero" value="{{old('numero', $companhia->numero)}}" required>
                                        @error('numero')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- complemento --}}
                                <div class="col-lg-5">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="complemento">Complemento</label>
                                        <input type="text" id="complemento" class="form-control" name="complemento" value="{{old('complemento', $companhia->complemento)}}">
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
                                                <option value="{{$municipio->id}}" {{old('municipio_id', $companhia->municipio->id) == $municipio->id ? 'selected' : ''}}>{{$municipio->nome}}</option>
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
                                                    @if($bairro->municipio_id == $companhia->municipio_id)
                                                        <option value="{{$bairro->id}}" {{old('bairro_id', $companhia->bairro->id) == $bairro->id ? 'selected' : ''}}>{{$bairro->nome}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @enderror

                                        @error('bairro_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cep --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cep">CEP<span class="small text-danger">*</span></label>
                                        <input type="text" id="cep" class="form-control" name="cep" value="{{old('cep', $companhia->cep)}}" required>
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
                                                <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{old('ativo', $companhia->ativo) == '1' ? 'checked' : ''}}  required>
                                                <label class="form-check-label" for="ativosim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{old('ativo', $companhia->ativo) == '0' ? 'checked' : ''}}  required>
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
                                    <a class="btn btn-primary" href="{{route('admin.companhia.index')}}" role="button">Cancelar</a>
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
