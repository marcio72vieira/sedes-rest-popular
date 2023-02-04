<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Comparativo mensal geral de categoria</title>
</head>


<body>
    <table style="width: 1080px; border-collapse: collapse;">
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
            <tr @if($loop->even) style="background-color: #e3e3e3;"; $par = 1;  @endif>
                <td style="width: 40px;" class="dados-lista">{{ $item->regional_id }}</th>
                <td style="width: 320px;" class="dados-lista">{{ $item->regional_nome }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ $item->numvezesnormal }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaquantidadenormal) }}</td>
                <td style="width: 70px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somapreconormal) }}</td>
                <td style="width: 70px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->mediapreconormal) }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ $item->numvezesaf }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaquantidadeaf) }}</td>
                <td style="width: 70px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaprecoaf) }}</td>
                <td style="width: 70px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->mediaprecoaf) }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somaquantidadenormal + $item->somaquantidadeaf) }}</td>
                <td style="width: 70px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->somapreconormal + $item->somaprecoaf) }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{ intval(mrc_calc_percentaf(($item->somaquantidadenormal + $item->somaquantidadeaf), $item->somaquantidadeaf))}} %</td>
                <td style="width: 70px; text-align: right" class="dados-lista">{{ intval(mrc_calc_percentaf(($item->somapreconormal + $item->somaprecoaf), $item->somaprecoaf))}} %</td>
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
            {{-- Evita que as linhas de totais sejam quebradas em duas páginas quando próxima da margem inferior
            @if($loop->iteration  == 37 && $compranormal->count() == 37)
                <tr><td colspan= "8" style="width: 717px">&nbsp;</td></tr>
            @endif --}}
        @endforeach
    </table>
    <table  style="width: 1080px; border-collapse: collapse; margin-top:3px;">
        <tr class="bg-gray-100">
            <td colspan="3" style="width: 360px; text-align: right;  padding: 3px;" class="dados-box-top dados-box-bottom"><strong>Totais R$</strong> </td>
            <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ $totalcompranumvezesnormal }}</strong></td>
            <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalcompraquantidadenormal) }}</strong></td>
            <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalcomprapreconormal) }}</strong> </td>
            <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalsomaprecounitarionormal / ($totalcompranumvezesnormal == 0 ? 1 : $totalcompranumvezesnormal)) }}</strong></td>
            <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ $totalcompranumvezesaf }}</strong></td>
            <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalcompraquantidadeaf) }}</strong></td>
            <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalcompraprecoaf) }}</strong></td>
            <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalsomaprecounitarioaf / ($totalcompranumvezesaf == 0 ? 1 : $totalcompranumvezesaf)) }}</strong></td>
            <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalcompraquantidadenormal + $totalcompraquantidadeaf) }}</strong></td>
            <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($totalcomprapreconormal + $totalcompraprecoaf) }}</strong></td>
            <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ intval(mrc_calc_percentaf(($totalcompraquantidadenormal + $totalcompraquantidadeaf), $totalcompraquantidadeaf))}} %</strong></td>
            <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ intval(mrc_calc_percentaf(($totalcomprapreconormal + $totalcompraprecoaf), $totalcompraprecoaf))}} %</strong></td>
        </tr>
    </table>
</body>
</html>
