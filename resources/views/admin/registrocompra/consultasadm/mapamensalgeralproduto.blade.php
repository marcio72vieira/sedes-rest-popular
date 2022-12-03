@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Consultas / Mapa mensal GERAL de produtos adquirido por unidade: {{ $mesano }} </h5>

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
                                {{-- <th colspan="11">Regiões: @foreach ($regionaisenvolvidas as $nome) {{ $nome }}, &nbsp; @endforeach </th> --}}
                                <th colspan="11">Regiões: {{ $regionais }} </th>
                                <th colspan="2">Mês: {{ $mesano }} </th>
                                <th colspan="2" style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfmapamensalgeralproduto', [$mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th scope="col" rowspan="3" style="width: 40px; text-align: center; vertical-align:middle">Id</th>
                                <th scope="col" rowspan="3" style="width: 200px; text-align: center; vertical-align:middle">Produto</th>
                                <th scope="col" rowspan="3" style="width: 50px; text-align: center; vertical-align:middle">Und.</th>
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
                                    $somacomprapreconormal = 0;
                                    $somacomprarecoaf = 0;
                                @endphp
                                @foreach ($records as $item)
                                    <tr>
                                        <th scope="row">{{ $item->produto_id }}</th>
                                        <td>{{ $item->produto_nome }}</td>
                                        <td>{{ $item->medida_simbolo }}</td>
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
                                            $somacomprapreconormal = $somacomprapreconormal += $item->somapreconormal;
                                            $somacompraprecorecoaf = $somacomprarecoaf += $item->somaprecoaf;
                                        @endphp
                                    </tr>

                                @endforeach
                                <tr class="bg-gray-100">
                                    <td colspan="3" style="text-align: right"><strong>Totais R$</strong> </td>
                                    <td style="text-align: right"><strong></strong></td>
                                    <td style="text-align: right"><strong></strong></td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($somacomprapreconormal) }}</strong> </td>
                                    <td style="text-align: right"><strong></strong></td>
                                    <td style="text-align: right"><strong></strong></td>
                                    <td style="text-align: right"><strong></strong> </td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($somacompraprecorecoaf) }}</strong></td>
                                    <td style="text-align: right" ><strong></strong></td>
                                    <td style="text-align: right"><strong></strong></td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($somacomprapreconormal + $somacompraprecorecoaf) }}</strong></td>
                                    <td style="text-align: right" ><strong></strong></td>
                                    <td style="text-align: right" ><strong>{{ intval(mrc_calc_percentaf(($somacomprapreconormal + $somacompraprecorecoaf), $somacompraprecorecoaf))}} %</strong></td>
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
