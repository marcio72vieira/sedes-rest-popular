<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SETRES - Município</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">

        @foreach ($municipios as $municipio)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 50px;" class="dados-lista">{{$municipio->id}}</td>
                <td style="width: 667px;" class="dados-lista">{{$municipio->nome}}</td>
            </tr>
        @endforeach

    </table>
</body>
</html>

