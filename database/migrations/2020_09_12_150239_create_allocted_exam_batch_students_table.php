<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlloctedExamBatchStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocted_exam_batch_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('allocted_exam_batche_id')->unsigned();
            $table->foreign('allocted_exam_batche_id')->references('id')->on('allocted_exam_batches')->onUpdate('cascade')->onDelete('cascade');
			$table->string('student_id');
			$table->string('status')->nullable();
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
        Schema::dropIfExists('allocted_exam_batch_students');
    }
}
