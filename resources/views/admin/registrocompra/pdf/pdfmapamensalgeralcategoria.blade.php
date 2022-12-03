<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Mapa mensal geral de produtos adquiridos por categorias em unidade</title>
</head>


<body>
    <table style="width: 1080px; border-collapse: collapse;">
        @php
            $somacomprapreconormal = 0;
            $somacomprarecoaf = 0;
        @endphp
        @foreach ($records as $item)
            <tr @if($loop->even) style="background-color: #e3e3e3;"; $par = 1;  @endif>
                <td style="width: 40px;" class="dados-lista">{{ $item->categoria_id }}</th>
                <td style="width: 280px;" class="dados-lista">{{ $item->categoria_nome }}</td>
                <td style="width: 40px;" class="dados-lista">{{ $item->medida_simbolo }}</td>
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
                    $somacomprapreconormal = $somacomprapreconormal += $item->somapreconormal;
                    $somacompraprecorecoaf = $somacomprarecoaf += $item->somaprecoaf;
                @endphp
            </tr>
            {{-- Evita que as linhas de totais sejam quebradas em duas páginas quando próxima da margem inferior
            @if($loop->iteration  == 37 && $compranormal->count() == 37)
                <tr><td colspan= "8" style="width: 717px">&nbsp;</td></tr>
            @endif --}}
        @endforeach
    </table>
    <table  style="width: 1080px; border-collapse: collapse; margin-top:3px;">
        <tr>
            <tr class="bg-gray-100">
                <td colspan="3" style="width: 360px; text-align: right;  padding: 3px;" class="dados-box-top dados-box-bottom"><strong>Totais R$</strong> </td>
                <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($somacomprapreconormal) }}</strong> </td>
                <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong> </td>
                <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($somacompraprecorecoaf) }}</strong></td>
                <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ mrc_turn_value($somacomprapreconormal + $somacompraprecorecoaf) }}</strong></td>
                <td style="width: 50px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong></strong></td>
                <td style="width: 70px; text-align: right; padding: 3px;" class="dados-box-top dados-box-bottom"><strong>{{ intval(mrc_calc_percentaf(($somacomprapreconormal + $somacompraprecorecoaf), $somacompraprecorecoaf))}} %</strong></td>
            </tr>
        </tr>
    </table>
</body>
</html>
