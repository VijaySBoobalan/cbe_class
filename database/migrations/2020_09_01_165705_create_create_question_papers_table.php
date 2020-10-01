<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateQuestionPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_question_papers', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->string('blue_print_name')->nullable();
            $table->string('exam_time')->nullable();
            $table->string('subject')->nullable();
            $table->string('marks')->nullable();
            $table->longText('main_note')->nullable();
            $table->longText('footer_note')->nullable();
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
        Schema::dropIfExists('create_question_papers');
    }
}
