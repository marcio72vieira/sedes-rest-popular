<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');         //Será formado por: Unidade - Nome do Bairro
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->foreignId('municipio_id')->constrained()->onDelete('cascade');
            $table->foreignId('bairro_id')->constrained()->onDelete('cascade');
            $table->string('cep');
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
            $table->foreignId('nutricionista_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('restaurantes');
    }
}
