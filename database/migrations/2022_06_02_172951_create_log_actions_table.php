<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_actions', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('farm_id')->nullable()->unsigned();
            $table->unsignedBigInteger('user_id')->nullable()->unsigned();
            $table->string('uri')->nullable();
            $table->string('method')->nullable();
            $table->unsignedBigInteger('item_id')->nullable()->unsigned();
            $table->string('module')->nullable();
            $table->string('action')->nullable();
            $table->json('request_data')->nullable();
            $table->string('client_host')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('client_device_type')->nullable();
            $table->string('client_device')->nullable();
            $table->string('client_browser')->nullable();
            $table->string('client_platform')->nullable();
            $table->string('client_version')->nullable();
            $table->string('client_agent')->nullable();

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
        Schema::dropIfExists('log_actions');
    }
}