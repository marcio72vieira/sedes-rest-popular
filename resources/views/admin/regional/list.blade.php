@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Municípios da regional: {{ $regional->nome }}</strong></h5>

    <a class="btn btn-primary" href="{{route('admin.regional.index')}}" role="button" style="margin-bottom: 6px;">
        <i class="fas fa-undo-alt"></i>
        Voltar
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
        </div>
   </div>
</div>
@endsection

