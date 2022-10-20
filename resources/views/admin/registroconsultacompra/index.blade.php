@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>REGISTRO DE COMPRAS</strong></h5>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                {{ $restaurante[0]['identificacao'] }}
            </div>
        </div>
   </div>
</div>
@endsection
