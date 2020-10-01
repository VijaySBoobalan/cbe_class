<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineTestSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_test_schedules', function (Blueprint $table) {
            $table->id();
			$table->string('exam_name');
			$table->string('class_id');
			$table->string('section_id');
			$table->string('from_time');
			$table->string('to_time');
			$table->date('from_date');
			$table->date('to_date');
			$table->string('topic');
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
        Schema::dropIfExists('online_test_schedules');
    }
}
