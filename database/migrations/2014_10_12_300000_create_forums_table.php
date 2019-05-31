<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Extensions\Permission\Group;

class CreateForumsTable extends Migration
{
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('order')->default(1);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug');
            $table->string('restrict_read')->nullable();
            $table->string('restrict_write')->default(Group::DEFAULT()->key);
            $table->string('threads_restrict_read')->nullable();
            $table->string('threads_restrict_write')->default(Group::DEFAULT()->key);
            $table->string('threads_restrict_move')->default(Group::MANAGER()->key);
            $table->string('threads_restrict_close')->default(Group::MANAGER()->key);
            $table->integer('threads_fallback_forum_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('forums');
    }
}
