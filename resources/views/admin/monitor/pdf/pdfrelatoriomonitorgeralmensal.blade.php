<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES</title>
</head>


<body style="vertical-align:baseline">
   
    <table style="width: 390px; border-collapse: collapse;  border: 0.1px solid #b1aeae;  margin: auto;">
        @php
            $linhatotalnormal = 0;
            $linhatotalaf = 0;
            $linhatotalgeral = 0;
            $linhapercentagemnormal = 0;
            $linhapercentagemaf = 0;

            $totalcolunajannormal = 0;
            $totalcolunajanaf = 0;

            $totalcolunatotalparcialnormal = 0;
            $totalcolunatotalparcialaf = 0;
            $totalcolunatotalgeral = 0;
            $totalcolunapercentagemtotalnormal = 0;
            $totalcolunapercentagemtotalaf = 0;

            $totalgeraljan = 0;
            $totalgeralfev = 0;
            $totalgeralmar = 0;
            $totalgeralabr = 0;
            $totalgeralmai = 0;
            $totalgeraljun = 0;
            $totalgeraljul = 0;
            $totalgeralags = 0;
            $totalgeralset = 0;
            $totalgeralout = 0;
            $totalgeralnov = 0;
            $totalgeraldez = 0;

        @endphp


        @foreach ($records as $record)

            {{-- Usado para depuração no blade: @dd($record); --}}

            @php
                // Somando os totais dos meses da entidade
                $linhatotalnormal = $record->jannormal;
                $linhatotalaf = $record->janaf;
                $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

                // Cálculo das percentagens. Evitando divisão por zero
                if($linhatotalgeral != 0){
                    $linhapercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                    $linhapercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
                }else {
                    $linhapercentagemnormal = 0;
                    $linhapercentagemaf = 0;
                }

                // Caso o registro não possua dados, o mesmo não é exibido, evitando a poluição do relatório com dados vazio
                // O teste é feito em cima da linha total geral, porque esse já engloba os valores somados de normal e af
                if($linhatotalgeral == 0){
                    continue;
                }

            @endphp

            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 20px;" class="dados-lista-monitor">&nbsp;{{ $record->id }}</td>
                <td style="width: 100px;" class="dados-lista-monitor">{{ $record->nomeentidade }}</td>
                <td style="width: 45px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 45px;" class="dados-lista-valor-monitor">{{ $record->janaf     == 0 ? "" : number_format($record->janaf, "2", ",", ".") }}</td>
                {{--<td style="width: 39px;" class="dados-lista-valor-monitor">{{ $linhatotalnormal  == 0 ? "" : number_format($linhatotalnormal, "2", ",", ".") }}</td>
                <td style="width: 39px;" class="dados-lista-valor-monitor">{{ $linhatotalaf      == 0 ? "" : number_format($linhatotalaf, "2", ",", ".") }}</td>--}}
                <td style="width: 90px;" class="dados-lista-valor-monitor">{{ $linhatotalgeral   == 0 ? "" : number_format($linhatotalgeral, "2", ",", ".") }}</td>
                <td style="width: 45px;" class="dados-lista-valor-monitor">{{ $linhapercentagemnormal == 0 ? "" : number_format($linhapercentagemnormal, "2", ",", ".") }}</td>
                <td style="width: 45px;" class="dados-lista-valor-monitor">{{ $linhapercentagemaf     == 0 ? "" : number_format($linhapercentagemaf, "2", ",", ".") }}</td>
            </tr>
            @php
                // Cálculo dos totais parciais normal e af dos meses
                $totalcolunajannormal = $totalcolunajannormal + $record->jannormal;
                $totalcolunajanaf = $totalcolunajanaf + $record->janaf;

                // Cálculo dos totais parciais normal e af das entidades
                $totalcolunatotalparcialnormal = $totalcolunatotalparcialnormal + $linhatotalnormal;
                $totalcolunatotalparcialaf = $totalcolunatotalparcialaf + $linhatotalaf;

                $totalcolunatotalgeral = $totalcolunatotalgeral + $linhatotalgeral;
            @endphp
        @endforeach

        @php
            // Cálculo das percentagens totais. Evitando divisão por zero
            if($totalcolunatotalgeral != 0){
                $totalcolunapercentagemtotalnormal = (($totalcolunatotalparcialnormal * 100)/$totalcolunatotalgeral);
                $totalcolunapercentagemtotalaf = (($totalcolunatotalparcialaf * 100)/$totalcolunatotalgeral);
            }else {
                $totalcolunapercentagemtotalnormal = 0;
                $totalcolunapercentagemtotalaf = 0;
            }

            // Cálculo totais gerais por meses
            $totalgeraljan = $totalcolunajannormal + $totalcolunajanaf;

            $totalgeralcolunaparcial = $totalcolunatotalparcialnormal + $totalcolunatotalparcialaf;
            $totalgeralcolunatotalgeral = $totalgeraljan;

        @endphp

        <tr>
            {{--<td style="width: 25px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor"></td> --}}
            <td colspan="2" style="width: 120px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor">&nbsp;&nbsp;TOTAL GERAL</td>
            <td style="width: 45px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajannormal == 0 ? "" : number_format($totalcolunajannormal, "2", ",", ".")}}</td>
            <td style="width: 45px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajanaf == 0 ? "" : number_format($totalcolunajanaf, "2", ",", ".")}}</td>
            {{--<td style="width: 39px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunatotalparcialnormal == 0 ? "" : number_format($totalcolunatotalparcialnormal, "2", ",", ".")}}</td>
            <td style="width: 39px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunatotalparcialaf == 0 ? "" : number_format($totalcolunatotalparcialaf, "2", ",", ".")}}</td>--}}
            <td style="width: 90px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunatotalgeral == 0 ? "" : number_format($totalcolunatotalgeral, "2", ",", ".") }}</td>
            <td style="width: 45px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunapercentagemtotalnormal == 0 ? "" : number_format($totalcolunapercentagemtotalnormal, "2", ",", ".") }}</td>
            <td style="width: 45px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunapercentagemtotalaf == 0 ? "" : number_format($totalcolunapercentagemtotalaf, "2", ",", ".") }}</td>
        </tr>

        {{--
        <tr>
            <td colspan="2" style="width: 94px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor">&nbsp;&nbsp;TOTAIS GERAIS (nm + af)</td>
            <td colspan="2" style="width: 453px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeraljan == 0 ? "" : number_format($totalgeraljan, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 78px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralcolunaparcial == 0 ? "" : number_format($totalgeralcolunaparcial, "2", ",", ".")}}</td>
            <td style="width: 42px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralcolunatotalgeral == 0 ? "" : number_format($totalgeralcolunatotalgeral, "2", ",", ".") }}</td>
            <td colspan="2" style="width: 50px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ "100,00" }}</td>
        </tr>
        --}}
    </table>
</body>
</html>

