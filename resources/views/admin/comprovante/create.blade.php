@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800"> Restaurante / Compra / Comprovante / Cadastrar</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Comprovante<br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{route('admin.compra.comprovante.store', [$compra->id])}}" enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- url--}}
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="url">Comprovante (arquivo do tipo .pdf)<span class="small text-danger">*</span></label>
                                        <input type="file" id="url" style="display:block" name="url" value="{{old('url')}}">
                                        @error('url')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Buttons -->
                                <div class="pl-lg-4">
                                    <div style="margin-top: 30px">
                                        <a class="btn btn-primary" href="{{route('admin.compra.comprovante.index', [mrc_encrypt_decrypt('encrypt',$compra->id)])}}" role="button">Cancelar</a>
                                        <button type="submit" class="btn btn-primary" style="width: 95px;"> Enviar </button>
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

