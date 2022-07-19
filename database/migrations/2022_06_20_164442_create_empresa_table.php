<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 50);
            $table->string('email', 200)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('logo', 200)->nullable();
            $table->string('tipo', 15);
            $table->unsignedBigInteger('id_country')->foreign('id_country')->references('id')->on('country');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::table('empresa', function (Blueprint $table) {
            Schema::dropIfExists('empresa');
        });
    }
}
