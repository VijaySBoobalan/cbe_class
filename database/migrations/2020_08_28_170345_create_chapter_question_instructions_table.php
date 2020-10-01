<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterQuestionInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_question_instructions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chapter_based_question_id')->unsigned()->nullable();
            $table->foreign('chapter_based_question_id')->references('id')->on('chapter_based_questions')->onUpdate('cascade')->onDelete('cascade');
			$table->string('school_name');
            $table->string('class_id');
            $table->string('hours');
            $table->string('marks');
            $table->string('date');
            $table->longText('instructions');
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
        Schema::dropIfExists('chapter_question_instructions');
    }
}
