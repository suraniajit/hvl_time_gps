<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumAuditReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_generate_reports', function($table) {
            $table->string('client_name')->nullable;
            $table->string('client_mobile')->nullable;
            $table->string('technical_name')->nullable;
            $table->string('technical_mobile')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_generate_reports', function($table) {
            $table->dropColumn('client_name');
            $table->dropColumn('client_mobile');
            $table->dropColumn('technical_name');
            $table->dropColumn('technical_mobile');
        });
    }
}
