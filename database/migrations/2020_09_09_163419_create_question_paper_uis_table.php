<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionPaperUisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_paper_uis', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('create_question_paper_id')->unsigned();
            $table->foreign('create_question_paper_id')->references('id')->on('create_question_papers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('font_family')->nullable();
            $table->string('font_size')->nullable();
            $table->string('line_spacing')->nullable();
            $table->string('question_spacing')->nullable();
            $table->string('hideregno')->nullable();
            $table->string('hideexamname')->nullable();
            $table->string('hidedate')->nullable();
            $table->string('hidesubject')->nullable();
            $table->string('hidemarks')->nullable();
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
        Schema::dropIfExists('question_paper_uis');
    }
}
