<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditGenerateReportDetailImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_generate_report_detail_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generate_report_id');
            $table->string('image',500);
            $table->timestamps();
            $table->foreign('generate_report_id')->references('id')->on('audit_generate_report_details')->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_generate_report_detail_images');
    }
}
