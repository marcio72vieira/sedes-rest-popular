@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Municípios e Restaurantes da regional: {{ $regional->nome }}</strong></h5>

    <a class="btn btn-primary" href="{{route('admin.regional.index')}}" role="button" style="margin-bottom: 6px;">
        <i class="fas fa-undo-alt"></i>
        Voltar
    </a>

   {{--  <a class="btn btn-primary btn-danger" href="{{route('admin.regional.relpdfregionalmunicipios', $regional->id)}}" role="button" style="margin-bottom: 10px" target="_blank">
        <i class="far fa-file-pdf"></i>pdf
    </a> --}}


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <h4>Municípios
                @if($municipios->count() > 0)
                <a class="btn btn-primary btn-danger" href="{{route('admin.regional.relpdfregionalmunicipios', $regional->id)}}" role="button" style="margin: 10px; padding: 2px 10px" target="_blank">
                    <i class="far fa-file-pdf fa-sm"></i> pdf
                </a>
                @endif
            </h4>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Ativo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($municipios as $municipio)
                            <tr>
                                <td>{{$municipio->id}}</td>
                                <td>{{$municipio->nome}}</td>
                                <td>
                                    @if($municipio->ativo == 1) <b><i class="fas fa-check text-success mr-2"></i></b> 
                                    @else <b><i class="fas fa-times  text-danger mr-2"></i></b> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <br>
            <br>
            <hr style="border: 2px solid #d6d5d5">
            <h4>Restaurantes
                @if($restaurantes->count() > 0)
                <a class="btn btn-primary btn-danger" href="{{route('admin.regional.relpdfregionalrestaurantes', $regional->id)}}" role="button" style="margin: 10px; padding: 2px 10px" target="_blank">
                    <i class="far fa-file-pdf fa-sm"></i> pdf
                </a>
                @endif
            </h4>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Ativo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($restaurantes as $restaurante)
                            <tr>
                                <td>{{$restaurante->id}}</td>
                                <td>{{$restaurante->identificacao}}</td>
                                <td>
                                    @if($restaurante->ativo == 1) <b><i class="fas fa-check text-success mr-2"></i></b> 
                                    @else <b><i class="fas fa-times  text-danger mr-2"></i></b> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>





        </div>
   </div>
</div>
@endsection

