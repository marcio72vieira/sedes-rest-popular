<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Registro de compra</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">

        @foreach ($records as $item)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 30px;" class="dados-lista">{{ $item->produto_id }}</td>
                <td style="width: 200px;" class="dados-lista">{{$item->produto_nome}}</td>
                <td style="width: 200px;" class="dados-lista">{{$item->detalhe}}</td>
                <td style="width: 35px; text-align: center" class="dados-lista">{{ ($item->af == "sim" ? "x" : "" ) }}</td>
                <td style="width: 50px; text-align: right" class="dados-lista">{{$item->quantidade}}</td>
                <td style="width: 50px; text-align: center" class="dados-lista">{{$item->medida_simbolo}}</td>
                <td style="width: 72px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->preco) }}</td>
                <td style="width: 80px; text-align: right" class="dados-lista">{{ mrc_turn_value($item->precototal) }}</td>
            </tr>
        @endforeach
    </table>
    <table  style="width: 717px; border-collapse: collapse; margin-top:3px;">
        <tr>
            <td style="width: 637px; text-align: right" class="dados-box-top"><strong>Valor R$</strong> </td> 
            <td style="width: 80px; text-align: right" class="dados-box-top">{{ mrc_turn_value($somapreco) }} </td>
        </tr>
        <tr>
            <td style="width: 637px; text-align: right" class="dados-box-middle">
                <strong>Valor AF ({{intval(mrc_calc_percentaf($somafinal, $somaprecoaf ))}}%) R$ </strong> 
            </td>
            <td style="width: 80px;text-align: right" class="dados-box-middle">{{ mrc_turn_value($somaprecoaf) }} </td>
        </tr>
        <tr>
            <td style="width: 637px; text-align: right" class="dados-box-bottom"><strong>Valor Total R$</strong> </td>
            <td style="width: 80px; text-align: right" class="dados-box-bottom" >{{  mrc_turn_value($somafinal) }} </td>
        </tr>
    </table>

</body>
</html>

