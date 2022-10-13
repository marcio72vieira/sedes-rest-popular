<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipio;


class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipio = new Municipio();
            $municipio->nome = "São Luis";
            $municipio->ativo = true;
        $municipio->save();

    }
}
