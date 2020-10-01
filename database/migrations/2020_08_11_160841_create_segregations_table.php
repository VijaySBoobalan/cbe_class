<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegregationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segregations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('question_type_id')->unsigned();
            $table->foreign('question_type_id')->references('id')->on('question_types')->onUpdate('cascade')->onDelete('cascade');
            $table->string('segregation');
            $table->string('is_default')->default(0);
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
        Schema::dropIfExists('segregations');
    }
}
