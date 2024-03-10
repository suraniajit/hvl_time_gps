<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('hvl_customer_master', function (Blueprint $table) {
        //     $table->id()->change();
        // });
        DB::statement("ALTER TABLE `hvl_customer_master` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT");
        // ALTER TABLE `hvl_customer_master` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

        Schema::create('audit_report', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->enum('audit_type',['planned','adhoc']);
            $table->string('schedule_notes',500)->nullable();
            $table->enum('generated',['yes','no'])->default('no');
            $table->timestamp('schedule_date');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('hvl_customer_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_report');
    }
}
