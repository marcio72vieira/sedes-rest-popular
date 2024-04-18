<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES</title>
</head>


<body style="vertical-align:baseline">

    <table style="width: 550px; border-collapse: collapse;  border: 0.1px solid #b1aeae;  margin: auto;">
        @php
            $linhatotalnormalaf = 0;
            $linhapercentagemnormal = 0;
            $linhapercentagemaf = 0;

            $somageralcompranormal = 0;
            $somageralcompraaf = 0;
            $somageraltotalnormalaf = 0;

            $percentagemgeralnormal = 0;
            $percentagemgeralaf = 0;
        @endphp


        @foreach ($records as $record)

            {{-- Usado para depuração no blade: @dd($record); --}}

            @php
                // Cálculo das percentagens. Evitando divisão por zero
                $linhacompranormal = $record->compranormal;
                $linhacompraaf = $record->compraaf;

                $linhatotalnormalaf = $linhacompranormal + $linhacompraaf;

                if($linhatotalnormalaf != 0){
                    $linhapercentagemnormal = (($linhacompranormal * 100)/$linhatotalnormalaf);
                    $linhapercentagemaf = (($linhacompraaf * 100)/$linhatotalnormalaf);
                }else {
                    $linhapercentagemnormal = 0;
                    $linhapercentagemaf = 0;
                }

                // Caso o registro não possua dados, o mesmo não é exibido, evitando a poluição do relatório com dados vazio
                // O teste é feito em cima da linha total geral, porque esse já engloba os valores somados de normal e af
                // Esta condição só deverá ser utilizada, caso as condições no controller [(->whereMonth("data_ini", "=",  $mesRef) e (->whereMonth("bigtable_data.data_ini", "=",  $mesRef)] forem retiradas
                // if($linhatotalnormalaf == 0){
                //     continue;
                // }

            @endphp

            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 30px;" class="dados-lista-monitor-mensal">&nbsp;{{ $record->id }}</td>
                <td style="width: 200px;" class="dados-lista-monitor-mensal">{{ $record->nomeentidade }}</td>
                <td style="width: 70px;" class="dados-lista-valor-monitor-mensal">{{ $record->compranormal == 0 ? "" : number_format($record->compranormal, "2", ",", ".") }}</td>
                <td style="width: 70px;" class="dados-lista-valor-monitor-mensal">{{ $record->compraaf     == 0 ? "" : number_format($record->compraaf, "2", ",", ".") }}</td>
                <td style="width: 80px;" class="dados-lista-valor-monitor-mensal">{{ $linhatotalnormalaf   == 0 ? "" : number_format($linhatotalnormalaf, "2", ",", ".") }}</td>
                <td style="width: 50px;" class="dados-lista-valor-monitor-mensal">{{ $linhapercentagemnormal == 0 ? "" : number_format($linhapercentagemnormal, "2", ",", ".") }}</td>
                <td style="width: 50px;" class="dados-lista-valor-monitor-mensal">{{ $linhapercentagemaf     == 0 ? "" : number_format($linhapercentagemaf, "2", ",", ".") }}</td>
            </tr>
            @php
                // Cálculo dos totais parciais normal e af dos meses
                $somageralcompranormal = $somageralcompranormal + $record->compranormal;
                $somageralcompraaf = $somageralcompraaf + $record->compraaf;
                $somageraltotalnormalaf = $somageraltotalnormalaf + $linhatotalnormalaf;
            @endphp
        @endforeach

        @php
            // Cálculo das percentagens totais. Evitando divisão por zero
            if($somageraltotalnormalaf != 0){
                $percentagemgeralnormal = (($somageralcompranormal * 100)/$somageraltotalnormalaf);
                $percentagemgeralaf = (($somageralcompraaf * 100)/$somageraltotalnormalaf);
            }else {
                $percentagemgeralnormal = 0;
                $percentagemgeralaf = 0;
            }
        @endphp

        <tr>
            {{--<td style="width: 25px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor-mensal"></td> --}}
            <td colspan="2" style="width: 230px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor-mensal">&nbsp;&nbsp;TOTAL GERAL</td>
            <td style="width: 70px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor-mensal">{{ $somageralcompranormal == 0 ? "" : number_format($somageralcompranormal, "2", ",", ".")}}</td>
            <td style="width: 70px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor-mensal">{{ $somageralcompraaf == 0 ? "" : number_format($somageralcompraaf, "2", ",", ".")}}</td>
            <td style="width: 80px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor-mensal">{{ $somageraltotalnormalaf == 0 ? "" : number_format($somageraltotalnormalaf, "2", ",", ".") }}</td>
            <td style="width: 50px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor-mensal">{{ $percentagemgeralnormal == 0 ? "" : number_format($percentagemgeralnormal, "2", ",", ".") }}</td>
            <td style="width: 50px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor-mensal">{{ $percentagemgeralaf == 0 ? "" : number_format($percentagemgeralaf, "2", ",", ".") }}</td>
        </tr>
    </table>
</body>
</html>

