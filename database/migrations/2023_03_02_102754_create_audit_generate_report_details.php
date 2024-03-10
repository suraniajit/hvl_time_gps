<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditGenerateReportDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_generate_report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generate_id');
            $table->string('description',500);
            $table->string('observation',500);
            $table->string('risk',500);
            $table->string('action',500);
            $table->timestamps();
            $table->foreign('generate_id')->references('id')->on('audit_generate_reports')->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_generate_report_details');
    }
}
