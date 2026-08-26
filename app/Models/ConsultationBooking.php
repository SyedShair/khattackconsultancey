<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ConsultationBooking extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'query',
        'booking_date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public const STATUSES = [
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
        'completed' => 'Completed',
    ];

    public function getFormattedSlotAttribute(): string
    {
        return $this->booking_date->format('D, M j, Y') . ' · '
            . \Illuminate\Support\Carbon::parse($this->start_time)->format('g:i A')
            . ' - ' . \Illuminate\Support\Carbon::parse($this->end_time)->format('g:i A');
    }
}
