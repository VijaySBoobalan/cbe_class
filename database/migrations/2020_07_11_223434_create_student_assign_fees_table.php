<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAssignFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_assign_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fee_group_id')->unsigned();
            $table->foreign('fee_group_id')->references('id')->on('fees_groups');
            $table->string('class_id');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('class_sections');
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
        Schema::dropIfExists('student_assign_fees');
    }
}
