<?php

namespace App\Exports;

use App\Models\Bigtabledata;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\WithHeadings;        // Criar cabeçalho
use Maatwebsite\Excel\Concerns\ShouldAutoSize;      // Define o autosizing das colunas

//class BigtabledatasExport implements FromCollection, WithHeadings, ShouldAutoSize
class BigtabledatasExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $mes;
    protected $ano;

    public function __construct($mesrelatorio, $anorelatorio)
    {
        $this->mes = $mesrelatorio;
        $this->ano = $anorelatorio;
    }

    // Definindo a linha de cabeçalho da planilha e csv (nessecário importar: WithHeadings)
    public function headings():array{
        return[
            'REGISTRO',
            'REGIONAL',
            'MUNICÍPIO',
            'RESTAURANTE',
            'AF',
            'Nº COMPRA',
            'CATEGORIA',
            'PRODUTO',
            'DETALHE',
            'QUANTIDADE',
            'MEDIDA NOME',
            'MEDIDA SÍMBOLO',
            'PREÇO',
            'TOTAL',
            'SEMANA',
            'DATA INICIAL',
            'MÊS INICIO',
            'ANO INICIO',
            'DATA FINAL',
            'MÊS FIM',
            'ANO FIM',
            'EMPRESA',
            'NUTRICIONISTA EMPRESA',
            'CPF NUTRI EMPRESA',
            'CRN NUTRI EMPRESA',
            'NUTRICIONISTA SEDES',
            'CPF NUTRI SEDES',
            'CRN NUTRI SEDES',
            'CRIADO',
            'ATUALIZADO'
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retorna todos os dados(campos) da Model Bigtabledata sem a necessidade de criar um método específico. Este é a forma default de utilização
        // return Bigtabledata::all();

        // Retorna os dados(campos) consultados no método getBigtabledatas criado no model Bigtabledata
        return collect(Bigtabledata::getBigtabledatasExcel($this->mes, $this->ano));
    }


    // O método abaixo, é utilizado em conjunto com as classes abaixo:
    // use Maatwebsite\Excel\Concerns\FromQuery;
    // use Maatwebsite\Excel\Concerns\Exportable;
    // use Illuminate\Support\Facades\DB;
    public function query()
    {
        if($this->mes == 0){
            $records = DB::table('bigtable_data')->selectRaw('id, regional_nome, municipio_nome, identificacao, af, compra_id, categoria_nome, produto_nome, detalhe, quantidade, medida_nome, medida_simbolo, preco, precototal, semana_nome, DATE_FORMAT(data_ini,"%d/%m/%Y"), MONTH(data_ini) AS mes_ini, YEAR(data_ini) AS ano_ini, DATE_FORMAT(data_fin,"%d/%m/%Y"), MONTH(data_fin) AS mes_fin, YEAR(data_fin) AS ano_fin, nomefantasia, nutricionista_nomecompleto, nutricionista_cpf, nutricionista_crn, user_nomecompleto, user_cpf, user_crn, DATE_FORMAT(created_at,"%d/%m/%Y %H:%i"), DATE_FORMAT(updated_at,"%d/%m/%Y %H:%i")')->whereYear('data_ini', $this->ano)->orderBy('id');
        }else{
            $records = DB::table('bigtable_data')->selectRaw('id, regional_nome, municipio_nome, identificacao, af, compra_id, categoria_nome, produto_nome, detalhe, quantidade, medida_nome, medida_simbolo, preco, precototal, semana_nome, DATE_FORMAT(data_ini,"%d/%m/%Y"), MONTH(data_ini) AS mes_ini, YEAR(data_ini) AS ano_ini, DATE_FORMAT(data_fin,"%d/%m/%Y"), MONTH(data_fin) AS mes_fin, YEAR(data_fin) AS ano_fin, nomefantasia, nutricionista_nomecompleto, nutricionista_cpf, nutricionista_crn, user_nomecompleto, user_cpf, user_crn, DATE_FORMAT(created_at,"%d/%m/%Y %H:%i"), DATE_FORMAT(updated_at,"%d/%m/%Y %H:%i")')->whereMonth('data_ini', $this->mes)->whereYear('data_ini', $this->ano)->orderBy('id');
        }

        return $records;

    }
}
