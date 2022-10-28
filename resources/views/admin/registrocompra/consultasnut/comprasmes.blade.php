@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Compras {{ date("Y") }}</h5>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="jan-tab" data-toggle="tab" href="#jan" role="tab" aria-controls="jan" aria-selected="true">Jan</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="fev-tab" data-toggle="tab" href="#fev" role="tab" aria-controls="fev" aria-selected="false">Fev</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="mar-tab" data-toggle="tab" href="#mar" role="tab" aria-controls="mar" aria-selected="false">Mar</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="abr-tab" data-toggle="tab" href="#abr" role="tab" aria-controls="abr" aria-selected="false">Abr</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="mai-tab" data-toggle="tab" href="#mai" role="tab" aria-controls="mai" aria-selected="false">Mai</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="jun-tab" data-toggle="tab" href="#jun" role="tab" aria-controls="jun" aria-selected="false">Jun</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="jan" role="tabpanel" aria-labelledby="janeiro-tab">
                    Relacao de compras de Janeiro
                    <br>
                    @foreach ($records as $item)
                        {{ $item->produto_nome }}  - {{ $item->detalhe }} <br>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="fev" role="tabpanel" aria-labelledby="fevereiro-tab">Relação de compras de Fevereiro</div>
                <div class="tab-pane fade" id="mar" role="tabpanel" aria-labelledby="marco-tab">Relação de compras de Março</div>

                <div class="tab-pane fade" id="abr" role="tabpanel" aria-labelledby="abr-tab">Relação de compras de Abril</div>
                <div class="tab-pane fade" id="mai" role="tabpanel" aria-labelledby="mai-tab">Relação de compras de Maio</div>
                <div class="tab-pane fade" id="jun" role="tabpanel" aria-labelledby="jun-tab">Relação de compras de Junho</div>
            </div>
        </div>
   </div>
</div>
@endsection
