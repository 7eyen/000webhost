<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tag_lessons',
            function (Blueprint $table) {
                $table->unsignedInteger('tag_id');
                $table->unsignedInteger('lesson_id');
                //$table->index(['tag_id', 'lesson_id']);
                //$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
                //$table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_lessons');
    }
}
