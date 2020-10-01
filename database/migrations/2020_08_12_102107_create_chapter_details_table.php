<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_details', function (Blueprint $table) {
            $table->id();
            $table->string('chapter_id');
            $table->string('chapter_number');
            $table->string('chapter_name');
            $table->string('chapter_hours');
            $table->string('chapter_from');
            $table->string('chapter_to');
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
        Schema::dropIfExists('chapter_details');
    }
}
