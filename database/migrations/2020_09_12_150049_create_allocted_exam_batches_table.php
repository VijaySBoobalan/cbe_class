<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlloctedExamBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocted_exam_batches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exam_management')->onUpdate('cascade')->onDelete('cascade');
			$table->bigInteger('batch_id')->unsigned();
            $table->foreign('batch_id')->references('id')->on('batches')->onUpdate('cascade')->onDelete('cascade');
            $table->string('from_date');
            $table->string('to_date');
            $table->string('password');
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
        Schema::dropIfExists('allocted_exam_batches');
    }
}
