@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Compra mensal: {{ $records[0]->municipio_nome }}, {{ $mesano }} </h5>

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
                                <th colspan="3">Região: {{ $records[0]->regional_nome }} - Município: {{ $records[0]->municipio_nome }}</th>
                                <th colspan="3">Mês: {{ $mesano }} </th>
                                <th style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfcompramensalmunicipio', [$muni_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th rowspan="2" scope="col" style="width: 40px; text-align: center; vertical-align:middle">Id</th>
                                <th rowspan="2" scope="col" style="width: 500px; text-align: center; vertical-align:middle">Restaurantes</th>
                                <th rowspan="2" scope="col" style="width: 180px; text-align: center; vertical-align:middle">Ver detalhes das compras</th>
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
                                        <th scope="row">{{ $item->restaurante_id }}</th>
                                        <td>{{ $item->identificacao }}</td>
                                        {{-- Como a rota do link abaixo é originalmente acessada a partir da submissão de um formulário pelo método GET,
                                             houve a necessidade de indicar/nomear os índices dos parâmetros na rota, para que os mesmos coincidam com o que
                                             é esperado pelo método a ser executado
                                        <td style="text-align: center"><a href="{{route('admin.consulta.compramensalrestaurante', ['restaurante_id' => $item->restaurante_id, 'mes_id' => $mes_id, 'ano_id' => $ano_id])}}"><i class="fas fa-eye text-warning mr-2"></i></a></td>
                                        --}}
                                        <td style="text-align: center">
                                            <a class="verdetalhe" data-idrestaurante="{{$item->restaurante_id}}" data-idmes="{{$mes_id}}" data-idano="{{$ano_id}}"
                                                data-toggle="modal" data-target="#exampleModal{{$item->restaurante_id}}" href="#">
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
                                    <div class="modal fade" id="exampleModal{{$item->restaurante_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Compra detalhada {{ $item->identificacao }} em <span class="mesano"></span></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <span class="mensagem"></span>

                                                <div class="modal-body">

                                                    {{-- INICIO CONTEÚDO CORPO MODAL --}}
                                                    {{-- Houve a necessidade de criar uma pseudo tabela com div's porque a confeccão de uma tabela normal, exibe a 
                                                         mesma abaixo da tabela principal de dados, ou seja, era renderizada independente de se clicar no botão de
                                                         visualização. --}}
                                                    <div class="psdtable">
                                                        <div class="psdthead">
                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 55%;">Região: <span class="regional"></span> - Município: <span class="municipio"></span></div>
                                                                <div class="psdth-lt" style="width: 35%;"><span class="identificacao"></span></div>
                                                                <div class="psdth-ltr" style="width: 10%; text-align:right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.comprasmes.relpdfcomprasmes', [$item->restaurante_id, $mes_id, $ano_id]) }}" role="button" target="_blank" style="padding: 0px 3px;"><i class="far fa-file-pdf fa-sm"></i> pdf</a></div>
                                                                {{--
                                                                    Esta linha funciona perfeitamente em conjunto com o trecho de código comentado abaixo com a flag: ##LINKBTNPDF##
                                                                    <div class="psdth-ltr" style="width: 10%; text-align:right"><a class="linkbtnpdf btn btn-primary btn-danger btn-sm" data-numrestaurante="{{$item->restaurante_id}}" data-nummes="{{$mes_id}}" data-numano="{{$ano_id}}" href="" role="button" target="_blank" style="padding: 0px 3px;"><i class="far fa-file-pdf fa-sm"></i> pdf</a></div>
                                                                --}}
                                                            </div>

                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 55%;">Nutricionista Empresa:<span class="nutricionistaempresa"></span></div>
                                                                <div class="psdth-lt" style="width: 35%;">De <span class="datainicial"></span> a <span class="datafinal"></span></div>
                                                                <div class="psdth-ltr" style="width: 10%;">&nbsp;</div>
                                                            </div>

                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 55%;">Nutricionista Sedes:<span class="nutricionistasedes"></span></div>
                                                                <div class="psdth-lt" style="width: 35%;">&nbsp;</div>
                                                                <div class="psdth-ltr" style="width: 10%;">&nbsp;</div>
                                                            </div>

                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 5%; text-align: center; font-weight: bold;">Id</div>
                                                                <div class="psdth-lt" style="width: 10%; text-align: center; font-weight: bold">semana</div>
                                                                <div class="psdth-lt" style="width: 20%; text-align: center; font-weight: bold">Produto</div>
                                                                <div class="psdth-lt" style="width: 20%; text-align: center; font-weight: bold">Detalhe</div>
                                                                <div class="psdth-lt" style="width: 5%; text-align: center; font-weight: bold">AF</div>
                                                                <div class="psdth-lt" style="width: 10%; text-align: center; font-weight: bold">Quant.</div>
                                                                <div class="psdth-lt" style="width: 10%; text-align: center; font-weight: bold">Unid.</div>
                                                                <div class="psdth-lt" style="width: 10%; text-align: center; font-weight: bold">Preço</div>
                                                                <div class="psdth-ltr" style="width: 10%; text-align: center; font-weight: bold">Total</div>
                                                            </div>
                                                        </div>

                                                        <div class="psdbody">
                                                            <div class="dadosbody">

                                                            </div>
                                                        </div>

                                                        <div class="psdfooter">
                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 90%; text-align:right">Valor R$</div>
                                                                <div class="psdth-ltr" style="width: 10%; text-align:right"><span class="somapreconormal">0,00</span></div>
                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 90%; text-align:right">Valor AF (<span class="procentagemaf">0</span>%) R$</div>
                                                                <div class="psdth-ltr" style="width: 10%; text-align:right"><span class="somaprecoaf">0,00</span></div>
                                                            </div>
                                                            <div class="psdtr">
                                                                <div class="psdth-lt" style="width: 90%; text-align:right">Valor Total R$</div>
                                                                <div class="psdth-ltr" style="width: 10%; text-align:right"><span class="somaprecofinal">0,00</span></div>
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
                var idRest = $(this).data('idrestaurante');
                var idMes  = $(this).data('idmes');
                var idAno  = $(this).data('idano');


                $.ajax({
                    url:"{{route('admin.consulta.ajaxgetdetalhecompra')}}",
                    //type: "POST",
                    type: "GET",

                    data: {
                        restaurante: idRest,
                        mes: idMes,
                        ano: idAno,
                        //_token: '{{csrf_token()}}' //para requisição tipo POST
                    },
                    dataType : 'json',
                    success: function(result){
                        if(result.numregs >= 1){
                            // Exibe informações gerais
                            $(".regional").text(result.regional);
                            $(".municipio").text(result.municipio);
                            $(".identificacao").text(result.identificacao);
                            $(".nutricionistaempresa").text(result.nutricionistaempresa);
                            $(".nutricionistasedes").text(result.nutricionistasedes);
                            $(".mesano").text(result.mesano);
                            $(".datainicial").text(result.datainicial);
                            $(".datafinal").text(result.datafinal);

                            //Limpa a tabelad e dados
                            $('.dadosbody').html('');

                            // Verifica se há dados de compra normal
                            if(result.numregscompranormal > 0 ) {
                                //Itera sobre os dados retornados em data['compranormal']
                                $.each(result.compranormal,function(key,value){
                                    $(".dadosbody").append(
                                        '<div class="psdtr destaque">' +
                                            '<div class="psdtd-lt" style="width: 5%;">'+ value.produto_id +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%;">'+ value.semana_nome +'</div>' +
                                            '<div class="psdtd-lt" style="width: 20%;">'+ value.produto_nome +'</div>' +
                                            '<div class="psdtd-lt" style="width: 20%;">'+ value.detalhe +'</div>' +
                                            '<div class="psdtd-lt" style="width: 5%; text-align: center">'+ (value.af == 'sim' ? 'x' : '') +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%; text-align: right">'+ value.quantidade +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%; text-align: center">'+ value.medida_simbolo +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%; text-align: right">'+ value.preco +'</div>' +
                                            '<div class="psdtd-ltr" style="width: 10%; text-align: right">'+ value.precototal + '</div>' +
                                        '</div>'
                                    );
                                });
                                $(".somapreconormal").text(result.somapreconormal);
                            }

                            // Verifica se há dados de compra AF (Agricultura Familiar)
                            if(result.numregscompraaf > 0 ) {
                                // Cria linha que separa os tipos de compra
                                $(".dadosbody").append('<div class="psdtr"> <div class="psdtd-lt psdtd-ltr" style="width: 100%; font-weight: bold;">COMPRAS AF</div></div>');
                                //Itera sobre os dados retornados em data['compraaf']
                                $.each(result.compraaf,function(key,value){
                                    $(".dadosbody").append(
                                        '<div class="psdtr destaque">' +
                                            '<div class="psdtd-lt" style="width: 5%;">'+ value.produto_id +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%;">'+ value.semana_nome +'</div>' +
                                            '<div class="psdtd-lt" style="width: 20%;">'+ value.produto_nome +'</div>' +
                                            '<div class="psdtd-lt" style="width: 20%;">'+ value.detalhe +'</div>' +
                                            '<div class="psdtd-lt" style="width: 5%; text-align: center">'+ (value.af == 'sim' ? 'x' : '') +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%; text-align: right">'+ value.quantidade +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%; text-align: center">'+ value.medida_simbolo +'</div>' +
                                            '<div class="psdtd-lt" style="width: 10%; text-align: right">'+ value.preco +'</div>' +
                                            '<div class="psdtd-ltr" style="width: 10%; text-align: right">'+ value.precototal + '</div>' +
                                        '</div>'
                                    );
                                });
                                $(".somaprecoaf").text(result.somaprecoaf);
                                $(".procentagemaf").text(result.porcentagemaf);
                            }

                            // Exibe soma preço normal + preço AF
                            $(".somaprecofinal").text(result.somaprecofinal);

                        }else{

                            $(".mensagem").text("FALHA NO RETORNO DOS REGISTROS");
                            

                        }
                    }
                });
            });


            /*
            Este trecho de código funciona perfeitamente emm conjunto com o trecho de código comentado acima com a flag: ##LINKBTNPDF##
            $(".linkbtnpdf").on('click', function(){

                var numrestaurante = $(this).data('numrestaurante');
                var nummes = $(this).data('nummes');
                var numano = $(this).data('numano');
                
                // Montando rota para link do botão .pdf dentro da MODAL. (substituição de varios parâmetros com replace encadeado)
                var routepdf = "{{ route('admin.registroconsultacompra.comprasmes.relpdfcomprasmes', ['restaurante', 'nummes', 'numano']) }}";
                    routepdf = routepdf.replace(/restaurante/g, numrestaurante).replace(/nummes/g, nummes).replace(/numano/g, numano);

                $('.linkbtnpdf').attr('href', routepdf);
            });
            */


        });
    </script>
@endsection
