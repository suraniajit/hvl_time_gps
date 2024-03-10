<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditGenerateReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_generate_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_id');
            $table->timestamp('in_time')->nullable();
            $table->timestamp('out_time')->nullable();;
            $table->string('client_signature')->nullable();
            $table->string('technical_signature')->nullable();
            $table->timestamps();
            $table->foreign('audit_id')->references('id')->on('audit_report')->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_generate_reports');
    }
}
