<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fabricante');
            $table->string('nome');
            $table->float('espacamento', 8, 2);
            $table->float('saida_1_inicial', 10,4);
            $table->float('saida_2_inicial', 10,4);
            $table->float('saida_3_inicial', 10,4);
            $table->float('saida_1_intermediario', 10,4);
            $table->float('saida_2_intermediario', 10,4);
            $table->float('saida_3_intermediario', 10,4);
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
        Schema::dropIfExists('pivos');
    }
}
