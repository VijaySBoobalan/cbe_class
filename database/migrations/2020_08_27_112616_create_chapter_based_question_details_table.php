<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterBasedQuestionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_based_question_details', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('chapter_based_question_id')->unsigned()->nullable();
            $table->foreign('chapter_based_question_id')->references('id')->on('chapter_based_questions')->onUpdate('cascade')->onDelete('cascade');
			$table->bigInteger('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('segregation_id')->unsigned()->nullable();
            $table->foreign('segregation_id')->references('id')->on('segregations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('order_by')->nullable();
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
        Schema::dropIfExists('chapter_based_question_details');
    }
}
