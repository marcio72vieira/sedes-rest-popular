@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Restaurante / Compras / Exibir</h5>

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

                    <form action="" method="" autocomplete="off">

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- semana --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="semana">Nº Semana<span class="small text-danger">*</span></label>
                                        <select name="semana" id="semana" class="form-control" disabled>
                                            <option value="">{{mrc_extract_week($compra->semana)}}</option>
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
                                        <input type="date" id="data_ini" class="form-control" name="data_ini" value="{{$compra->data_ini}}" disabled>
                                        @error('data_ini')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- data_fin --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="data_fin">Data Final<span class="small text-danger">*</span></label>
                                        <input type="date" id="data_fin" class="form-control" name="data_fin" value="{{$compra->data_fin}}" disabled>
                                        @error('data_fin')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valor --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valor">Valor (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valor" name="valor" value="{{mrc_turn_value($compra->valor)}}" disabled>
                                        @error('valor')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valoraf --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valoraf">Valor AF (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valoraf" name="valoraf" value="{{mrc_turn_value($compra->valoraf)}}" disabled>
                                        @error('valoraf')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- valortotal --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="valortotal">Valor Total (R$)<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="valortotal" name="valortotal" value="{{mrc_turn_value($compra->valortotal)}}" disabled>
                                        @error('valortotal')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <br><br>
                            <!-- Buttons -->
                            
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-center">
                                        <a class="btn btn-primary" href="{{route('admin.restaurante.compra.index', $compra->id)}}" role="button">Retornar</a>
                                        {{-- <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button> --}}
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
