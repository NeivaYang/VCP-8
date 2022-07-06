<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaTecnicaAdutoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_tecnica_adutora', function (Blueprint $table) {
            $table->bigInteger('id_entrega_tecnica')->foreing('id_entrega_tecnica')->references('id')->on('entrega_tecnica');
            $table->bigInteger('id_adutora');
            $table->string('tipo_tubo', 30)->nullable();
            $table->double('diametro', 6,2)->nullable();
            $table->integer('numero_linha')->nullable();
            $table->string('fornecedor', 30)->nullable();
            $table->string('marca_tubo', 30)->nullable();
            $table->integer('quantidade')->nullable();
            $table->double('comprimento', 6,2)->nullable();            
            $table->softDeletes();
            $table->timestamps();
            $table->primary(['id_entrega_tecnica', 'id_adutora'], 'key_entrega_tecnica_adutora');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrega_tecnica_adutora');
    }
}
