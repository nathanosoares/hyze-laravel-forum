<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumMultimoderationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_multimoderation_pivot', function (Blueprint $table) {
            $table->integer('forum_id')->unsigned()->index();
            $table->integer('multimoderation_id')->unsigned();
            $table->primary(['forum_id', 'multimoderation_id']);

            $table->foreign('forum_id')->references('id')->on('forums')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('multimoderation_id')->references('id')->on('multimoderations')
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
        Schema::dropIfExists('forum_multimoderation_pivot');
    }
}
