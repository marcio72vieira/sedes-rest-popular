@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Nutricionistas da empresa: {{ $empresa->nomefantasia }}</strong></h5>

    <a class="btn btn-primary" href="{{route('admin.empresa.index')}}" role="button" style="margin-bottom: 6px;">
        <i class="fas fa-undo-alt"></i>
        Voltar
    </a>

    <a class="btn btn-primary btn-danger" href="{{route('admin.empresa.relpdfempresanutricionistas', $empresa->id)}}" role="button" style="margin-bottom: 10px" target="_blank">
        <i class="far fa-file-pdf"></i>pdf
    </a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Contato</th>
                            <th>Restaurante</th>
                            <th>Ativo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($nutricionistas as $nutricionista)
                            <tr>
                                <td>{{$nutricionista->id}}</td>
                                <td>{{$nutricionista->nomecompleto}}</td>
                                <td>{{$nutricionista->email}}; {{$nutricionista->telefone}}</td>
                                <td>
                                    @isset($nutricionista->restaurante->identificacao)
                                        {{$nutricionista->restaurante->identificacao}}
                                    @endisset</td>
                                <td>
                                    @if($nutricionista->ativo == 1) <b><i class="fas fa-check text-success mr-2"></i></b> 
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

