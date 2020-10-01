<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exam_management')->onUpdate('cascade')->onDelete('cascade');
			$table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
			$table->string('student_id');
			$table->longText('studentanswer')->nullable();
            $table->longText('answer_description')->nullable();
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
        Schema::dropIfExists('student_answers');
    }
}
