<?php

namespace App\Exports;

use App\Models\Bigtabledata;
use Maatwebsite\Excel\Concerns\FromCollection;

class BigtabledatasExport implements FromCollection
{
    protected $mes;
    protected $ano;

    public function __construct($mesrelatorio, $anorelatorio)
    {
        $this->mes = $mesrelatorio;
        $this->ano = $anorelatorio;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retorna todos os dados da Model Bigtabledata sem a necessidade de criar um método específico. Este é a forma default de utilização
        // return Bigtabledata::all();

        // Retorna os dados consultados no método getBigtabledatas criado no model Bigtabledata
        return collect(Bigtabledata::getBigtabledatasExcel($this->mes, $this->ano));
    }
}
