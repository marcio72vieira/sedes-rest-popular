@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800">Empresa / Exibir</h5>

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

                    <form action="" method=""  autocomplete="off">

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- razaosocial --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="razaosocial">Razão Social<span class="small text-danger">*</span></label>
                                        <input type="text" id="razaosocial" class="form-control" name="razaosocial" value="{{$empresa->razaosocial}}" readonly>
                                        @error('razaosocial')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- nomefantasia --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nomefantasia">Nome de Fantasia<span class="small text-danger">*</span></label>
                                        <input type="text" id="nomefantasia" class="form-control" name="nomefantasia" value="{{$empresa->nomefantasia}}" readonly>
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
                                        <input type="text" id="cnpj" class="form-control" name="cnpj" value="{{$empresa->cnpj}}" readonly>
                                        @error('cnpj')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- codigocnae --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="codigocnae">Cód. CNAE<span class="small text-danger">*</span></label>
                                        <input type="text" id="codigocnae" class="form-control" name="codigocnae" value="{{$empresa->codigocnae}}" readonly>
                                        @error('codigocnae')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- documentocnpj
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="documentocnpj">Documento CNPJ (arquivo do tipo .pdf)<span class="small text-danger">*</span></label>
                                        <input type="file" id="documentocnpj" style="display:block" name="documentocnpj" readonly placeholder="Aqui">
                                        @error('documentocnpj')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                --}}

                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="documentocnpj">Documento CNPJ (arquivo do tipo .pdf)<span class="small text-danger">*</span></label>
                                        <input type="text" id="documentocnpj" class="form-control" name="documentocnpj" value="{{$empresa->documentocnpj}}"  readonly>
                                        @error('documentocnpj')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- titularum --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="titularum">1º Representante<span class="small text-danger">*</span></label>
                                        <input type="text" id="titularum" class="form-control" name="titularum" value="{{$empresa->titularum}}" readonly>
                                        @error('titularum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cargotitum --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cargotitum">Cargo<span class="small text-danger">*</span></label>
                                        <input type="text" id="cargotitum" class="form-control" name="cargotitum" value="{{$empresa->cargotitum}}" readonly>
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
                                        <input type="text" id="titulardois" class="form-control" name="titulardois" value="{{$empresa->titulardois}}" readonly>
                                        @error('titulardois')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cargotitdois --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cargotitdois">Cargo<span class="small text-danger">*</span></label>
                                        <input type="text" id="cargotitdois" class="form-control" name="cargotitdois" value="{{$empresa->cargotitdois}}" readonly>
                                        @error('cargotitdois')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- banco_id --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="banco_id">Banco<span class="small text-danger">*</span></label>
                                        <select name="banco_id" id="banco_id" class="form-control" disabled>
                                            <option value="">{{$empresa->banco->nome}}</option>
                                        </select>
                                        @error('banco_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- agencia --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="agencia">Agência<span class="small text-danger">*</span></label>
                                        <input type="text" id="agencia" class="form-control" name="agencia" value="{{$empresa->agencia}}" readonly>
                                        @error('agencia')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- conta --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="conta">Conta Corrente<span class="small text-danger">*</span></label>
                                        <input type="text" id="conta" class="form-control" name="conta" value="{{$empresa->conta}}" readonly>
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
                                        <input type="text" id="celular" class="form-control mask-cell" name="celular" value="{{$empresa->celular}}" readonly>
                                        @error('celular')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- foneum --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="foneum">1º Telefone<span class="small text-danger">*</span></label>
                                        <input type="text" id="foneum" class="form-control mask-cell" name="foneum" value="{{$empresa->foneum}}" readonly>
                                        @error('foneum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- fonedois --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="fonedois">2º Telefone</label>
                                        <input type="text" id="fonedois" class="form-control mask-cell" name="fonedois" value="{{$empresa->fonedois}}" readonly>
                                        @error('fonedois')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- emailum --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="emailum">1º E-mail<span class="small text-danger">*</span></label>
                                        <input type="emailum" id="emailum" class="form-control" name="emailum" value="{{$empresa->emailum}}" readonly>
                                        @error('emailum')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- emaildois --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="emaildois">2º E-mail<span class="small text-danger">*</span></label>
                                        <input type="emaildois" id="emaildois" class="form-control" name="emaildois" value="{{$empresa->emaildois}}" readonly>
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
                                        <input type="text" id="logradouro" class="form-control" name="logradouro" value="{{$empresa->logradouro}}" readonly>
                                        @error('logradouro')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- numero --}}
                                <div class="col-lg-1">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="numero">Número<span class="small text-danger">*</span></label>
                                        <input type="text" id="numero" class="form-control" name="numero" value="{{$empresa->numero}}" readonly>
                                        @error('numero')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- complemento --}}
                                <div class="col-lg-5">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="complemento">Complemento</label>
                                        <input type="text" id="complemento" class="form-control" name="complemento" value="{{$empresa->complemento}}" readonly>
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
                                            <option value="">{{$empresa->municipio->nome}}</option>
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
                                            <option value="">{{$empresa->bairro->nome}}</option>
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
                                        <input type="text" id="cep" class="form-control" name="cep" value="{{$empresa->cep}}" readonly>
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
                                                <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{$empresa->ativo == '1' ? 'checked' : ''}} disabled>
                                                <label class="form-check-label" for="ativosim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{$empresa->ativo == '0' ? 'checked' : ''}} disabled>
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
                                    <a class="btn btn-primary" href="{{route('admin.empresa.index')}}" role="button">
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

