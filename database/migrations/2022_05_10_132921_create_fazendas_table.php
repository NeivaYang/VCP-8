<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFazendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fazendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');
            $table->double('latitude', 12,8)->nullable();
            $table->double('longitude', 12,8)->nullable();
            $table->float('altitude');
            $table->unsignedBigInteger('id_proprietario');
            $table->unsignedBigInteger('id_consultor');
            $table->foreign('id_proprietario')->references('id')->on('proprietarios');
            $table->foreign('id_consultor')->references('id')->on('users');
            $table->integer('ativa')->default(1);
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
        Schema::dropIfExists('fazendas');
    }
}
