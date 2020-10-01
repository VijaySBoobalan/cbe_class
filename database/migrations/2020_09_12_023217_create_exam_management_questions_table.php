<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamManagementQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_management_questions', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('exam_management_id')->unsigned();
            $table->foreign('exam_management_id')->references('id')->on('exam_management')->onUpdate('cascade')->onDelete('cascade');
			$table->string('segregation_id');
            $table->string('question_id');
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
        Schema::dropIfExists('exam_management_questions');
    }
}
