@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Consultas / Comparativo mensal Geral de produto adquirido: {{ $mesano }} </h5>

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
                                <th colspan="3">Região: Todas as Regionais </th>
                                <th colspan="8">Produto: {{ Str::upper($records[0]->produto_nome) }} ({{ Str::upper($records[0]->medida_simbolo) }})</th>
                                <th colspan="2">Mês:{{ $mesano }}</th>
                                <th colspan="2" style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfcomparativomensalgeralproduto', [$prod_id, $medi_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th scope="col" rowspan="3" style="width: 40px; text-align: center; vertical-align:middle">Id</th>
                                <th colspan="2" rowspan="3" scope="col"  style="width: 200px; text-align: center; vertical-align:middle">Regionais</th>
                                <th colspan="8" scope="col" style="width: 100px; text-align: center; vertical-align:middle">COMPRAS</th>
                                <th colspan="2" rowspan="2" scope="col" style="width: 100px; text-align: center; vertical-align:middle">TOTAL</th>
                                <th colspan="2" rowspan="2" scope="col" style="width: 100px; text-align: center; vertical-align:middle"> &#177; (%) AF</th>
                            </tr>
                            <tr>

                                <th colspan="4" scope="col" style="width: 100px; text-align: center; vertical-align:middle">Normal</th>
                                <th colspan="4" scope="col" style="width: 100px; text-align: center; vertical-align:middle">AF</th>
                            </tr>
                            <tr>
                                <th scope="col" style="width: 50px; text-align: center; vertical-align:middle">nº vz</th>
                                <th scope="col" style="width: 60px; text-align: center; vertical-align:middle">Qtd.</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor (R$)</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">p.m (R$)</th>
                                <th scope="col" style="width: 50px; text-align: center; vertical-align:middle">nº vz</th>
                                <th scope="col" style="width: 60px; text-align: center; vertical-align:middle">Qtd.</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor (R$)</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">p.m (R$)</th>
                                <th scope="col" style="width: 60px; text-align: center; vertical-align:middle">Qtd.</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">Valor (R$)</th>
                                <th scope="col" style="width: 60px; text-align: center; vertical-align:middle">% Qtd.</th>
                                <th scope="col" style="width: 100px; text-align: center; vertical-align:middle">% Valor (R$)</th>
                            </tr>

                        </thead>
                        <tbody>
                                @php
                                    $totalcompranumvezesnormal = 0;
                                    $totalcompraquantidadenormal = 0;
                                    $totalcomprapreconormal = 0;
                                    $totalsomaprecounitarionormal = 0;

                                    $totalcompranumvezesaf = 0;
                                    $totalcompraquantidadeaf = 0;
                                    $totalcompraprecoaf = 0;
                                    $totalsomaprecounitarioaf = 0;
                                @endphp
                                @foreach ($records as $item)
                                    <tr>
                                        <th scope="row">{{ $item->regional_id }}</th>
                                        <td colspan="2">{{ $item->regional_nome }}</td>
                                        <td style="text-align: right">{{ $item->numvezesnormal }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaquantidadenormal) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somapreconormal) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->mediapreconormal) }}</td>
                                        <td style="text-align: right">{{ $item->numvezesaf }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaquantidadeaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaprecoaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->mediaprecoaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaquantidadenormal + $item->somaquantidadeaf) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somapreconormal + $item->somaprecoaf) }}</td>
                                        <td style="text-align: right">{{ intval(mrc_calc_percentaf(($item->somaquantidadenormal + $item->somaquantidadeaf), $item->somaquantidadeaf))}} %</td>
                                        <td style="text-align: right">{{ intval(mrc_calc_percentaf(($item->somapreconormal + $item->somaprecoaf), $item->somaprecoaf))}} %</td>
                                        @php
                                            $totalcompranumvezesnormal = $totalcompranumvezesnormal += $item->numvezesnormal;
                                            $totalcompraquantidadenormal = $totalcompraquantidadenormal += $item->somaquantidadenormal;
                                            $totalcomprapreconormal = $totalcomprapreconormal += $item->somapreconormal;
                                            $totalsomaprecounitarionormal = $totalsomaprecounitarionormal += $item->somaprecounitarionormal;

                                            $totalcompranumvezesaf = $totalcompranumvezesaf += $item->numvezesaf;
                                            $totalcompraquantidadeaf = $totalcompraquantidadeaf += $item->somaquantidadeaf;
                                            $totalcompraprecoaf = $totalcompraprecoaf += $item->somaprecoaf;
                                            $totalsomaprecounitarioaf = $totalsomaprecounitarioaf += $item->somaprecounitarioaf;
                                        @endphp
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-100">
                                    <td colspan="3" style="text-align: right"><strong>Totais R$</strong></td>
                                    <td style="text-align: right"><strong>{{ $totalcompranumvezesnormal }}</strong></td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalcompraquantidadenormal) }}</strong></td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalcomprapreconormal) }}</strong> </td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalsomaprecounitarionormal / $totalcompranumvezesnormal ) }}</strong></td>
                                    <td style="text-align: right"><strong>{{ $totalcompranumvezesaf }}</strong></td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalcompraquantidadeaf) }}</strong></td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($totalcompraprecoaf) }}</strong></td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($totalsomaprecounitarioaf / $totalcompranumvezesaf ) }}</strong></td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalcompraquantidadenormal + $totalcompraquantidadeaf) }}</strong></td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($totalcomprapreconormal + $totalcompraprecoaf) }}</strong></td>
                                    <td style="text-align: right" ><strong>{{ intval(mrc_calc_percentaf(($totalcompraquantidadenormal + $totalcompraquantidadeaf), $totalcompraquantidadeaf))}} %</strong></td>
                                    <td style="text-align: right" ><strong>{{ intval(mrc_calc_percentaf(($totalcomprapreconormal + $totalcompraprecoaf), $totalcompraprecoaf))}} %</strong></td>
                                </tr>
                        </tbody>
                    </table>
                    <div>
                        <span style="margin-right: 50px">Und. = unidade de medida;</span>
                        <span style="margin-right: 50px">nº vz = número de vezes comprado;</span>
                        <span style="margin-right: 50px">Qtd. = quantidade comprada;</span>
                        <span style="margin-right: 50px">p.m = preço médio;</span>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection
