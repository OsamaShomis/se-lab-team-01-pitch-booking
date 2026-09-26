<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_reference',
        'user_id',
        'time_slot_id',
        'total_price',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Get the player/user who made this booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the time slot associated with this booking.
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    /**
     * Check if the booking can be cancelled (at least 2 hours before slot per BR-03).
     */
    public function canBeCancelled(): bool
    {
        if ($this->status !== 'confirmed') {
            return false;
        }

        $slot = $this->timeSlot;
        if (!$slot) {
            return false;
        }

        $slotStart = \Carbon\Carbon::parse($slot->date->format('Y-m-d') . ' ' . $slot->start_time);
        return now()->diffInMinutes($slotStart, false) >= 120;
    }
}
