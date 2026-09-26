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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pitch_id')->constrained('pitches')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('price', 8, 2);
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamps();

            $table->unique(['pitch_id', 'date', 'start_time'], 'uq_pitch_date_start');
            $table->index(['pitch_id', 'date', 'status'], 'idx_slots_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
