<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fee_type')->unsigned();
            $table->foreign('fee_type')->references('id')->on('fees_masters');
            $table->string('fee_name');
            $table->string('fee_code');
            $table->string('scholarship');
            $table->string('amount');
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
        Schema::dropIfExists('fees_types');
    }
}
