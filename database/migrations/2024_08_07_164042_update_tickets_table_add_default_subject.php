<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('subject')->default('No Subject')->change();
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('subject')->change();
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('sla_id')->constrained('slas');
            $table->foreignId('priority_id')->constrained('ticket_priorities');
        });
    }
};
