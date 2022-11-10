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
                                <th colspan="2">Região: {{ $records[0]->regional_nome }} - Município: {{ $records[0]->municipio_nome }}</th>
                                <th>Mês: {{ $mesano }} </th>
                                <th style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.relpdfcompramensalmunicipio', [$muni_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                            </tr>
                            <tr>
                                <th scope="col" style="width: 40px; text-align: center">Id</th>
                                <th scope="col" style="width: 800px; text-align: center">Restaurante</th>
                                <th scope="col" style="width: 180px; text-align: center">Visualizar</th>
                                <th scope="col" style="width: 200px; text-align: center">Valor Comprado R$</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php $totalgeral = 0 @endphp
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
                                        <td style="text-align: right">{{ mrc_turn_value($item->somaprecototal) }}</td>
                                        @php $totalgeral  = $totalgeral += $item->somaprecototal; @endphp
                                    </tr>

                                    {{-- INICIO MODAL --}}
                                    <!-- Button trigger modal <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Launch demo modal </button> -->
                                    <div class="modal fade" id="exampleModal{{$item->restaurante_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Compra detalhada {{ $item->identificacao }} em <span id="mesano"></span></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <span class="mensagem"></span>

                                                <div class="modal-body">
                                                {{-- INICIO CORPO MODAL --}}
                                            

<div id="psdtable" style="float: left; width: 100%;">
    <div class="psdthead">
        <div class="psdtr" style="float:left; width:100%;">
            <div class="psdth" style="float: left; width: 55%; height: 40px; border: 1px solid #c9bdbd">Região: <span class="regional"></span> - Município: <span class="municipio"></span></div>
            <div class="psdth" style="float: left; width: 35%; height: 40px; border: 1px solid #c9bdbd"><span class="identificacao"></span></div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.comprasmes.relpdfcomprasmes', [$records[0]->restaurante_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i>pdf</a></div>
        </div>

        <div class="psdtr" style="float:left; width:100%">
            <div class="psdth" style="float: left; width: 55%; height: 40px; border: 1px solid #c9bdbd">Nutricionista Empresa:<span class="nutricionistaempresa"></span></div>
            <div class="psdth" style="float: left; width: 35%; height: 40px; border: 1px solid #c9bdbd">De <span class="datainicial"></span> a <span class="datafinal"></span></div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">&nbsp;</div>
        </div>

        <div class="psdtr" style="float:left; width:100%">
            <div class="psdth" style="float: left; width: 55%; height: 40px; border: 1px solid #c9bdbd">Nutricionista Sedes:<span class="nutricionistasedes"></span></div>
            <div class="psdth" style="float: left; width: 35%; height: 40px; border: 1px solid #c9bdbd">&nbsp;</div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">&nbsp;</div>
        </div>

        <div class="psdtr" style="float:left; width:100%">
            <div class="psdth" style="float: left; width: 5%; height: 40px; border: 1px solid #c9bdbd">Id</div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">semana</div>
            <div class="psdth" style="float: left; width: 20%; height: 40px; border: 1px solid #c9bdbd">Produto</div>
            <div class="psdth" style="float: left; width: 20%; height: 40px; border: 1px solid #c9bdbd">Detalhe</div>
            <div class="psdth" style="float: left; width: 5%; height: 40px; border: 1px solid #c9bdbd">AF</div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">Quant.</div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">Unid.</div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">Preço</div>
            <div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">Total</div>
        </div>

        <div class="psdtr dadostabela" style="float:left; width:100%">
            
        </div>

    </div>
    
</div>


       



                                                {{-- FIM CORPO MODAL --}}
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
                                    <td colspan="3" style="text-align: right"><strong>Valor Total R$</strong> </td>
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
 
                            $(".regional").text(result.regional);
                            $(".municipio").text(result.municipio);
                            $(".identificacao").text(result.identificacao);
                            $(".nutricionistaempresa").text(result.nutricionistaempresa);
                            $(".nutricionistasedes").text(result.nutricionistasedes);

                            $("#mesano").text(result.mesano);
                            $(".datainicial").text(result.datainicial);
                            $(".datafinal").text(result.datafinal);
                            $("button[type=submit]").hide();
                            

                            $.each(result.records,function(key,value){

                                $(".dadostabela").append(
                                    
                                    '<div class="psdtr" style="float:left; width:100%">' +
                                        '<div class="psdth" style="float: left; width: 5%; height: 40px; border: 1px solid #c9bdbd">'+ value.produto_id +'</div>' +
                                        '<div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">'+ value.semana_nome +'</div>' +
                                        '<div class="psdth" style="float: left; width: 20%; height: 40px; border: 1px solid #c9bdbd">'+ value.produto_nome +'</div>' +
                                        '<div class="psdth" style="float: left; width: 20%; height: 40px; border: 1px solid #c9bdbd">'+ value.detalhe +'</div>' +
                                        '<div class="psdth" style="float: left; width: 5%; height: 40px; border: 1px solid #c9bdbd">'+ value.af +'</div>' +
                                        '<div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">'+ value.quantidade +'</div>' +
                                        '<div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">'+ value.medida_simbolo +'</div>' +
                                        '<div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">'+ value.preco +'</div>' +
                                        '<div class="psdth" style="float: left; width: 10%; height: 40px; border: 1px solid #c9bdbd">'+ value.precototal + '</div>' +
                                    '</div>'
                                );
                            });

                        }else{
                            $("button[type=submit]").show();
                            $(".mensagem").text("FALHA NO RETORNO DOS REGISTROS");
                        }
                    }
                });
            });

        });
    </script>
@endsection
