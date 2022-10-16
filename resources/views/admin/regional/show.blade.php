@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Suporte / Regionais / Exibir</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{$regional->nome}}<br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form action="" method="" autocomplete="off">

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- Nome --}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nome">Nome<span class="small text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="{{$regional->nome}}" readonly>
                                        @error('nome')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ativo --}}
                                <div class="col-lg-3">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="ativo">Ativo ? <span class="small text-danger">*</span></label>
                                        <div style="margin-top: 5px">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativosim" value="1"  {{old('ativo', $regional->ativo) == '1' ? 'checked' : ''}}  disabled>
                                                <label class="form-check-label" for="ativosim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ativo" id="ativonao" value="0"  {{old('ativo', $regional->ativo) == '0' ? 'checked' : ''}}  disabled>
                                                <label class="form-check-label" for="ativonao">Não</label>
                                            </div>
                                            @error('ativo')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="pl-lg-4">
                                        <div style="margin-top: 30px">
                                            <a class="btn btn-primary" href="{{route('admin.regional.index')}}" role="button">
                                                <i class="fas fa-undo-alt"></i> Retornar
                                            </a>
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
