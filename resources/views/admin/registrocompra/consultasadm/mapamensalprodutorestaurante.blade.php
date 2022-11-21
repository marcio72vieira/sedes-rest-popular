@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Consultas / Mapa de produtos adquirido por unidade no restaurante: {{ $records[0]->identificacao }} - {{ $mesano }} </h5>

    <a class="btn btn-primary" href="{{route('admin.registroconsultacompra.search')}}" role="button" style="margin-bottom: 6px;">
        <i class="fas fa-undo-alt"></i>
        Voltar
    </a>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="jan" role="tabpanel" aria-labelledby="janeiro-tab">
                    <table id="myTable" class="table table-sm table-bordered  table-hover">
                        <thead  class="bg-gray-100">
                            <tr>
                                {{-- Forma de acessar uma propriedade antes de um "FOREACH": $records[0]->coluna --}}
                                <th colspan="4">Região: {{ $records[0]->regional_nome }} - Município: {{ $records[0]->municipio_nome }}</th>
                                <th colspan="4">{{ $records[0]->identificacao }} </th>
                                <th colspan="2">Mês: {{ $mesano }} </th>
                                {{--<th style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfcompramensalmunicipiovalor', [$rest_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>--}}
                                <th style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th scope="col" rowspan="3" style="width: 40px; text-align: center; vertical-align:middle">Id</th>
                                <th scope="col" rowspan="3" style="width: 100px; text-align: center; vertical-align:middle">Produto</th>
                                <th scope="col" rowspan="3" style="width: 100px; text-align: center; vertical-align:middle">Unidade</th>
                                <th colspan="4" scope="col" style="width: 100px; text-align: center; vertical-align:middle">COMPRAS</th>
                                <th colspan="2" rowspan="2" scope="col" style="width: 100px; text-align: center; vertical-align:middle">TOTAL</th>
                                <th colspan="2" rowspan="2" scope="col" style="width: 100px; text-align: center; vertical-align:middle"> &#177; (%) AF</th>
                            </tr>
                            <tr>
                                
                                <th colspan="2" scope="col" style="width: 100px; text-align: center; vertical-align:middle">Normal</th>
                                <th colspan="2" scope="col" style="width: 100px; text-align: center; vertical-align:middle">AF</th>
                            </tr>
                            <tr>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Quantidade</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor (R$)</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Quantidade</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor (R$)</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Quantidade</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor (R$)</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Quantidade</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                                @php
                                    $somacomprapreconormal = 0;
                                    $somacomprarecoaf = 0;
                                @endphp
                                @foreach ($records as $item)
                                    <tr>
                                        <th scope="row">{{ $item->produto_id }}</th>
                                        <td>{{ $item->produto_nome }}</td>
                                        <td>{{ $item->medida_simbolo }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaquantidadenormal) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somapreconormal) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaquantidadeaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaprecoaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaquantidadenormal + $item->somaquantidadeaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somapreconormal + $item->somaprecoaf) }}</td>
                                        <td style="text-align: right">{{ intval(mrc_calc_percentaf(($item->somaquantidadenormal + $item->somaquantidadeaf), $item->somaquantidadeaf))}} %</td>
                                        <td style="text-align: right">{{ intval(mrc_calc_percentaf(($item->somapreconormal + $item->somaprecoaf), $item->somaprecoaf))}} %</td>
                                        @php
                                            $somacomprapreconormal = $somacomprapreconormal += $item->somapreconormal;
                                            $somacompraprecorecoaf = $somacomprarecoaf += $item->somaprecoaf;
                                        @endphp
                                    </tr>

                                @endforeach
                                <tr class="bg-gray-100">
                                    <td colspan="3" style="text-align: right"><strong>Totais R$</strong> </td>
                                    <td style="text-align: right"><strong></strong></td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($somacomprapreconormal) }}</strong> </td>
                                    <td style="text-align: right"><strong></strong> </td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($somacompraprecorecoaf) }}</strong></td>
                                    <td style="text-align: right" ><strong></strong></td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($somacomprapreconormal + $somacompraprecorecoaf) }}</strong></td>
                                    <td style="text-align: right" ><strong></strong></td>
                                    <td style="text-align: right" ><strong>{{ intval(mrc_calc_percentaf(($somacomprapreconormal + $somacompraprecorecoaf), $somacompraprecorecoaf))}} %</strong></td>
                                </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection
