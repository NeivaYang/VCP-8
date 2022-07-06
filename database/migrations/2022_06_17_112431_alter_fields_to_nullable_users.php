<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldsToNullableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Altering fields to nullable
            $table->string('cidade')->unsigned()->nullable()->change();
            $table->string('estado')->unsigned()->nullable()->change();
            $table->string('rua')->unsigned()->nullable()->change();
            $table->string('cep')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Returning fields to not nullable
            $table->string('cidade')->unsigned()->nullable(false)->change();
            $table->string('estado')->unsigned()->nullable(false)->change();
            $table->string('rua')->unsigned()->nullable(false)->change();
            $table->string('cep')->unsigned()->nullable(false)->change();
        });
    }
}
