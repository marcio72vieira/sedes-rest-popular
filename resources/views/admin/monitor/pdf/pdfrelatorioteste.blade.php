<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SETRES - Relatório Individual</title>
</head>


<body>


    <table style="width: 1080px;  border-collapse: collapse; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
        @foreach ($municipio->companhias as $companhia)
            <tr style="background-color: #7f7f7f;">
                <td colspan="7" class="dados-lista-titulo">{{$companhia->nome}} ({{$companhia->associados()->count()}})</td>
            </tr>
            @foreach($companhia->associados as $associado)

                <tr @if($loop->even) style="background-color: #e3e3e3;" @endif>
                    <td style="width: 50px;" class="dados-lista">{{$associado->id}}</td>
                    <td style="width: 250px;" class="dados-lista">{{$associado->nome}}<br>{{$associado->carteiraemitida == 1 ? 'carteira'.'  ('.mrc_turn_data($associado->carteiravalidade).')' : ''}}</td>
                    <td style="width: 110px;" class="dados-lista">{{$associado->rg}}<br>{{$associado->rgorgaoemissor}}</td>
                    <td style="width: 90px;" class="dados-lista">{{$associado->cpf}}</td>
                    <td style="width: 180px;" class="dados-lista">{{$associado->foneum}}; {{$associado->foneum}} </td>
                    <td style="width: 200px;" class="dados-lista">{{$associado->companhia->nome}}</td>
                    <td style="width: 200px;" class="dados-lista">
                        @foreach($associado->areas as $area)  {{$area->nome}} @endforeach - ({{$associado->municipio->nome}})
                    </td>
                </tr>
            @endforeach
            {{-- @php $mpdf->AddPage() @endphp --}}
        @endforeach
    </table>

</body>
</html>

{{-- CABEÇALHO RELATÓRIO MUNICÍPIO INDIVIDUAL ORIGINAL
public function relatoriomunicipioindividual($idMunicipio)
{
    $municipio = Dashboard::dadosMunicipioIndividual($idMunicipio);

    $fileName = ('Municipio_individual.pdf');

    $mpdf = new \Mpdf\Mpdf([
        'orientation' => 'L',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 37,
        'margin_bottom' => 15,
        'margin-header' => 10,
        'margin_footer' => 5
    ]);

    $mpdf->SetHTMLHeader('
        <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
            <tr>
                <td style="width: 108px">
                    <img src="images/logo-ma.png" width="80"/>
                </td>
                <td style="width: 432px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                    Governo do Estado do Maranhão<br>
                    Secretaria de Governo<br>
                    Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                    Secretaria do Trabalho e Economia Solidaria/SETRES
                </td>
                <td style="width: 540px;" class="titulo-rel">
                    RELATÓRIO GERAL
                </td>
            </tr>
        </table>
        <table style="width:1080px; border-collapse: collapse;">
            <tr>
                <td rowspan="2" width="35px"  class="col-header-table">Id</td>
                <td rowspan="2" width="250px" class="col-header-table" style="text-align:center">Município</td>
                <td colspan="5" width="225px" class="col-header-table" style="text-align:center">Companhias</td>
                <td rowspan="2" width="90px"  class="col-header-table" style="text-align:center">P. Coleta</td>
                <td rowspan="2" width="100px" class="col-header-table" style="text-align:center">Bairros</td>
                <td rowspan="2" width="80px"  class="col-header-table" style="text-align:center">Catadores</td>
                <td colspan="2" width="100px" class="col-header-table" style="text-align:center">Sexo</td>
                <td colspan="2" width="100px" class="col-header-table" style="text-align:center">Carteira Emitida</td>
                <td rowspan="2" width="100px" class="col-header-table" style="text-align:center">Resíduos</td>
            </tr>
            <tr>
                <td width="45px" class="col-header-table" style="text-align:center">Associação</td>
                <td width="45px" class="col-header-table" style="text-align:center">Avulsa</td>
                <td width="45px" class="col-header-table" style="text-align:center">Cooperativa</td>
                <td width="45px" class="col-header-table" style="text-align:center">Informal</td>
                <td width="45px" class="col-header-table" style="text-align:center">Indefinida</td>
                <td width="50px" class="col-header-table" style="text-align:center">masc</td>
                <td width="50px" class="col-header-table" style="text-align:center">fem</td>
                <td width="50px" class="col-header-table" style="text-align:center">sim</td>
                <td width="50px" class="col-header-table" style="text-align:center">não</td>
            </tr>
        </table>
    ');

    $mpdf->SetHTMLFooter('
        <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
            <tr>
                <td width="360px">São Luis(MA) {DATE d/m/Y}</td>
                <td width="360px" align="center"></td>
                <td width="360px" align="right">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    ');




    $html = \View::make('admin.dashboard.pdf.pdfrelatoriomunicipioindividual', compact('municipio'));
    $html = $html->render();

    $stylesheet = file_get_contents('pdf/mpdf.css');
    $mpdf->WriteHTML($stylesheet, 1);

    $mpdf->WriteHTML($html);
    $mpdf->Output($fileName, 'I');

    //return view('admin.residuo.pdf.pdfresiduogeral', compact('residuos'));
}
--}}

