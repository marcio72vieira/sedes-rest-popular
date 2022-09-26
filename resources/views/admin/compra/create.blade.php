@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Restaurante / Compras / Cadastrar</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Compras <br><br>
                        Município: {{$restaurante->municipio->nome }}<br>
                        Restaurante: {{$restaurante->identificacao }}<br>
                        Nutricionista da Empresa: {{$restaurante->nutricionista->nomecompleto}}<br>
                        Nutricionista da Sedes: {{$restaurante->user->nomecompleto}}<br>
                        <br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form action="{{route('admin.restaurante.compra.store', $restaurante->id)}}" method="POST" autocomplete="off">
                        @csrf

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- semana --}}
                                <div class="col-lg-1">
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
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="data_ini">Data Inicial<span class="small text-danger">*</span></label>
                                        <input type="date" id="data_ini" class="form-control" name="data_ini" value="{{old('data_ini')}}" required>
                                        @error('data_ini')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- data_fin --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="data_fin">Data Final<span class="small text-danger">*</span></label>
                                        <input type="date" id="data_fin" class="form-control" name="data_fin" value="{{old('data_fin')}}" required>
                                        @error('data_fin')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valor --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valor">Valor (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valor" name="valor" value="{{old('valor')}}" required>
                                        @error('valor')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valoraf --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valoraf">Valor AF (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valoraf" name="valoraf" value="{{old('valoraf')}}" required>
                                        @error('valoraf')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valortotal --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valortotal">Valor Total (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valortotal" name="valortotal" value="{{old('valortotal')}}">
                                        @error('valortotal')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

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

