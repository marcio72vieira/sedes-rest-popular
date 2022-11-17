<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Regional</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">

        @foreach ($regionais as $regional)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 50px;" class="dados-lista">{{$regional->id}}</td>
                <td style="width: 350px;" class="dados-lista">{{$regional->nome}}</td>
                <td style="width: 100px;" class="dados-lista" style="text-align: center">{{$regional->countmunicipios()}}</td>
                <td style="width: 100px;" class="dados-lista" style="text-align: center">{{$regional->restaurantes->count()}}</td>
                <td style="width: 115px; text-align:center" class="dados-lista">@if($regional->ativo == 1) SIM @else NÃO @endif</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

