<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigtableDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bigtable_data', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('compra_id')->constrained()->onDelete('cascade');
            $table->foreignId('produto_id')->constrained()->onDelete('cascade');
            $table->decimal('quantidade',12,2);
            $table->integer('medida_id');
            $table->string('detalhe')->nullable();
            $table->decimal('preco',12,2);
            $table->string('af');
            $table->decimal('precototal',12,2);
            $table->string('produto_nome');
            $table->string('medida_nome');
            $table->string('medida_simbolo');
            $table->smallInteger('semana');
            $table->string('semana_nome');
            $table->date('data_ini');
            $table->date('data_fin');
            $table->decimal('valor',12, 2);
            $table->decimal('valoraf',12, 2);
            $table->decimal('valortotal',12, 2);
            $table->integer('categoria_id');
            $table->string('categoria_nome');
            $table->integer('restaurante_id');
            $table->string('identificacao');
            $table->integer('regional_id');
            $table->string('regional_nome');
            $table->integer('municipio_id');
            $table->string('municipio_nome');
            $table->integer('bairro_id');
            $table->string('bairro_nome');
            $table->integer('empresa_id');
            $table->string('razaosocial');
            $table->string('nomefantasia');
            $table->string('cnpj');
            $table->integer('nutricionista_id');
            $table->string('nutricionista_nomecompleto');
            $table->string('nutricionista_cpf');
            $table->string('nutricionista_crn');
            $table->string('nutricionista_empresa_id');
            $table->integer('user_id');
            $table->string('user_nomecompleto');
            $table->string('user_cpf');
            $table->string('user_crn');
            
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
        Schema::dropIfExists('bigtable_data');
    }
}
