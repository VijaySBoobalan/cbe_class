<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chapter_id')->unsigned();
            $table->foreign('chapter_id')->references('id')->on('chapters')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('preparation_type_id')->unsigned();
            $table->foreign('preparation_type_id')->references('id')->on('preparation_types')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('question_type_id')->unsigned();
            $table->foreign('question_type_id')->references('id')->on('question_types')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('segregation_id')->unsigned()->nullable();
            $table->foreign('segregation_id')->references('id')->on('segregations')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('question_name');
            $table->longText('answer_option')->nullable();
            $table->longText('answer');
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
        Schema::dropIfExists('questions');
    }
}
