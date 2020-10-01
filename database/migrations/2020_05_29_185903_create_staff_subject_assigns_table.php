<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffSubjectAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_subject_assigns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->string('class');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('class_sections');
            $table->bigInteger('subjects')->unsigned();
            $table->foreign('subjects')->references('id')->on('subjects');
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
        Schema::dropIfExists('staff_subject_assigns');
    }
}
