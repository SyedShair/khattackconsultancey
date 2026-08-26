<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class ContactMessage extends Model
{
    use LogsActivity;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
    ];

    public const STATUSES = [
        'new'     => 'New',
        'read'    => 'Read',
        'replied' => 'Replied',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}