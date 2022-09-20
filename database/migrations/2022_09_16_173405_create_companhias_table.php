<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanhiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companhias', function (Blueprint $table) {
            $table->id();
            $table->string('razaosocial');
            $table->string('nomefantasia');
            $table->string('cnpj');
            $table->string('codigocnae');
            $table->string('documentocnpj');
            $table->string('titularum');
            $table->string('cargotitum');
            $table->string('titulardois')->nullable();
            $table->string('cargotitdois')->nullable();
            //$table->foreignId('banco_id')->constrained()->onDelete('cascade');
            $table->string('agencia');
            $table->string('conta');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->foreignId('municipio_id')->constrained()->onDelete('cascade');
            $table->foreignId('bairro_id')->constrained()->onDelete('cascade');
            $table->string('cep');
            $table->string('emailum');
            $table->string('emaildois')->nullable();
            $table->string('celular');
            $table->string('foneum')->nullable();
            $table->string('fonedois')->nullable();
            $table->boolean('ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companhias');
    }
}
