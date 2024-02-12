<?php

namespace App\Exports;

use App\Models\Bigtabledata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BigtabledatasExport implements FromCollection, WithHeadings
{
    protected $mes;
    protected $ano;

    public function __construct($mesrelatorio, $anorelatorio)
    {
        $this->mes = $mesrelatorio;
        $this->ano = $anorelatorio;
    }

    public function headings():array{
        return[
            'ID',
            'ID COMPRA',
            'ID PRODUTO',
            'QUANTIDADE',
            'MEDIDA',
            'PREÇO',
            'AF',
            'TOTAL',
            'NOME PRODUTO',
            'MEDIDA',
            'DATA INICIAL'
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
