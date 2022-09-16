<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SETRES - Companhia</title>
</head>


<body>
    <table style="width: 1080px;  border-collapse: collapse; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">

        @foreach ($companhias as $companhia)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 50px;" class="dados-lista">{{$companhia->id}}</td>
                <td style="width: 250px;" class="dados-lista">{{$companhia->nome}}
                    @can('adm') - <small>{{ $companhia->municipio->nome }}</small>@endcan
                </td>
                <td style="width: 110px;" class="dados-lista">{{$companhia->cnpj}}</td>
                <td style="width: 90px;" class="dados-lista">{{$companhia->foneum}}</td>
                <td style="width: 200px;" class="dados-lista">{{$companhia->presidente}}</td>
                <td style="width: 90px;" class="dados-lista">{{$companhia->fonepresidente}}</td>
                <td style="width: 200px;" class="dados-lista">{{$companhia->vicepresidente}}</td>
                <td style="width: 90px;" class="dados-lista">{{$companhia->fonevicepresidente}}</td>
            </tr>
        @endforeach

    </table>
</body>
</html>

