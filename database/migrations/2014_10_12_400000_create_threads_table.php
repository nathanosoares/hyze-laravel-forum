<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Extensions\Permission\Group;

class CreateThreadsTable extends Migration
{
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forum_id')->unsigned()->default('1');
            $table->string('title');
            $table->integer('user_id')->unsigned();
            $table->string('slug');
            $table->boolean('promoted')->default(false);
            $table->boolean('sticky')->default(false);
            $table->integer('views')->unsigned()->default('0');
            $table->boolean('answered')->default(false);
            $table->timestamp('last_reply_at')->useCurrent();
            $table->string('restrict_read')->default(Group::DEFAULT()->key);
            $table->string('restrict_write')->default(Group::DEFAULT()->key);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('forum_id')->references('id')->on('forums')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('threads');
    }
}
