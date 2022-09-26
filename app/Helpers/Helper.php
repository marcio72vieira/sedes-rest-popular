<?php

//namespace App\Helpers;


if (!function_exists('mrc_calc_time')) {

    function mrc_calc_time($dataStart)
    {
        $dataStart = strtotime($dataStart);
        $dateEnd = strtotime(date('Y-m-d'));

        $datadiff = abs(($dateEnd) - ($dataStart));
        $years = floor($datadiff / (365*60*60*24));
        $months = floor(($datadiff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($datadiff - $years*365*60*60*24 - $months*30*60*60*24) / (60*60*24));

        return $years. " anos, ". $months. " meses " . "e ". $days. " dia(s)";
    }
}


if (!function_exists('mrc_turn_data')) {

    function mrc_turn_data($dataBd)
    {
        $dataTurn = implode('/', array_reverse(array_merge(explode('-', $dataBd))));
        return $dataTurn;
    }
}

if (!function_exists('mrc_turn_value')) {

    function mrc_turn_value($valueBd)
    {
        $dataValue = number_format($valueBd, '2', ',', '.');
        return $dataValue;
    }
}


if (!function_exists('mrc_calc_percentage')) {

    function mrc_calc_percentaf($val_tot, $val_parc)
    {
        $percentage = (($val_parc * 100) / $val_tot);

        $percentformated = number_format($percentage, '2', ',', '.');
        return $percentformated;
    }
}


if (!function_exists('mrc_extract_month')) {

    function mrc_extract_month($dataBd)
    {
        $month = date("m", strtotime($dataBd));

        switch ($month) {
            case 1:
                $mescompra = "JAN";
                break;
            case 2:
                $mescompra = "FEV";
                break;
            case 3:
                $mescompra = "MAR";
                break;
            case 4:
                $mescompra = "ABR";
                break;
            case 5:
                $mescompra = "MAI";
                break;
            case 6:
                $mescompra = "JUN";
                break;
            case 7:
                $mescompra = "JUL";
                break;
            case 8:
                $mescompra = "AGS";
                break;
            case 9:
                $mescompra = "SET";
                break;
            case 10:
                $mescompra = "OUT";
                break;
            case 11:
                $mescompra = "NOV";
                break;
            case 12:
                $mescompra = "DEZ";
                break;
            default:
                $mescompra = "Mês inválido!";
          }

        return $mescompra;
    }
}
