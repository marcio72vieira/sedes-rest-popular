<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Compra mensal município</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">
        @php $totalgeral = 0 @endphp
        @foreach ($records as $item)
            <tr @if($loop->even) style="background-color: #e3e3e3;"; $par = 1;  @endif>
                <td style="width: 30px;" class="dados-lista">{{ $item->produto_id }}</td>
                <td style="width: 200px;" class="dados-lista">{{$item->produto_nome}}</td>
                <td style="width: 235px;" class="dados-lista">{{ $item->numvezescomprado }} vezes no mês</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ $item->somaquantidade }}</td>
                <td style="width: 50px; text-align: center" class="dados-lista">{{ $item->medida_simbolo }}</td>
                <td style="width: 72px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->mediapreco) }}</td>
                <td style="width: 80px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaprecototal) }}</td>
                @php $totalgeral  = $totalgeral += $item->somaprecototal; @endphp
            </tr>
            {{-- Evita que as linhas de totais sejam quebradas em duas páginas quando próxima da margem inferior
            @if($loop->iteration  == 37 && $compranormal->count() == 37)
                <tr><td colspan= "8" style="width: 717px">&nbsp;</td></tr>
            @endif --}}
        @endforeach
    </table>
    <table  style="width: 717px; border-collapse: collapse; margin-top:3px;">
        <tr>
            <td style="width: 637px; text-align: right" class="dados-box-top dados-box-bottom"><strong>Valor Total R$</strong> </td>
            <td style="width: 80px; text-align: right" class="dados-box-top dados-box-bottom" ><strong>{{ mrc_turn_value($totalgeral) }}</td>
        </tr>
    </table>

</body>
</html>

