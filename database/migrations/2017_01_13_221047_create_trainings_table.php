<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_of_training_session');
            $table->string('location');
            $table->softDeletes();
            $table->timestamps();

            $table->integer('booking_id')
                ->unsigned()
                ->default(1);
            $table->foreign('bookings')
                ->references('booking_id')
                ->on('trainings')
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
        Schema::dropIfExists('trainings');
    }
}
