<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentHomeworkListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_homework_lists', function (Blueprint $table) {
             $table->id();
			$table->string('homework_id');
			$table->string('student_id');
			$table->string('submitted_on');
			$table->string('marks_obtained')->nullable();
			$table->string('homework_attachment')->nullable();
			$table->string('viewed')->nullable();
			$table->string('remarks')->nullable();
			$table->string('evaluated_on')->nullable();
			$table->string('evaluated_by')->nullable();
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
        Schema::dropIfExists('student_homework_lists');
    }
}
