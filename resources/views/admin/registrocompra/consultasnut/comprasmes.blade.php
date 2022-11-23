@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Consultas / Compra  @if($descsemana != '') semanal  @else mensal por restaurante @endisset</h5>


    {{--Esta View é compartilhada tanto pelo Administrador como pelo Nutricionista responsável pelo restaurante atual
        Se acessada pelo ADM, exibirá o botão voltar para o "menu de consultas" do Administrador 
        Se acessada pelo NUT, exibirá formulário com campos Mês  e Ano para pesquisa das compras realizadas --}}

    @if(Auth::user()->perfil == 'adm')
        <a class="btn btn-primary" href="{{route('admin.registroconsultacompra.search')}}" role="button" style="margin-bottom: 6px;">
            <i class="fas fa-undo-alt"></i>
            Voltar
        </a>
    @else
        <form action="{{route('admin.consulta.compramensalrestaurante')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
            <div class="form-group mx-sm-3 mb-2">
                <input type="hidden" name="restaurante_id" value="{{ $restaurante->id }}">

                <select name="semana" id="semana" class="form-control">
                    <option value="" selected>Semana ...</option>
                    <option value="1" {{old('semana') == '1' ? 'selected' : ''}}>Um</option>
                    <option value="2" {{old('semana') == '2' ? 'selected' : ''}}>Dois</option>
                    <option value="3" {{old('semana') == '3' ? 'selected' : ''}}>Três</option>
                    <option value="4" {{old('semana') == '4' ? 'selected' : ''}}>Quatro</option>
                    <option value="5" {{old('semana') == '5' ? 'selected' : ''}}>Cinco</option>
                </select>
    
                &nbsp;&nbsp;&nbsp;

                <select name="mes_id" id="mes_id" class="form-control" required>
                    <option value="" selected disabled>Mês...</option>
                    @foreach($mesespesquisa as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                    @endforeach
                </select>

                &nbsp;&nbsp;&nbsp;

                <select name="ano_id" id="ano_id" class="form-control" required>
                    <option value="" selected disabled>Ano...</option>
                    @foreach($anospesquisa as $value)
                        <option value="{{ $value}}"> {{ $value }} </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
        </form>
    @endif

    <div class="card shadow mb-4">

        <div class="card-body">

            <table class="table table-sm table-bordered  table-hover">
                <thead  class="bg-gray-100">
                    <tr>
                        {{-- Forma de acessar uma propriedade antes de um "FOREACH": $records[0]->coluna --}}
                        <th colspan="4">Região: {{ $records[0]->regional_nome }} - Município: {{ $records[0]->municipio_nome }}</th>
                        <th colspan="4">{{ $records[0]->identificacao }}</th>
                        <th colspan="4" style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.comprasmes.relpdfcomprasmes', [$records[0]->restaurante_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></th>
                    </tr>
                    <tr>
                        <th colspan="4">Nutricionista Empresa: {{ $records[0]->nutricionista_nomecompleto }}</th>
                    <th colspan="4">Semana: @if($descsemana == '') todas @else {{ Str::upper($descsemana) }} @endif de {{ $descmesano }}/{{ $ano_id }}</th>
                        <th colspan="4"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Nutricionista SEDES: {{ $records[0]->user_nomecompleto }}</th>
                        <th colspan="4">De: {{ mrc_turn_data($dataInicial) }} a {{ mrc_turn_data($dataFinal) }}</th>
                        <th colspan="4"></th>
                    </tr>
                    <tr>
                        <th scope="col" style="width: 60px; text-align: center">@if($descsemana == '') semana @else N/C @endif</th>
                        <th scope="col" style="width: 40px; text-align: center">Id</th>
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
                        @foreach ($compranormal as $item)
                            <tr>
                                <td>@if($descsemana == '') {{ Str::lower($item->semana_nome) }} @else {{ $item->compra_id}}   @endif</td>
                                <th scope="row">{{ $item->produto_id }}</th>
                                <td>{{ $item->produto_nome }}</td>
                                <td>{{ $item->detalhe }}</td>
                                <td style="text-align: center">{{ ($item->af == "sim" ? "x" : "" ) }}</td>
                                <td style="text-align: right">{{ $item->quantidade }}</td>
                                <td style="text-align: center">{{ $item->medida_simbolo }}</td>
                                <td style="text-align: right">{{ mrc_turn_value($item->preco) }}</td>
                                <td style="text-align: right">{{ mrc_turn_value($item->precototal) }}</td>
                            </tr>
                        @endforeach
                        {{-- Só exibe "Compras AF" se o array não estiver vazio --}}
                        @if(count($compraaf) > 0)
                            <tr><td colspan="9"><strong>COMPRAS AF</strong></td></tr>
                            @foreach ($compraaf as $item)
                                <tr>
                                    <td>@if($descsemana == '') {{ Str::lower($item->semana_nome) }} @else {{ $item->compra_id}}   @endif</td>
                                    <th scope="row">{{ $item->produto_id }}</th>
                                    <td>{{ $item->produto_nome }}</td>
                                    <td>{{ $item->detalhe }}</td>
                                    <td style="text-align: center">{{ ($item->af == "sim" ? "x" : "" ) }}</td>
                                    <td style="text-align: right">{{ $item->quantidade }}</td>
                                    <td style="text-align: center">{{ $item->medida_simbolo }}</td>
                                    <td style="text-align: right">{{ mrc_turn_value($item->preco) }}</td>
                                    <td style="text-align: right">{{ mrc_turn_value($item->precototal) }}</td>
                                </tr>
                            @endforeach
                        @endif
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
   </div>
</div>
@endsection
