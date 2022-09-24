@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800">Restaurante / Exibir</h5>

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

                    <form action="" method=""  autocomplete="off">

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- identificacao --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="identificacao">Identificação da Unidade<span class="small text-danger">*</span></label>
                                        <input type="text" id="identificacao" class="form-control" name="identificacao" value="{{$restaurante->identificacao}}" readonly>
                                        @error('identificacao')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- user_id (Usuário Nutricionista) --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="user_id">Nutricionista da SEDES<span class="small text-danger">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control" disabled>
                                            <option value="">{{$restaurante->user->nomecompleto}}</option>
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
                                        <select name="empresa_id" id="empresa_id" class="form-control" disabled>
                                            <option value="">{{$restaurante->empresa->nomefantasia}}</option>
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
                                        <select name="nutricionista_id" id="nutricionista_id" class="form-control" disabled>
                                            <option value="">{{$restaurante->nutricionista->nomecompleto}}</option>
                                        </select>
                                        @error('nutricionista_id')
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
                                        <input type="text" id="logradouro" class="form-control" name="logradouro" value="{{$restaurante->logradouro}}" readonly>
                                        @error('logradouro')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- numero --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="numero">Número<span class="small text-danger">*</span></label>
                                        <input type="text" id="numero" class="form-control" name="numero" value="{{$restaurante->numero}}" readonly>
                                        @error('numero')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- complemento --}}
                                <div class="col-lg-5">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="complemento">Complemento</label>
                                        <input type="text" id="complemento" class="form-control" name="complemento" value="{{$restaurante->complemento}}" readonly>
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
                                        <select name="municipio_id" id="municipio_id" class="form-control" disabled>
                                            <option value="">{{$restaurante->municipio->nome}}</option>
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
                                        <select name="bairro_id" id="bairro_id" class="form-control" disabled>
                                            <option value="">{{$restaurante->bairro->nome}}</option>
                                        </select>
                                        @error('bairro_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cep --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cep">CEP<span class="small text-danger">*</span></label>
                                        <input type="text" id="cep" class="form-control" name="cep" value="{{$restaurante->cep}}" readonly>
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
                                                <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{$restaurante->ativo == '1' ? 'checked' : ''}} disabled>
                                                <label class="form-check-label" for="ativosim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{$restaurante->ativo == '0' ? 'checked' : ''}} disabled>
                                                <label class="form-check-label" for="ativonao">Não</label>
                                            </div>
                                            <br>
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
                                    <a class="btn btn-primary" href="{{route('admin.restaurante.index')}}" role="button">
                                        <i class="fas fa-undo-alt"></i>
                                        Retornar</a>
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

