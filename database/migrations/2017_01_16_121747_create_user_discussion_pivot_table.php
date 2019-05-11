<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDiscussionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_discussion', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('thread_id')->unsigned();
            $table->primary(['user_id', 'thread_id']);

            $table->foreign('thread_id')->references('id')->on('threads')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_discussion');
    }
}
