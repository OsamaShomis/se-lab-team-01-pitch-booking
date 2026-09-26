<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TimeSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pitch_id',
        'date',
        'start_time',
        'end_time',
        'price',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the pitch that owns this time slot.
     */
    public function pitch(): BelongsTo
    {
        return $this->belongsTo(Pitch::class);
    }

    /**
     * Get the booking associated with this time slot (if any).
     */
    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

    /**
     * Check if the time slot is available.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if the time slot is in the past.
     */
    public function isPast(): bool
    {
        $slotDateTime = \Carbon\Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->start_time);
        return $slotDateTime->isPast();
    }
}
