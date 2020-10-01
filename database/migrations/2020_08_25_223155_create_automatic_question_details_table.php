<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutomaticQuestionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('automatic_question_details', function (Blueprint $table) {
            $table->id();
            $table->string('automatic_question_id');
            $table->string('chapter_id');
            $table->string('preparation_type_id');
            $table->string('segregation_id');
            $table->string('question_count');
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
        Schema::dropIfExists('automatic_question_details');
    }
}
