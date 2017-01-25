<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLabIdToEquipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->integer('lab_id')
                ->unsigned()
                ->default(1);
            $table->foreign('lab_id')
                ->references('id')
                ->on('labs')
                ->onDelete('cascade');

            $table->integer('user_id')
                ->unsigned()
                ->default(1);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
        });
    }
}
