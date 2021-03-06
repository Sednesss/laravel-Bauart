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
        Schema::table('images', function (Blueprint $table) {
            $table->bigInteger('images_stack_id')->unsigned()->after('storage_id');
            $table->foreign('images_stack_id')->references('id')->on('images_stacks');

            $table->string('status')->nullable(true)->after('name')->default('uploading');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropForeign('images_images_stack_id_foreign');
        });
    }
};
