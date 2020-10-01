<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
			$table->string('class_id');
			$table->string('homework_type');
			$table->string('student_id')->nullable();
			$table->string('section_id');
			$table->string('homework_date');
			$table->string('submission_date');
			$table->string('estimated_mark');
			$table->string('subject_id');
			$table->string('staff_id');
			$table->string('description');
			$table->string('attachment')->nullable();
			$table->string('evaluated_by')->nullable();
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
        Schema::dropIfExists('homework');
    }
}
