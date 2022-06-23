<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBocaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bocais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fabricante');
            $table->string('nome');
            $table->float('vazao', 8, 2);
            $table->float('intervalo_trabalho', 8, 2);
            $table->float('vazao_10_psi', 8, 2)->default(0);
            $table->integer('id_fabricante')->constrained('fabricante_bocal');
            $table->integer('plug');
            $table->tinyInteger('tipo');
            $table->string('modelo');
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
        Schema::dropIfExists('bocais');
    }
}
