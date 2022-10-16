<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Categoria</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">

        @foreach ($categorias as $categoria)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 50px;" class="dados-lista">{{$categoria->id}}</td>
                <td style="width: 550px;" class="dados-lista">{{$categoria->nome}}</td>
                <td style="width: 115px;" class="dados-lista">@if($categoria->ativo == 1) SIM @else NÃO @endif</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

