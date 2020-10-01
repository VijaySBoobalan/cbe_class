<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fee_type')->unsigned();
            $table->foreign('fee_type')->references('id')->on('fees_masters');
            $table->string('scholarship_for')->nullable();
            $table->string('due_date');
            $table->string('fine_per_day')->nullable();
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
        Schema::dropIfExists('fees_groups');
    }
}
