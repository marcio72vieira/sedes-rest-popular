<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Nutricionistas</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">

        @foreach ($nutricionistas as $nutricionista)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 30px;" class="dados-lista">{{$nutricionista->id}}</td>
                <td style="width: 215px;" class="dados-lista">{{$nutricionista->nomecompleto}}</td>
                <td style="width: 202px" class="dados-lista">{{$nutricionista->email}}; {{$nutricionista->telefone}}</td>
                <td style="width: 230px" class="dados-lista">
                    @isset($nutricionista->restaurante->identificacao)
                        {{$nutricionista->restaurante->identificacao}}
                    @endisset</td>
                <td style="width: 40px;" class="dados-lista">@if($nutricionista->ativo == 1) SIM @else NÃO @endif</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

