<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SETRES - Associado</title>
</head>


<body>
    <table style="width: 1080px;  border-collapse: collapse; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">

        @foreach ($associados as $associado)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 50px;" class="dados-lista">{{$associado->id}}</td>}}
                {{--<td style="width: 50px;" class="dados-lista"><img src="{{ base_path() }}/public/images/coletor1.png" width="40"/ ></td>--}}
                <td style="width: 250px;" class="dados-lista">{{$associado->nome}}</td>
                <td style="width: 110px;" class="dados-lista">{{$associado->rg}}<br>{{$associado->rgorgaoemissor}}</td>
                <td style="width: 90px;" class="dados-lista">{{$associado->cpf}}</td>
                <td style="width: 180px;" class="dados-lista">{{$associado->foneum}}; {{$associado->foneum}} </td>
                <td style="width: 200px;" class="dados-lista">{{$associado->companhia->nome}}</td>
                <td style="width: 200px;" class="dados-lista">
                    @foreach($associado->bairros as $bairro) {{$bairro->nome}}; @endforeach
                </td>
            </tr>
        @endforeach

    </table>
</body>
</html>

