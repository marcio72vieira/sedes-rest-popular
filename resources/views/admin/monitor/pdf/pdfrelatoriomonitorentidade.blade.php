<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES</title>
</head>


<body style="vertical-align:baseline">
    <table style="width: 1080px; border-collapse: collapse;  border: 0.1px solid #b1aeae;">

        @php
            $linhatotalnormal = 0;
            $linhatotalaf = 0;
            $linhatotalgeral = 0;
            $linhapercentagemnormal = 0;
            $linhapercentagemaf = 0;

            $totalcolunajannormal = 0;
            $totalcolunajanaf = 0;
            $totalcolunafevnormal = 0;
            $totalcolunafevaf = 0;
            $totalcolunamarnormal = 0;
            $totalcolunamaraf = 0;
            $totalcolunaabrnormal = 0;
            $totalcolunaabraf = 0;
            $totalcolunamainormal = 0;
            $totalcolunamaiaf = 0;
            $totalcolunajunnormal = 0;
            $totalcolunajunaf = 0;
            $totalcolunajulnormal = 0;
            $totalcolunajulaf = 0;
            $totalcolunaagsnormal = 0;
            $totalcolunaagsaf = 0;
            $totalcolunasetnormal = 0;
            $totalcolunasetaf = 0;
            $totalcolunaoutnormal = 0;
            $totalcolunaoutaf = 0;
            $totalcolunanovnormal = 0;
            $totalcolunanovaf = 0;
            $totalcolunadeznormal = 0;
            $totalcolunadezaf = 0;
            
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
            @php
                // Somando os totais dos meses da entidade
                $linhatotalnormal = $record->jannormal + $record->fevnormal + $record->marnormal + $record->abrnormal + $record->mainormal + $record->junnormal + $record->julnormal + $record->agsnormal + $record->setnormal + $record->outnormal + $record->novnormal + $record->deznormal;
                $linhatotalaf = $record->janaf + $record->fevaf + $record->maraf + $record->abraf + $record->maiaf + $record->junaf + $record->julaf + $record->agsaf + $record->setaf + $record->outaf + $record->novaf + $record->dezaf;
                $linhatotalgeral = $linhatotalnormal + $linhatotalaf;
                
                // Cálculo das percentagens. Evitando divisão por zero
                if($linhatotalgeral != 0){
                    $linhapercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
                    $linhapercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
                }else {
                    $linhapercentagemnormal = 0;
                    $linhapercentagemaf = 0;
                }
            @endphp

            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 25px;" class="dados-lista-monitor">&nbsp;{{ $record->id }}</td>
                <td style="width: 69px;" class="dados-lista-monitor">{{ $record->nomeentidade }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->janaf     == 0 ? "" : number_format($record->janaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->fevnormal == 0 ? "" : number_format($record->fevnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->fevaf     == 0 ? "" : number_format($record->fevaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->marnormal == 0 ? "" : number_format($record->marnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->maraf     == 0 ? "" : number_format($record->maraf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->abrnormal == 0 ? "" : number_format($record->abrnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->abraf     == 0 ? "" : number_format($record->abraf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->mainormal == 0 ? "" : number_format($record->mainormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->maiaf     == 0 ? "" : number_format($record->maiaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->junnormal == 0 ? "" : number_format($record->junnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->junaf     == 0 ? "" : number_format($record->junaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->julnormal == 0 ? "" : number_format($record->julnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->julaf     == 0 ? "" : number_format($record->julaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->agsnormal == 0 ? "" : number_format($record->agsnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->agsaf     == 0 ? "" : number_format($record->agsaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->setnormal == 0 ? "" : number_format($record->setnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->setaf     == 0 ? "" : number_format($record->setaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->outnormal == 0 ? "" : number_format($record->outnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->outaf     == 0 ? "" : number_format($record->outaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->novnormal == 0 ? "" : number_format($record->novnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->novaf     == 0 ? "" : number_format($record->novaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->deznormal == 0 ? "" : number_format($record->deznormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->dezaf     == 0 ? "" : number_format($record->dezaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $linhatotalnormal  == 0 ? "" : number_format($linhatotalnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $linhatotalaf      == 0 ? "" : number_format($linhatotalaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $linhatotalgeral   == 0 ? "" : number_format($linhatotalgeral, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $linhapercentagemnormal == 0 ? "" : number_format($linhapercentagemnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $linhapercentagemaf     == 0 ? "" : number_format($linhapercentagemaf, "2", ",", ".") }}</td>
            </tr>
            @php
                // Cálculo dos totais parciais normal e af dos meses
                $totalcolunajannormal = $totalcolunajannormal + $record->jannormal;
                $totalcolunajanaf = $totalcolunajanaf + $record->janaf;
                $totalcolunafevnormal = $totalcolunafevnormal + $record->fevnormal;
                $totalcolunafevaf = $totalcolunafevaf + $record->fevaf;
                $totalcolunamarnormal = $totalcolunamarnormal + $record->marnormal;
                $totalcolunamaraf = $totalcolunamaraf + $record->maraf;
                $totalcolunaabrnormal = $totalcolunaabrnormal + $record->abrnormal;
                $totalcolunaabraf = $totalcolunaabraf + $record->abraf;
                $totalcolunamainormal = $totalcolunamainormal + $record->mainormal;
                $totalcolunamaiaf = $totalcolunamaiaf + $record->maiaf;
                $totalcolunajunnormal = $totalcolunajunnormal + $record->junnormal;
                $totalcolunajunaf = $totalcolunajunaf + $record->junaf;
                $totalcolunajulnormal = $totalcolunajulnormal + $record->julnormal;
                $totalcolunajulaf = $totalcolunajulaf + $record->julaf;
                $totalcolunaagsnormal = $totalcolunaagsnormal + $record->agsnormal;
                $totalcolunaagsaf = $totalcolunaagsaf + $record->agsaf;
                $totalcolunasetnormal = $totalcolunasetnormal + $record->setnormal;
                $totalcolunasetaf = $totalcolunasetaf + $record->setaf;
                $totalcolunaoutnormal = $totalcolunaoutnormal + $record->outnormal;
                $totalcolunaoutaf = $totalcolunaoutaf + $record->outaf;
                $totalcolunanovnormal = $totalcolunanovnormal + $record->novnormal;
                $totalcolunanovaf = $totalcolunanovaf + $record->novaf;
                $totalcolunadeznormal = $totalcolunadeznormal + $record->deznormal;
                $totalcolunadezaf = $totalcolunadezaf + $record->dezaf;

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
            $totalgeralfev = $totalcolunafevnormal + $totalcolunafevaf;
            $totalgeralmar = $totalcolunamarnormal + $totalcolunamaraf;
            $totalgeralabr = $totalcolunaabrnormal + $totalcolunaabraf;
            $totalgeralmai = $totalcolunamainormal + $totalcolunamaiaf;
            $totalgeraljun = $totalcolunajunnormal + $totalcolunajunaf;
            $totalgeraljul = $totalcolunajulnormal + $totalcolunajulaf;
            $totalgeralags = $totalcolunaagsnormal + $totalcolunaagsaf;
            $totalgeralset = $totalcolunasetnormal + $totalcolunasetaf;
            $totalgeralout = $totalcolunaoutnormal + $totalcolunaoutaf;
            $totalgeralnov = $totalcolunanovnormal + $totalcolunanovaf;
            $totalgeraldez = $totalcolunadeznormal + $totalcolunadezaf;
            
        @endphp

        <tr>
            {{--<td style="width: 25px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor"></td> --}}
            <td colspan="2" style="width: 94px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor">&nbsp;&nbsp;TOTAIS PARCIAIS</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajannormal == 0 ? "" : number_format($totalcolunajannormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajanaf == 0 ? "" : number_format($totalcolunajanaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunafevnormal == 0 ? "" : number_format($totalcolunafevnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunafevaf == 0 ? "" : number_format($totalcolunafevaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunamarnormal == 0 ? "" : number_format($totalcolunamarnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunamaraf == 0 ? "" : number_format($totalcolunamaraf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunaabrnormal == 0 ? "" : number_format($totalcolunaabrnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunaabraf == 0 ? "" : number_format($totalcolunaabraf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunamainormal == 0 ? "" : number_format($totalcolunamainormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunamaiaf == 0 ? "" : number_format($totalcolunamaiaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajunnormal == 0 ? "" : number_format($totalcolunajunnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajunaf == 0 ? "" : number_format($totalcolunajunaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajulnormal == 0 ? "" : number_format($totalcolunajulnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunajulaf == 0 ? "" : number_format($totalcolunajulaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunaagsnormal == 0 ? "" : number_format($totalcolunaagsnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunaagsaf == 0 ? "" : number_format($totalcolunaagsaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunasetnormal == 0 ? "" : number_format($totalcolunasetnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunasetaf == 0 ? "" : number_format($totalcolunasetaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunaoutnormal == 0 ? "" : number_format($totalcolunaoutnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunaoutaf == 0 ? "" : number_format($totalcolunaoutaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunanovnormal == 0 ? "" : number_format($totalcolunanovnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunanovaf == 0 ? "" : number_format($totalcolunanovaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunadeznormal == 0 ? "" : number_format($totalcolunadeznormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunadezaf == 0 ? "" : number_format($totalcolunadeznormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunatotalparcialnormal == 0 ? "" : number_format($totalcolunatotalparcialnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunatotalparcialaf == 0 ? "" : number_format($totalcolunatotalparcialaf, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunatotalgeral == 0 ? "" : number_format($totalcolunatotalgeral, "2", ",", ".") }}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunapercentagemtotalnormal == 0 ? "" : number_format($totalcolunapercentagemtotalnormal, "2", ",", ".") }}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-valor-monitor">{{ $totalcolunapercentagemtotalaf == 0 ? "" : number_format($totalcolunapercentagemtotalaf, "2", ",", ".") }}</td>
        </tr>

        
        <tr>
            <td colspan="2" style="width: 94px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px;" class="dados-lista-monitor">&nbsp;&nbsp;TOTAIS GERAIS</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeraljan == 0 ? "" : number_format($totalgeraljan, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralfev == 0 ? "" : number_format($totalgeralfev, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralmar == 0 ? "" : number_format($totalgeralmar, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralabr == 0 ? "" : number_format($totalgeralabr, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralmai == 0 ? "" : number_format($totalgeralmai, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeraljun == 0 ? "" : number_format($totalgeraljun, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeraljul == 0 ? "" : number_format($totalgeraljul, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralags == 0 ? "" : number_format($totalgeralags, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralset == 0 ? "" : number_format($totalgeralset, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralout == 0 ? "" : number_format($totalgeralout, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeralnov == 0 ? "" : number_format($totalgeralnov, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalgeraldez == 0 ? "" : number_format($totalgeraldez, "2", ",", ".")}}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalcolunatotalparcialnormal == 0 ? "" : number_format($totalcolunatotalparcialnormal, "2", ",", ".")}}</td>
            <td style="width: 34px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalcolunatotalgeral == 0 ? "" : number_format($totalcolunatotalgeral, "2", ",", ".") }}</td>
            <td colspan="2" style="width: 68px; border-top: 0.1px solid #000000; padding-top: 5px; padding-bottom: 5px; text-align: right;" class="dados-lista-valor-monitor">{{ $totalcolunapercentagemtotalaf == 0 ? "" : number_format($totalcolunapercentagemtotalaf, "2", ",", ".") }}</td>
        </tr>
    </table>
</body>
</html>

