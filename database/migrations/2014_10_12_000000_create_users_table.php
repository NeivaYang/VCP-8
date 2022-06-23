<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');
            $table->string('rua');
            $table->string('cep');
            $table->string('telefone');
            $table->integer('configuracao_idioma');
            $table->integer('tipo_usuario');
            $table->integer('situacao')->default(1);
            $table->unsignedBigInteger('id_country')->foreign('id_country')->references('id')->on('country');
            $table->string('preferencia_idioma', 5)->default('pt-br');
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
        Schema::dropIfExists('users');
    }
}
