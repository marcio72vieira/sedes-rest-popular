@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Compras {{ date("Y") - 1 }}</h5>


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
                    <table class="table table-sm table-bordered  table-hover">
                        <thead  class="bg-gray-100">
                            <tr>
                                {{-- Forma de acessar uma propriedade antes de um "FOREACH": $records[0]->coluna --}}
                                <th colspan="4">Região: {{ $records[0]->regional_nome }} - Município: {{ $records[0]->municipio_nome }}</th>
                                <th colspan="4">{{ $records[0]->identificacao }}</th>
                                <th colspan="4" style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registrocompra.comprasmes.relpdfcomprasmes', $records[0]->restaurante_id) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th colspan="4">Nutricionista Empresa: {{ $records[0]->nutricionista_nomecompleto }}</th>
                                <th colspan="4">De: {{ mrc_turn_data($dataInicial) }} a {{ mrc_turn_data($dataFinal) }}</th>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th colspan="4">Nutricionista SEDES: {{ $records[0]->user_nomecompleto }}</th>
                                <th colspan="4"></th>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th scope="col" style="width: 40px; text-align: center">Id</th>
                                <th scope="col" style="width: 100px; text-align: center">semana</th>
                                <th scope="col" style="width: 200px; text-align: center">Produto</th>
                                <th scope="col" style="text-align: center">Detalhe</th>
                                <th scope="col" style="width: 40px; text-align: center">AF</th>
                                <th scope="col" style="width: 100px; text-align: center">Quant.</th>
                                <th scope="col" style="width: 100px; text-align: center">Unidade</th>
                                <th scope="col" style="width: 120px; text-align: center">Preço</th>
                                <th scope="col" style="width: 120px; text-align: center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($records as $item)
                                    <tr>
                                        <th scope="row">{{ $item->produto_id }}</th>
                                        <td>{{ Str::lower($item->semana_nome) }}</td>
                                        <td>{{ $item->produto_nome }}</td>
                                        <td>{{ $item->detalhe }}</td>
                                        <td style="text-align: center">{{ ($item->af == "sim" ? "x" : "" ) }}</td>
                                        <td style="text-align: right">{{ $item->quantidade }}</td>
                                        <td style="text-align: center">{{ $item->medida_simbolo }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->preco) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->precototal) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-100">
                                    <td colspan="8" style="text-align: right"><strong>Valor R$</strong> </td> 
                                    <td style="text-align: right" >{{ mrc_turn_value($somapreco) }} </td>
                                </tr>
                                <tr class="bg-gray-100">
                                    <td colspan="8" style="text-align: right">
                                        <strong>Valor AF ({{intval(mrc_calc_percentaf($somafinal, $somaprecoaf ))}}%) R$ </strong> 
                                    </td>
                                    <td style="text-align: right" >{{ mrc_turn_value($somaprecoaf) }} </td>
                                </tr>
                                <tr class="bg-gray-100">
                                    <td colspan="8" style="text-align: right"><strong>Valor Total R$</strong> </td>
                                    <td style="text-align: right" >{{  mrc_turn_value($somafinal) }} </td>
                                </tr>
                        </tbody>
                      </table>
                      
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
