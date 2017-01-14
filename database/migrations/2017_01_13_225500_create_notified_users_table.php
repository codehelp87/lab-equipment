<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notified_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->softDeletes();
            $table->timestamps();

            $table->integer('user_id')
                ->unsigned()
                ->default(1);
            $table->foreign('users')
                ->references('user_id')
                ->on('notified_users')
                ->onDelete('cascade');

            $table->integer('notification_id')
                ->unsigned()
                ->default(1);
            $table->foreign('notifications')
                ->references('notification_id')
                ->on('notified_users')
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
        Schema::dropIfExists('notified_users');
    }
}
