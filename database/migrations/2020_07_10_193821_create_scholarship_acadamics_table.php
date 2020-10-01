<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipAcadamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarship_acadamics', function (Blueprint $table) {
            $table->id();
            $table->string('fee_type');
            $table->string('acadamic_scholarship_name')->nullable();
            $table->string('percentage_from')->nullable();
            $table->string('percentage_to')->nullable();
            $table->string('acadamic_fees_concertion')->nullable();
            $table->string('maintain_percentage')->nullable();
            $table->string('zonal_scholarship_name')->nullable();
            $table->string('zonal_particulars')->nullable();
            $table->string('zonal_fees_concertion')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('scholarship_acadamics');
    }
}
