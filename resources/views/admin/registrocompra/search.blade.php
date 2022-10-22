@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>CONSULTAS</h5>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="input-group mb-3">
                <select class="custom-select" id="inputGroupSelect02">
                  <option selected>Escolha a consulta...</option>
                  <option value="1">Produtos por Regionais</option>
                  <option value="2">Produtos por Meses</option>
                  <option value="3">Outros Relatórios</option>
                </select>
                <div class="input-group-append">
                  <label class="input-group-text" for="inputGroupSelect02">Relatórios</label>
                </div>
            </div>



            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Janeiro</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Fevereiro</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Março</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Informações de Home</div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Informações de Perfil</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    Informações de Contatos
                    <br>
                    @foreach ($records as $item)
                        {{ $item->produto_nome }}  - {{ $item->detalhe }} <br>  
                    @endforeach
                </div>
            </div>


            {{-- 
                <!-- Collapsable Card Example -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Produtos por Regional</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            This is a collapsable card example using Bootstrap's built in collapse
                            functionality. <strong>Click on the card header</strong> to see the card body
                            collapse and expand!
                        </div>
                    </div>
                </div>
            --}}

            {{-- 
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Mês</th>
                                <th>Semana</th>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Valor AF</th>
                                <th>Valor Total</th>
                                <th>% AF</th>
                                <th>Comprovantes</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            
                        </tbody>
                    </table>
                </div> 
            --}}


        </div>
   </div>
</div>
@endsection
