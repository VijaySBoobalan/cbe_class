<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffScheduleSubjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_schedule_subject_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staff_schedule_class_id')->unsigned();
            $table->foreign('staff_schedule_class_id')->references('id')->on('staff_schedule_classes');
            $table->string('class');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('class_sections');
            $table->bigInteger('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->bigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->date('subject_day');
            $table->string('from_time');
            $table->string('to_time');
            // $table->softDeletes();
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
        Schema::dropIfExists('staff_schedule_subject_details');
    }
}
