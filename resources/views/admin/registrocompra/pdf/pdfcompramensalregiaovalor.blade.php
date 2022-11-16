<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Compra mensal região valor</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">
        @php 
            $totalnormal = 0;
            $totalaf = 0;
            $totalgeral = 0;
        @endphp
        @foreach ($records as $item)
            <tr @if($loop->even) style="background-color: #e3e3e3;"; $par = 1;  @endif>
                <td style="width: 30px;" class="dados-lista">{{ $item->municipio_id }}</td>
                <td style="width: 387px;" class="dados-lista">{{$item->nomemunicipio}}</td>
                <td style="width: 80px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somapreconormal) }}</td>
                <td style="width: 80px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaprecoaf) }}</td>
                <td style="width: 60px; text-align: right" class="dados-lista">&#177; {{ intval(mrc_calc_percentaf($item->somaprecototal, $item->somaprecoaf))}} %</td>
                <td style="width: 80px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaprecototal) }}</td>
                @php 
                    $totalnormal = $totalnormal += $item->somapreconormal;
                    $totalaf = $totalaf += $item->somaprecoaf;
                    $totalgeral  = $totalgeral += $item->somaprecototal; 
                
                @endphp
            </tr>
            {{-- Evita que as linhas de totais sejam quebradas em duas páginas quando próxima da margem inferior
            @if($loop->iteration  == 37 && $compranormal->count() == 37)
                <tr><td colspan= "8" style="width: 717px">&nbsp;</td></tr>
            @endif --}}
        @endforeach
    </table>
    <table  style="width: 717px; border-collapse: collapse; margin-top:3px;">
        <tr>
            <td style="width: 417px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>Valor Total R$</strong></td>
            <td style="width: 80px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalnormal) }}</td>
            <td style="width: 80px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalaf) }}</strong></td>
            <td style="width: 60px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>&#177; {{ intval(mrc_calc_percentaf($totalgeral, $totalaf))}} %</strong></td>
            <td style="width: 80px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom" ><strong>{{ mrc_turn_value($totalgeral) }}</td>
        </tr>
    </table>

</body>
</html>

