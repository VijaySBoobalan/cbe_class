<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('created_questions', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('create_question_paper_id')->unsigned();
            $table->foreign('create_question_paper_id')->references('id')->on('create_question_papers')->onUpdate('cascade')->onDelete('cascade');
			$table->bigInteger('segregation_id')->unsigned()->nullable();
            $table->foreign('segregation_id')->references('id')->on('segregations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('parent_question_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('created_questions');
    }
}
