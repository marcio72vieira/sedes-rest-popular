@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Valores comprados no mês pela região: {{ $records[0]->regional_nome }} em {{ $mesano }} </h5>

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
                                <th colspan="3">Região: {{ $records[0]->regional_nome }}</th>
                                <th colspan="3">Mês: {{ $mesano }} </th>
                                <th style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfcompramensalregiaovalor', [$reg_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th rowspan="2" scope="col" style="width: 40px; text-align: center; vertical-align:middle">Id</th>
                                <th rowspan="2" scope="col" style="width: 500px; text-align: center; vertical-align:middle">Municípios</th>
                                <th rowspan="2" scope="col" style="width: 180px; text-align: center; vertical-align:middle">Ver detalhe no município</th>
                                <th colspan="2" scope="col" style="width: 150px; text-align: center">Compras</th>
                                <th rowspan="2" scope="col" style="width: 150px; text-align: center; vertical-align:middle">% AF</th>
                                <th scope="col" style="width: 200px; text-align: center">Total R$</th>
                            </tr>
                            <tr>

                                <th scope="col" style="width: 150px; text-align: center">Normal (R$)</th>
                                <th scope="col" style="width: 150px; text-align: center">AF (R$)</th>
                                <th scope="col" style="width: 200px; text-align: center"></th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $totalsomapreconormal = 0;
                                    $totalsomaprecoaf = 0;
                                    $totalgeral = 0;

                                @endphp
                                @foreach ($records as $item)
                                    <tr>
                                        <th scope="row">{{ $item->municipio_id }}</th>
                                        <td>{{ $item->nomemunicipio }}</td>
                                        <td style="text-align: center">
                                            <a class="verdetalhe" data-idmunicipio="{{$item->municipio_id}}" data-idmes="{{$mes_id}}" data-idano="{{$ano_id}}"
                                                data-toggle="modal" data-target="#exampleModal{{$item->municipio_id}}" href="#">
                                                <i class="fas fa-eye text-warning mr-2"></i>
                                            </a>
                                        </td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somapreconormal) }}</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaprecoaf) }}</td>
                                        <td style="text-align: right">&#177; {{ intval(mrc_calc_percentaf($item->somaprecototal, $item->somaprecoaf))}} %</td>
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaprecototal) }}</td>
                                        @php
                                            $totalsomapreconormal = $totalsomapreconormal += $item->somapreconormal;
                                            $totalsomaprecoaf = $totalsomaprecoaf += $item->somaprecoaf;
                                            $totalgeral  = $totalgeral += $item->somaprecototal;
                                        @endphp
                                    </tr>

                                    {{-- INICIO MODAL --}}
                                    <!-- Button trigger modal <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Launch demo modal </button> -->
                                    <div class="modal fade" id="exampleModal{{$item->municipio_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Compras realizadas pelos restaurantes no município: {{ $item->nomemunicipio }} em <span class="mesano"></span></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <span class="mensagem"></span>

                                                <div class="modal-body">

                                                    <div class="psdtable">
                                                        <div class="psdthead">
                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 55%;">Região: <span class="regional"></span> - Município: <span class="municipio"></span></div>
                                                                <div class="psdth-lt" style="width: 34%;"><span class="mesano"></span></div>
                                                                <div class="psdth-ltr" style="width: 11%; text-align:right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfcompramensalmunicipiovalor', [$item->municipio_id, $mes_id, $ano_id]) }}" role="button" target="_blank" style="padding: 0px 3px;"><i class="far fa-file-pdf fa-sm"></i> pdf</a></div>
                                                            </div>

                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 5%; text-align: center; font-weight: bold;">Id</div>
                                                                <div class="psdth-lt" style="width: 50%; text-align: center; font-weight: bold">Restaurantes</div>
                                                                <div class="psdth-lt" style="width: 24%; text-align: center; font-weight: bold">Compras</div>
                                                                <div class="psdth-lt" style="width: 10%; text-align: center; font-weight: bold">% AF</div>
                                                                <div class="psdth-ltr" style="width: 11%; text-align: center; font-weight: bold">Total R$</div>
                                                            </div>

                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 5%; text-align: center; font-weight: bold;"></div>
                                                                <div class="psdth-lt" style="width: 50%; text-align: center; font-weight: bold"></div>
                                                                <div class="psdth-lt" style="width: 12%; text-align: center; font-weight: bold">Normal (R$)</div>
                                                                <div class="psdth-lt" style="width: 12%; text-align: center; font-weight: bold">AF (R$)</div>
                                                                <div class="psdth-lt" style="width: 10%; text-align: center; font-weight: bold"></div>
                                                                <div class="psdth-ltr" style="width: 11%; text-align: center; font-weight: bold"></div>
                                                            </div>
                                                        </div>

                                                        <div class="psdbody">
                                                            <div class="dadosbody">

                                                            </div>
                                                        </div>

                                                        <div class="psdfooter">
                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 55%; text-align:right"><strong>Totais R$</strong></div>
                                                                <div class="psdth-lt" style="width: 12%; text-align:right"><strong><span class="totaispreconormal"></span></strong></div>
                                                                <div class="psdth-lt" style="width: 12%; text-align:right"><strong><span class="totaisprecoaf"></span></strong></div>
                                                                <div class="psdth-lt" style="width: 10%; text-align:right"><strong>&#177; <span class="totaispercentagem"></span>%</strong></div>
                                                                <div class="psdth-ltr" style="width: 11%; text-align:right"><strong><span class="totaissomaprecototal"></span></strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- FIM CONTEÚDO CORPO MODAL --}}

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- FIM MODAL--}}

                                @endforeach
                                <tr class="bg-gray-100">
                                    <td colspan="3" style="text-align: right"><strong>Totais R$</strong> </td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalsomapreconormal) }}</strong> </td>
                                    <td style="text-align: right"><strong>{{ mrc_turn_value($totalsomaprecoaf) }}</strong> </td>
                                    <td style="text-align: right"><strong>&#177;  {{ intval(mrc_calc_percentaf($totalgeral, $totalsomaprecoaf))}} %</strong> </td>
                                    <td style="text-align: right" ><strong>{{ mrc_turn_value($totalgeral) }}</strong></td>
                                </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function(){
            $('#myTable').on('click', '.verdetalhe', function(){

                // Dados a serem passados para a requisição AJAX (visualização detalhada da compra na MODAL)
                var idMuni = $(this).data('idmunicipio');
                var idMes  = $(this).data('idmes');
                var idAno  = $(this).data('idano');


                $.ajax({
                    url:"{{route('admin.consulta.ajaxgetdetalhecompramensalregiaovalor')}}",
                    //type: "POST",
                    type: "GET",

                    data: {
                        municipio: idMuni,
                        mes: idMes,
                        ano: idAno,
                        //_token: '{{csrf_token()}}' //para requisição tipo POST
                    },
                    dataType : 'json',

                    success: function(result){
                            //Obs:  result recebe o valor do array $data, vindo com dois índices, data['mesano'] que só possui um valor e
                            //      data['records'] que é um outro array (a collection vindo do banco de dados) em resposta à solicitação
                            //      AJAX (return response()->json($data) no controller.

                            // Exibe informações gerais
                            $(".regional").text(result['records'][0].regional_nome);        // poderia ser: result['records'][1].regional_nome
                            $(".municipio").text(result['records'][0].municipio_nome);      // poderia ser: result['records'][1].municipio_nome
                            $(".mesano").text(result['mesano']);

                            //Limpa a tabelad e dados
                            $('.dadosbody').html('');

                            let totaispreconormal = parseFloat(0);
                            let totaisprecoaf = parseFloat(0);
                            let totaispercentagem = parseFloat(0);
                            let totaissomaprecototal = parseFloat(0);

                            //Iterando apenas no conjunto de dados vindo do banco, pela collection $records
                            $.each(result['records'], function(key,value){

                                let percentagem = parseInt((value.somaprecoaf * 100)/value.somaprecototal);

                                $(".dadosbody").append(
                                    '<div class="psdtr destaque">' +
                                        '<div class="psdtd-lt" style="width: 5%;">'+ value.restaurante_id +'</div>' +
                                        '<div class="psdtd-lt" style="width: 50%;">'+ value.identificacao +'</div>' +
                                        '<div class="psdtd-lt" style="width: 12%; text-align: right">'+ value.somapreconormal +'</div>' +
                                        '<div class="psdtd-lt" style="width: 12%; text-align: right">'+ value.somaprecoaf +'</div>' +
                                        '<div class="psdtd-lt" style="width: 10%; text-align: right">&#177; '+ percentagem +'%</div>' +
                                        '<div class="psdtd-ltr" style="width: 11%; text-align: right">'+ value.somaprecototal + '</div>' +
                                    '</div>'
                                );

                                //Efetuando o somatório dos totais e cálculo da percentagem total
                                totaispreconormal = parseFloat(totaispreconormal) + parseFloat(value.somapreconormal);
                                totaisprecoaf = parseFloat(totaisprecoaf) + parseFloat(value.somaprecoaf);
                                totaissomaprecototal = parseFloat(totaissomaprecototal) + parseFloat(value.somaprecototal);
                                totaispercentagem = parseInt((totaisprecoaf * 100)/totaissomaprecototal);

                            });

                            $(".totaispreconormal").text(totaispreconormal.toFixed(2));
                            $(".totaisprecoaf").text(totaisprecoaf.toFixed(2));
                            $(".totaissomaprecototal").text(totaissomaprecototal.toFixed(2));
                            $(".totaispercentagem").text(totaispercentagem);


                            // Exibe soma preço normal + preço AF
                            $(".somaprecofinal").text(result.somaprecofinal);
                    }
                });
            });

        });
    </script>
@endsection
