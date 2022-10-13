<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_produto', function (Blueprint $table) {
            $table->foreignId('compra_id')->constrained()->onDelete('cascade');
            $table->foreignId('produto_id')->constrained()->onDelete('cascade');
            $table->decimal('quantidade',12,2);
            $table->integer('medida_id');
            $table->string('detalhe')->nullable();
            $table->decimal('preco',12,2);
            $table->string('af');
            $table->decimal('precototal',12,2);
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
        Schema::dropIfExists('compra_produto');
    }
}
