<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutomaticQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('automatic_questions', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('preperation_type');
			$table->string('creating_type');
			$table->string('class');
			$table->string('subject_id');
			$table->string('prepared_staff_id');
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
        Schema::dropIfExists('automatic_questions');
    }
}
