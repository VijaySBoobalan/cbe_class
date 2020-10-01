<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeGroupTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_group_type_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fee_group_type_id')->unsigned();
            $table->foreign('fee_group_type_id')->references('id')->on('fees_groups');
            $table->bigInteger('fee_name_id')->unsigned();
            $table->foreign('fee_name_id')->references('id')->on('fees_types');
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
        Schema::dropIfExists('fee_group_type_details');
    }
}
