<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Extensions\Permission\Group;

class CreateMultimoderationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimoderations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('restrict_use')->default(Group::ADMINISTRATOR()->key);
            $table->boolean('close_thread')->default(false);
            $table->boolean('delete_thread')->default(false);
            $table->boolean('move_thread_to')->unsigned()->nullable();
            $table->text('auto_reply_thread')->nullable();
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
        Schema::dropIfExists('multimoderations');
    }
}
