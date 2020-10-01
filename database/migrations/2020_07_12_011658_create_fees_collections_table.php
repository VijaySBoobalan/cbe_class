<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_collections', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->string('class_id');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('class_sections')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('fee_group_id')->unsigned();
            $table->foreign('fee_group_id')->references('id')->on('fees_groups')->onUpdate('cascade')->onDelete('cascade');;
            $table->string('amount');
            $table->string('balance')->nullable();
            $table->string('discount_group')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('fine')->nullable();
            $table->string('payment_method');
            $table->string('payment_type')->nullable();
            $table->string('payment_given_type')->nullable();
            $table->longText('note')->nullable();
            $table->longText('bank_name')->nullable();
            $table->longText('cheque_number')->nullable();
            $table->longText('dd_number')->nullable();
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
        Schema::dropIfExists('fees_collections');
    }
}
