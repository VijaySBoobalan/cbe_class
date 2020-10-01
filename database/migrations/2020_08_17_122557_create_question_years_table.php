<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_years', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('chapter_id')->unsigned();
            $table->foreign('chapter_id')->references('id')->on('chapters')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('preparation_type_id')->unsigned();
            $table->foreign('preparation_type_id')->references('id')->on('preparation_types')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('question_type_id')->unsigned();
            $table->foreign('question_type_id')->references('id')->on('question_types')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('segregation_id')->unsigned()->nullable();
            $table->foreign('segregation_id')->references('id')->on('segregations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('year');
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
        Schema::dropIfExists('question_years');
    }
}
