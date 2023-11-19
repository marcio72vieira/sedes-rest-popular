<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES</title>
</head>


<body style="vertical-align:baseline">
    <table style="width: 1080px; border-collapse: collapse;">

        {{-- 
        @php
            $total_companhias = 0;
            $total_tipos = 0;
            $total_catadores = 0;
            $total_catadoresmasculinos = 0;
            $total_catadoresfemininos = 0;
            $totoal_catadorescomcarteiras = 0;
            $total_catadoressemcarteiras = 0;
            $total_pontocoletas = 0;

            $arrTiposCompanhias = array();
            $arrTiposCompanhiasUnico = array();

            $arrTiposResiduos =  array();
            $stringTiposResiduos = '';
            $arrTiposResiduosIndividualizado =  array();
            $arrTiposResiduosUnico =  array();
            $stringTiposResiduosUnicos =  '';

        @endphp

        @foreach ($municipio as $dado)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 35px" class="dados-lista-dashboard">{{$dado->idCompanhia}}</td>
                <td style="width: 300px" class="dados-lista-dashboard">{{$dado->companhia_nome}}</td>
                <td style="width: 80px" class="dados-lista-dashboard">{{$dado->companhia_tipo}}</td>
                <td style="width: 80px; text-align:center" class="dados-lista-dashboard">{{$dado->companhia_totalcatadores}}</td>
                <td style="width: 50px; text-align:center" class="dados-lista-dashboard">{{$dado->companhia_totalmasc}}</td>
                <td style="width: 50px; text-align:center" class="dados-lista-dashboard">{{$dado->companhia_totalfeme}}</td>
                <td style="width: 50px; text-align:center" class="dados-lista-dashboard">{{$dado->companhia_totalcomcarteira}}</td>
                <td style="width: 50px; text-align:center" class="dados-lista-dashboard">{{$dado->companhia_totalsemcarteira}}</td>
                <td style="width: 60px; text-align:center" class="dados-lista-dashboard">{{$dado->pontocoleta_total}}</td>
                <td style="width: 50px; text-align:center" class="dados-lista-dashboard">{{$dado->residuo_total}}</td>
                <td style="width: 275px;" class="dados-lista-dashboard">{{$dado->nomeResiduo}}</td>
            </tr>
            @php
                $total_companhias ++;
                $total_catadores = $total_catadores + $dado->companhia_totalcatadores;
                $total_catadoresmasculinos = $total_catadoresmasculinos + $dado->companhia_totalmasc;
                $total_catadoresfemininos = $total_catadoresfemininos + $dado->companhia_totalfeme;
                $totoal_catadorescomcarteiras = $totoal_catadorescomcarteiras + $dado->companhia_totalcomcarteira;
                $total_catadoressemcarteiras = $total_catadoressemcarteiras + $dado->companhia_totalsemcarteira;
                $total_pontocoletas =  $total_pontocoletas + $dado->pontocoleta_total;

                // Acrescenta o tpo de companhia ao array
                $arrTiposCompanhias[] = $dado->companhia_tipo;

                // Acrescenta os tipos de resíduos ao array
                $arrTiposResiduos[] = $dado->nomeResiduo;
            @endphp

        @endforeach
        --}}

        {{-- 
        @php
            // Acrescenta o tipo de companhia ao array com elementos únicos
            $arrTiposCompanhiasUnico = array_unique($arrTiposCompanhias);

            // Juntando os tipos de resíduos em uma única string
            $stringTiposResiduos = join(', ', $arrTiposResiduos);

            // Separando os tipos de resíduos em elementos separados
            $arrTiposResiduosIndividualizado = explode(", ", $stringTiposResiduos);

            // Acrescenta os tipos de residuos ao array com elementos únicos
            $arrTiposResiduosUnico = array_unique($arrTiposResiduosIndividualizado);

            // Juntando os tipos de resíduos únicos, em uma única string
            $stringTiposResiduosUnicos = implode(', ', $arrTiposResiduosUnico);

        @endphp
        --}}

        {{-- @dd($arrTiposResiduos, $stringTiposResiduos, $arrTiposResiduosIndividualizado, $arrTiposResiduosUnico); --}}

        {{-- 
        <tr style="background-color: #e3e3e3">
            <td style="width: 35px; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard"></td>
            <td style="width: 300px; text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $total_companhias }}</td>
            <td style="width: 80px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ count($arrTiposCompanhiasUnico) }}</td>
            <td style="width: 80px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $total_catadores }}</td>
            <td style="width: 50px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $total_catadoresmasculinos }}</td>
            <td style="width: 50px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $total_catadoresfemininos }}</td>
            <td style="width: 50px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $totoal_catadorescomcarteiras }}</td>
            <td style="width: 50px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $total_catadoressemcarteiras }}</td>
            <td style="width: 60px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ $total_pontocoletas }}</td>
            <td style="width: 50px;  text-align:center; font-weight: bold; border-top: 1px solid #5c5a5a;" class="dados-lista-dashboard">{{ count($arrTiposResiduosUnico) }}</td>
            <td style="width: 275px; border-top: 1px solid #5c5a5a" class="dados-lista-dashboard">{{ $stringTiposResiduosUnicos }}</td>
        </tr>
        --}}

        @foreach ($records as $record)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 25px;" class="dados-lista-monitor">{{ $record->id }}</td>
                <td style="width: 69px;" class="dados-lista-monitor">{{ $record->nomeentidade }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->janaf == 0 ? "" : number_format($record->janaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->fevnormal == 0 ? "" : number_format($record->fevnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->fevaf == 0 ? "" : number_format($record->fevaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->marnormal == 0 ? "" : number_format($record->marnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->maraf == 0 ? "" : number_format($record->maraf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->abrnormal == 0 ? "" : number_format($record->abrnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->abraf == 0 ? "" : number_format($record->abraf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->mainormal == 0 ? "" : number_format($record->mainormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->maiaf == 0 ? "" : number_format($record->maiaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->junnormal == 0 ? "" : number_format($record->junnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->junaf == 0 ? "" : number_format($record->junaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->julnormal == 0 ? "" : number_format($record->julnormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->julaf == 0 ? "" : number_format($record->julaf, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
                <td style="width: 34px;" class="dados-lista-valor-monitor">{{ $record->jannormal == 0 ? "" : number_format($record->jannormal, "2", ",", ".") }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

