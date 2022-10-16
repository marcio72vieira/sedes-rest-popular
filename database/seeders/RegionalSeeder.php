<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regional;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regional = new Regional();
            $regional->nome = "METROPOLITANA";
            $regional->ativo = true;
        $regional->save();
    }
}
