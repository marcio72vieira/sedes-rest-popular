<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SETRES - Companhia</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 500px;" class="label-ficha">NOME</td>
            <td style="width: 117px;" class="label-ficha">CNPJ</td>
            <td style="width: 100px;" class="label-ficha">FUNDAÇÃO</td>
        </tr>
        <tr>
            <td style="width: 500px;" class="dados-ficha">{{$companhia->nome}}</td>
            <td style="width: 117px;" class="dados-ficha">{{$companhia->cnpj}}</td>
            <?php $date=date_create($companhia->fundacao); $companhiafundacao = date_format($date,"d/m/Y"); ?>
            <td style="width: 100px;" class="dados-ficha">{{$companhiafundacao}}</td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 500px;" class="label-ficha">PRESIDENTE</td>
            <td style="width: 217px;" class="label-ficha">TELEFONE</td>
        </tr>
        <tr>
            <td style="width: 500px;" class="dados-ficha">{{$companhia->presidente}}</td>
            <td style="width: 217px;" class="dados-ficha">{{$companhia->fonepresidente}}</td>
        </tr>
        <tr>
            <td style="width: 500px;" class="label-ficha">VICE-PRESIDENTE</td>
            <td style="width: 217px;" class="label-ficha">TELEFONE</td>
        </tr>
        <tr>
            <td style="width: 500px;" class="dados-ficha">{{$companhia->vicepresidente}}</td>
            <td style="width: 217px;" class="dados-ficha">{{$companhia->fonevicepresidente}}</td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 450px;" class="label-ficha">ENDEREÇO</td>
            <td style="width: 50px;" class="label-ficha">Nº</td>
            <td style="width: 217px;" class="label-ficha">BAIRRO</td>
        </tr>
        <tr>
            <td style="width: 450px;" class="dados-ficha">{{$companhia->endereco}}</td>
            <td style="width: 50px;" class="dados-ficha">{{$companhia->numero}}</td>
            <td style="width: 217px;" class="dados-ficha">{{$companhia->bairro}}</td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 200px;" class="label-ficha">COMPLEMENTO</td>
            <td style="width: 200px;" class="label-ficha">CIDADE</td>
            <td style="width: 100px;" class="label-ficha">ZONA</td>
            <td style="width: 217px;" class="label-ficha">TELEFONE(S)</td>
        </tr>
        <tr>
            <td style="width: 200px;" class="dados-ficha">{{$companhia->complemento}}</td>
            <td style="width: 200px;" class="dados-ficha">{{$companhia->cidade}}</td>
            <td style="width: 100px;" class="dados-ficha">{{$companhia->zona}}</td>
            <td style="width: 217px;" class="dados-ficha">{{$companhia->foneum}} ;  {{$companhia->fonedois}}</td>
        </tr>
        <tr>
            <td colspan="4" style="width:717px;" class="close-ficha"></td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 717px;" class="label-ficha">RESÍDUOS COM QUE TRABALHA</td>
        </tr>
        <tr>
            <td style="width: 717px;" class="dados-ficha">
                @foreach ($companhia->residuos as $residuo)
                    {{$residuo->nome}};&nbsp;&nbsp;
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width:717px;" class="close-ficha"></td>
        </tr>
    </table>

    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td colspan="2" style="width: 717px" class="titulo-secao">ASSOCIADOS</td>
        </tr>
        <tr>
            <td style="width: 50px;" class="label-ficha col-header-table">ID</td>
            <td style="width: 667px;" class="label-ficha col-header-table">NOME</td>
        </tr>
        @foreach ($companhia->associados as $associado)
            <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                <td style="width: 50px;" class="dados-ficha">{{$associado->id}}</td>
                <td style="width: 667px;" class="dados-ficha">{{$associado->nome}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" style="width:717px;" class="close-ficha"></td>
        </tr>
    </table>
</body>
</html>
