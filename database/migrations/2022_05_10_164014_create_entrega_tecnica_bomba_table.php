<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaTecnicaBombaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_tecnica_bomba', function (Blueprint $table) {
            $table->bigInteger('id_entrega_tecnica')->foreing('id_entrega_tecnica')->references('id')->on('entrega_tecnica');
            $table->bigInteger('id_bomba');
            $table->string('marca', 30)->nullable();
            $table->string('tipo_motobomba', 10)->nullable();
            $table->string('modelo', 30)->nullable();
            $table->integer('numero_estagio')->nullable();
            $table->double('rotor', 6,2)->nullable();
            $table->string('numero_serie', 20)->nullable();
            $table->string('fornecedor', 255)->nullable();
            $table->string('opcionais', 100)->nullable();            
            $table->softDeletes();
            $table->timestamps();
            $table->primary(['id_entrega_tecnica', 'id_bomba']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrega_tecnica_bomba');
    }
}
