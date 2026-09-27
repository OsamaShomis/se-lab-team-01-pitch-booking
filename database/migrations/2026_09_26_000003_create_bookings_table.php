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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('time_slot_id')->constrained('time_slots')->onDelete('restrict');
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['confirmed', 'completed', 'cancelled'])->default('confirmed');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('time_slot_id');
            $table->index('status');
        });

        // Enforce uniqueness for confirmed/active bookings only (allows cancelled slots to be re-booked)
        if (in_array(DB::connection()->getDriverName(), ['sqlite', 'pgsql'])) {
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS bookings_active_slot_unique ON bookings (time_slot_id) WHERE status = 'confirmed'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
