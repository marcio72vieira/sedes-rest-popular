<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Compra</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">

        @foreach ($compra->produtos as $item)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 30px;" class="dados-lista">{{$item->id}}</td>
                <td style="width: 200px;" class="dados-lista">{{$item->nome}}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{mrc_turn_value($item->pivot->quantidade)}}</td>
                <td style="width: 50px;" class="dados-lista">
                    @foreach($medidas  as $medida)
                        {{$medida->id == $item->pivot->medida_id ? $medida->simbolo : ''}}
                    @endforeach
                </td>
                <td style="width: 200px;" class="dados-lista">{{$item->pivot->detalhe}}</td>
                <td style="width: 72px; text-align: right" class="dados-lista">{{mrc_turn_value($item->pivot->preco)}}</td>
                <td style="width: 35px;text-align: center" class="dados-lista">{{$item->pivot->af == 'sim' ? 's' : 'n'}}</td>
                <td style="width: 80px; text-align: right" class="dados-lista">{{mrc_turn_value($item->pivot->precototal)}}</td>
            </tr>
        @endforeach

    </table>
</body>
</html>

