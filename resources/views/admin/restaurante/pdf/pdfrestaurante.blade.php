<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Restaurante</title>
</head>


<body>
    @foreach ($restaurantes as $restaurante)
        <div @if($loop->odd) style="background-color: #e3e3e3;" @endif>
            <table style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 359px;" class="label-ficha">Identificação</td>
                    <td style="width: 358px;" class="label-ficha">Regional</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $restaurante->identificacao }}</td>
                    <td style="width: 358px;" class="dados-ficha">{{ $restaurante->municipio->regional->nome }}</td>
                </tr>
            </table>

            <table style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 359px;" class="label-ficha">Empresa: Razão Social</td>
                    <td style="width: 358px;" class="label-ficha">Empresa:Nome de Fantasia</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $restaurante->empresa->razaosocial }}</td>
                    <td style="width: 358px;" class="dados-ficha">{{ $restaurante->empresa->nomefantasia }}</td>
                </tr>
            </table>

            <table style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 359px;" class="label-ficha">Nutricionista EMPRESA</td>
                    <td style="width: 358px;" class="label-ficha">Nutricionista SEDES</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $restaurante->nutricionista->nomecompleto }}</td>
                    <td style="width: 358px;" class="dados-ficha">{{ $restaurante->user->nomecompleto }}</td>
                </tr>
            </table>

            <table  style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 359px;" class="label-ficha">Endereço</td>
                    <td style="width: 100px;" class="label-ficha">Nº</td>
                    <td style="width: 258px;" class="label-ficha">Complemento</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $restaurante->logradouro }}</td>
                    <td style="width: 100px;" class="dados-ficha">{{ $restaurante->numero }}</td>
                    <td style="width: 258px;" class="dados-ficha">{{ $restaurante->complemento }}</td>
                </tr>
            </table>

            <table  style="width: 717px; border-collapse: collapse; margin-bottom: 10px">
                <tr>
                    <td style="width: 179px;" class="label-ficha">Município</td>
                    <td style="width: 180px;" class="label-ficha">Bairro</td>
                    <td style="width: 100px;" class="label-ficha">CEP</td>
                    <td style="width: 258px;" class="label-ficha">Ativo</td>
                </tr>
                <tr>
                    <td style="width: 179px;" class="dados-ficha">{{ $restaurante->municipio->nome }}</td>
                    <td style="width: 180px;" class="dados-ficha">{{ $restaurante->bairro->nome }}</td>
                    <td style="width: 100px;" class="dados-ficha">{{ $restaurante->cep }}</td>
                    <td style="width: 258px;" class="dados-ficha">{{ $restaurante->ativo == 1 ? 'SIM' : 'NÃO' }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="width:717px;" class="close-ficha"></td>
                </tr>
            </table>
        </div>

    @endforeach
</body>
</html>

