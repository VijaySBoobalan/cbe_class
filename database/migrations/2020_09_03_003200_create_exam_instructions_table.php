<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_instructions', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('create_question_paper_id')->unsigned();
            $table->foreign('create_question_paper_id')->references('id')->on('create_question_papers')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('segregation_id')->unsigned()->nullable();
            $table->foreign('segregation_id')->references('id')->on('segregations')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('segregation_notes')->nullable();
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
        Schema::dropIfExists('exam_instructions');
    }
}
