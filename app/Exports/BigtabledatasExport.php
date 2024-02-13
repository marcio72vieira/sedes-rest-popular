<?php

namespace App\Exports;

use App\Models\Bigtabledata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;        // Criar cabeçalho
use Maatwebsite\Excel\Concerns\ShouldAutoSize;      // Define o autosizing das colunas

class BigtabledatasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
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
            'MEDIDA',
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
}
