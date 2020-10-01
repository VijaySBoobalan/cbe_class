<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_class');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('class_sections');
            $table->date('dob');
            $table->string('country_code', 4)->nullable();
            $table->string('mobile_number')->unique();
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('responsible');
            $table->string('person_name');
            $table->string('person_number');
            $table->date('application_fee_date')->default(date('Y-m-d'));
            $table->integer('status')->default(0);
            $table->integer('online_status')->default(0);
            $table->longText('photo')->nullable();
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
        Schema::dropIfExists('students');
    }
}
