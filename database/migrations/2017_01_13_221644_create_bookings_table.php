<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session');
            $table->softDeletes();
            $table->timestamps();

            $table->integer('user_id')
                ->unsigned()
                ->default(1);
            $table->integer('lab_id')
                ->unsigned()
                ->default(1);
            $table->integer('equipment_id')
                ->unsigned()
                ->default(1);

            $table->foreign('users')
                ->references('user_id')
                ->on('bookings')
                ->onDelete('cascade');

            $table->foreign('labs')
                ->references('lab_id')
                ->on('bookings')
                ->onDelete('cascade');

            $table->foreign('equipments')
                ->references('equipment_id')
                ->on('bookings')
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
        Schema::dropIfExists('bookings');
    }
}
