@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Produção Mês: {{ $records[0]->identificacao }}</h5>

    <a class="btn btn-primary" href="{{route('admin.registroconsulta.search')}}" role="button" style="margin-bottom: 6px;">
        <i class="fas fa-undo-alt"></i>
        Voltar
    </a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="jan" role="tabpanel" aria-labelledby="janeiro-tab">
                    <table class="table table-sm table-bordered  table-hover">
                        <thead  class="bg-gray-100">
                            <tr>
                                {{-- Forma de acessar uma propriedade antes de um "FOREACH": $records[0]->coluna --}}
                                <th colspan="4">Região: {{ $records[0]->regional_nome }} - Município: {{ $records[0]->municipio_nome }}</th>
                                <th colspan="4">{{ $records[0]->identificacao }}</th>
                                <th colspan="4" style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th colspan="4">Nutricionista Empresa: {{ $records[0]->nutricionista_nomecompleto }}</th>
                                <th colspan="4">Mês: OUTUBRO/2022 </th>
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
                                <th scope="col" style="width: 120px; text-align: center">Preço Médio</th>
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
                                        <td style="text-align: right">{{ $item->somaquantidade }}</td>
                                        <td style="text-align: center">{{ $item->medida_simbolo }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->mediapreco) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaprecototal) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-100">
                                    <td colspan="8" style="text-align: right"><strong>Valor R$</strong> </td> 
                                    <td style="text-align: right" ></td>
                                </tr>
                                <tr class="bg-gray-100">
                                    <td colspan="8" style="text-align: right">
                                        <strong>Valor AF (%) R$ </strong> 
                                    </td>
                                    <td style="text-align: right" ></td>
                                </tr>
                                <tr class="bg-gray-100">
                                    <td colspan="8" style="text-align: right"><strong>Valor Total R$</strong> </td>
                                    <td style="text-align: right" > </td>
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
