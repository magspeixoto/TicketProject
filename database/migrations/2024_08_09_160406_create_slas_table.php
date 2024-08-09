<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('response_time'); // em minutos
            $table->integer('resolution_time'); // em minutos
            $table->timestamps();
        });
        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('sla_priority', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sla_id')->constrained('slas');
            $table->foreignId('priority_id')->constrained('ticket_priorities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slas');
        Schema::dropIfExists('ticket_priorities');
        Schema::dropIfExists('sla_priority');
    }
};
