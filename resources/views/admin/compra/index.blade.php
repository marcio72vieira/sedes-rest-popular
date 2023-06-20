@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>COMPRAS: Restaurante {{ $restaurante->identificacao }} em {{$restaurante->municipio->nome}}</strong></h5>

        <div class="row">
            <div class="col-4">
                <a class="btn btn-primary" href="{{route('admin.restaurante.compra.create', mrc_encrypt_decrypt('encrypt',$restaurante->id))}}" role="button" style="margin-bottom: 10px">
                    <i class="fas fa-plus-circle"></i>
                    Adicionarr
                </a>
                {{-- <a class="btn btn-primary" id="btnpesquisar" role="button" style="margin-bottom: 10px">
                    <i class="fas fa-search-plus"></i>
                    pesquisar
                </a> --}}
            </div>

            @if(Auth::user()->perfil == 'adm')

                <div class="col-4"  style="text-align: center">
                    <div style="width: 100%; margin: auto">
                        {{-- (Rota aninhada) Tipo: admin/restaurante/{idrestaurante}/compra/index --}}
                        <form action="{{route('admin.restaurante.compra.index', mrc_encrypt_decrypt('encrypt', $restaurante->id))}}"  method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <select name="mes_id" id="mes_id" class="form-control" style="margin-right: 20px">
                                        <option value="" selected disabled>Mês...</option>
                                        @foreach($mesespesquisa as $key => $value)
                                            <option value="{{ $key }}"> {{ $value }} </option>
                                         @endforeach
                                    </select>

                                    <select name="ano_id" id="ano_id" class="form-control">
                                        <option value="" selected disabled>Ano...</option>
                                        @foreach($anospesquisa as $value)
                                            <option value="{{ $value}}"> {{ $value }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2 btn-sm"><i class="fas fa-search-plus"></i> pesquisar</button>
                        </form>
                    </div>
                </div>
                <div class="col-4">
                    {{-- Se o usuário autenticado é ADM retorna para a lista de restaurantes, se NUT não exibe o botão --}}
                    @if(Auth::user()->perfil == 'adm')
                        <a class="btn btn-primary float-right" href="{{route('admin.registroconsultacompra.index')}}" role="button" style="margin-bottom: 10px">
                            <i class="fas fa-undo-alt"></i>
                            Listar Restaurantes
                        </a>
                    @endif
                </div>

            @else

                <div class="col-8">
                    <div style="width: 40%; float: right;">
                        {{-- (Rota aninhada) Tipo: admin/restaurante/{idrestaurante}/compra/index --}}
                        <form action="{{route('admin.restaurante.compra.index', mrc_encrypt_decrypt('encrypt', $restaurante->id))}}"  method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <select name="mes_id" id="mes_id" class="form-control" style="margin-right: 20px">
                                        <option value="" selected disabled>Mês...</option>
                                        @foreach($mesespesquisa as $key => $value)
                                            <option value="{{ $key }}"> {{ $value }} </option>
                                         @endforeach
                                    </select>

                                    <select name="ano_id" id="ano_id" class="form-control">
                                        <option value="" selected disabled>Ano...</option>
                                        @foreach($anospesquisa as $value)
                                            <option value="{{ $value}}"> {{ $value }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2 btn-sm"><i class="fas fa-search-plus"></i> pesquisar</button>
                        </form>
                    </div>
                </div>

            @endif
        </div>


        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>OK!</strong> {{session('sucesso')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
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
                        @foreach($compras as $compra)
                            <tr class="{{($compra->qtdcomprovantesvinc($compra->id) == 0 ? 'alert-danger' : '')}}">
                                <td>{{$compra->id}}</td>
                                <td>{{mrc_extract_month($compra->data_ini)}}</td>
                                <td>{{mrc_extract_week($compra->semana)}}</td>
                                <td>{{mrc_turn_data($compra->data_ini)}} a {{mrc_turn_data($compra->data_fin)}}</td>
                                {{--<td>@if($compra->semana == 1) primeira @elseif ($compra->semana == 2) segunda @elseif ($compra->semana == 3) terceira @elseif ($compra->semana == 4) quarta @elseif ($compra->semana == 5) quinta @endif</td>--}}
                                <td style="text-align: right">{{mrc_turn_value($compra->valor)}}</td>
                                {{--<td>{{mrc_turn_value($compra->valoraf)}}&nbsp;&nbsp;<strong>({{intval(mrc_calc_percentaf($compra->valortotal, $compra->valoraf ))}}%)</strong></td>--}}
                                <td style="text-align: right">{{mrc_turn_value($compra->valoraf)}}</strong></td>
                                <td style="text-align: right">{{mrc_turn_value($compra->valortotal)}}</td>
                                <td style="text-align: center">{{intval(mrc_calc_percentaf($compra->valortotal, $compra->valoraf ))}}%</td>
                                <td style="text-align: right">
                                    {{-- {{$compra->qtdcomprovantesvinc($compra->id)}} --}}
                                    @foreach($compra->comprovantes as $comprovante)
                                        <a href="{{asset('/storage/'.$comprovante->url)}}" target="_blank">
                                            <img src="{{asset('template/img/icopdf.png')}}" width="17">
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('admin.compra.comprovante.index', [$compra->id])}}" title="adicionar comprovantes"><i class="fas fa-file-upload text-success mr-2"></i></a>
                                    {{--<a href="{{route('admin.compra.relpdfcompra', [$compra->id])}}" title="relatório de compra" target="_blank"><i class="fas fa-file-pdf text-danger mr-2"></i></a>--}}
                                    <a href="{{route('admin.restaurante.compra.relpdfcompra', [mrc_encrypt_decrypt('encrypt', $restaurante->id), mrc_encrypt_decrypt('encrypt', $compra->id)])}}" title="relatório desta compra" target="_blank"><i class="fas fa-file-pdf text-danger mr-2"></i></a>
                                    <a href="{{route('admin.restaurante.compra.show', [mrc_encrypt_decrypt('encrypt', $restaurante->id), mrc_encrypt_decrypt('encrypt', $compra->id)])}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.restaurante.compra.edit', [mrc_encrypt_decrypt('encrypt', $restaurante->id), mrc_encrypt_decrypt('encrypt', $compra->id)])}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    @if($compra->qtdcomprovantesvinc($compra->id) == 0)
                                        <a href="" data-toggle="modal" data-target="#formDelete{{$compra->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                                    @else
                                        <a href="" title="há comprovantes vinculados!"><i class="fas fa-trash text-secondary mr-2"></i></a>
                                    @endif


                                    {{-- Utilizado com a antiga lógica de desconstrução de array vindo do CompraController
                                        Se o id da compra atual estiver dentro do array de regsvinculados, impede a deleção acidental.
                                    @if(in_array($compra->id,$regsvinculado))
                                        <a href="" title="há comprovantes vinculados!"><i class="fas fa-trash text-secondary mr-2"></i></a>
                                    @else
                                        <a href="" data-toggle="modal" data-target="#formDelete{{$compra->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                                    @endif --}}


                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$compra->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar compra</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>da {{mrc_extract_week($compra->semana)}} semana do mês de {{mrc_extract_month($compra->data_ini)}}</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.restaurante.compra.destroy', [$restaurante->id, $compra->id])}}" method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" role="button"> Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#btnpesquisar").click(function(){
                $("#formpesquisar").toggle();
            });
        });
    </script>
@endsection

