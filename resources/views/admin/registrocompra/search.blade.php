@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>CONSULTAS</h5>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="accordion" id="accordionExample">
                
                {{-- Produção Restaurante Mês Ano --}}
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <strong>Produção mês por Restaurantes</strong>
                      </button>
                    </h2>
                    @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Atenção! </strong> {{session('error')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                  </div>
              
                  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <form action="{{route('admin.consulta.producaorestmesano')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
                          <div class="form-group mx-sm-3 mb-2">
                            <select name="restaurante_id" id="restaurante_id" class="form-control" required>
                              <option value="" selected disabled>Restaurante...</option>
                              @foreach($restaurantes  as $restaurante)
                                <option value="{{$restaurante->id}}"> {{$restaurante->identificacao}} </option>
                              @endforeach
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="mes_id" id="mes_id" class="form-control" required>
                              <option value="" selected disabled>Mês...</option>
                              <option value="1">Jan </option>
                              <option value="2">Fev </option>
                              <option value="3">Mar </option>
                              <option value="4">Abr </option>
                              <option value="5">Mai </option>
                              <option value="6">Jun </option>
                              <option value="7">Jul </option>
                              <option value="8">Ags </option>
                              <option value="9">Set </option>
                              <option value="10">Out </option>
                              <option value="11">Nov </option>
                              <option value="12">Dez </option>
                            </select>

                            &nbsp;&nbsp;&nbsp;

                            <select name="ano_id" id="ano_id" class="form-control" required>
                              <option value="" selected disabled>Ano...</option>
                              <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                              <option value="{{ date("Y") -1 }}">{{ date("Y") - 1 }}</option>
                              <option value="{{ date("Y") -2 }}">{{ date("Y") - 2 }}</option>
                              <option value="{{ date("Y") -3 }}">{{ date("Y") - 3 }}</option>
                            </select>
                          </div>
                          <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
                        </form>
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Collapsible Group Item #2
                      </button>
                    </h2>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="sr-only">Email</label>
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="password" class="form-control" id="inputPassword2" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">pesquisar</button>
                        </form>
                    </div>
                  </div>
                </div>

              </div>
        </div>
   </div>
</div>
@endsection
