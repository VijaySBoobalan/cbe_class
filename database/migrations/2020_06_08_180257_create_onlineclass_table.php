<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineclassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlineclass', function (Blueprint $table) {
            $table->id();
			$table->string('staff_id')->nullable();
			$table->string('staff_name')->nullable();
            $table->string('session_id')->nullable();
            $table->string('audioroom_id')->nullable();
            $table->string('scheduleclass_id')->nullable();
            $table->string('class_id')->nullable();
            $table->string('section_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('date')->nullable();
            $table->string('count')->nullable();
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('onlineclass');
    }
}
