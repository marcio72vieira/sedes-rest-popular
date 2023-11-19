<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SETRES - Relatório Geral</title>
</head>


<body>
    <table style="width: 717px; border-collapse: collapse;">
        <tr>
            <td style="width: 300px;" class="label-dashboard">MUNICÍPIOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdMunicipios'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">BAIRROS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdBairros'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">PONTOS DE COLETA</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdPontoColetas'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">RESÍDUOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdResiduos'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">NÚMERO DE CATADORES</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssTotal'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES MASCULINO</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssMasc'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES FEMININO</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssFemi'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CARTEIRAS EMITIDAS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdComCart'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CARTEIRAS NÃO EMITIDAS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdSemCart'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES ASSOCIADOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssAssoc'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES COOPERADOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssCoop'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES AVULSOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssAvul'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES INFORMAIS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssInform'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">CATADORES INDEFINIDOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdAssIndef'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">ASSOCIAÇÕES</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdCompAssociacao'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">COOPERATIVAS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdCompCooperativa'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">GRUPOS AVULSOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdCompGrupoAvulso'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">GRUPOS INFORMAIS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdCompGrupoInform'] }}</td>
        </tr>
        <tr>
            <td style="width: 300px;" class="label-dashboard">GRUPOS INDEFINIDOS</td>
            <td style="width: 417px;" class="dados-dashboard">{{ $informacoesGerais['qtdCompGrupoIndef'] }}</td>
        </tr>
    </table>
</body>
</html>

