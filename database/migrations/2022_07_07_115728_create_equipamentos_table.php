<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_fazenda');
            $table->string('nome');
            $table->string('fabricante');
            $table->string('noserie_painel')->nullable();
            $table->string('modelo')->nullable();
            $table->string('altura')->nullable();
            $table->string('balanco')->nullable();
            $table->string('painel')->nullable();
            $table->integer('giro')->nullable();
            $table->double('raio_ultima_torre', 10, 2)->nullable();
            $table->string('tipo_equipamento');
            $table->double('area', 10, 2)->nullable();
            $table->double('lamina_100', 10, 2)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('equipamentos');
    }
}
