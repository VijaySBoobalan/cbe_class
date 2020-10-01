<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_management', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->string('question_from');
            $table->string('exam_type_id');
            $table->string('preperation_type_id');
            $table->string('exam_hours');
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
        Schema::dropIfExists('exam_management');
    }
}
