<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesAssignDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_assign_departments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fee_group_id')->unsigned();
            $table->foreign('fee_group_id')->references('id')->on('fees_groups');
            $table->string('fee_id');
            $table->string('class_id');
            $table->bigInteger('section')->unsigned();
            $table->foreign('section')->references('id')->on('class_sections');
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
        Schema::dropIfExists('fees_assign_departments');
    }
}
