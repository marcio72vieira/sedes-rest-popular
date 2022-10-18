<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SEDES - Empresa</title>
</head>


<body>
    @foreach ($empresas as $empresa)
        <div @if($loop->odd) style="background-color: #e3e3e3;" @endif>
            <table style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 359px;" class="label-ficha">Razão Social</td>
                    <td style="width: 358px;" class="label-ficha">Nome Fantasia</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $empresa->razaosocial }}</td>
                    <td style="width: 358px;" class="dados-ficha">{{ $empresa->nomefantasia }}</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="label-ficha">Representante</td>
                    <td style="width: 358px;" class="label-ficha">Cargo</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $empresa->titular }}</td>
                    <td style="width: 358px;" class="dados-ficha">{{ $empresa->cargotitular }}</td>
                </tr>
            </table>

            <table  style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 179px;" class="label-ficha">CNPJ</td>
                    <td style="width: 180px;" class="label-ficha">E-mail</td>
                    <td style="width: 179px;" class="label-ficha">Celular</td>
                    <td style="width: 179px;" class="label-ficha">Telefone</td>
                </tr>
                <tr>
                    <td style="width: 179px;" class="dados-ficha">{{ $empresa->cnpj }}</td>
                    <td style="width: 180px;" class="dados-ficha">{{ $empresa->email }}</td>
                    <td style="width: 179px;" class="dados-ficha">{{ $empresa->celular }}</td>
                    <td style="width: 179px;" class="dados-ficha">{{ $empresa->fone }}</td>
                </tr>
            </table>

            <table  style="width: 717px; border-collapse: collapse;">
                <tr>
                    <td style="width: 359px;" class="label-ficha">Endereço</td>
                    <td style="width: 50px;" class="label-ficha">Nº</td>
                    <td style="width: 308px;" class="label-ficha">Complemento</td>
                </tr>
                <tr>
                    <td style="width: 359px;" class="dados-ficha">{{ $empresa->logradouro }}</td>
                    <td style="width: 50px;" class="dados-ficha">{{ $empresa->numero }}</td>
                    <td style="width: 308px;" class="dados-ficha">{{ $empresa->complemento }}</td>
                </tr>
            </table>

            <table  style="width: 717px; border-collapse: collapse; margin-bottom: 10px">
                <tr>
                    <td style="width: 179px;" class="label-ficha">Município</td>
                    <td style="width: 180px;" class="label-ficha">Bairro</td>
                    <td style="width: 179px;" class="label-ficha">CEP</td>
                    <td style="width: 100px;" class="label-ficha">Qtd. Nutricionistas</td>
                    <td style="width: 79px;" class="label-ficha">Ativo</td>
                </tr>
                <tr>
                    <td style="width: 179px;" class="dados-ficha">{{ $empresa->municipio }}</td>
                    <td style="width: 180px;" class="dados-ficha">{{ $empresa->bairro }}</td>
                    <td style="width: 179px;" class="dados-ficha">{{ $empresa->cep }}</td>
                    <td style="width: 100;" class="dados-ficha">{{ $empresa->qtdnutricionistasvinc($empresa->id) }}</td>
                    <td style="width: 79px;" class="dados-ficha">{{ $empresa->ativo == 1 ? 'SIM' : 'NÃO' }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="width:717px;" class="close-ficha"></td>
                </tr>
            </table>
        </div>

    @endforeach
</body>
</html>

