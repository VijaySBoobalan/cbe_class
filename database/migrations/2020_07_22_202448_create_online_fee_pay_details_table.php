<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineFeePayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_fee_pay_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fees_collection_id')->unsigned();
            $table->foreign('fees_collection_id')->references('id')->on('fees_collections')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->string('class');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('class_sections')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('fee_group_id')->unsigned();
            $table->foreign('fee_group_id')->references('id')->on('fees_groups')->onUpdate('cascade')->onDelete('cascade');;
            $table->longText('mihpayid');
            $table->longText('txnid');
            $table->longText('hash');
            $table->longText('encryptedPaymentId');
            $table->longText('payment_data');
            $table->string('status');
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
        Schema::dropIfExists('online_fee_pay_details');
    }
}
