<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id');
            $table->integer('storage_id');

            $table->string('name');
            $table->string('path_origin');
            $table->string('path_processed');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('storage_id')->references('id')->on('storages');

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
        Schema::dropIfExists('images');
    }
};
