<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class ChatSession extends Model
{
     use LogsActivity;
    protected $fillable = [
        'uuid',
        'name',
        'phone',
        'email',
        'query',
        'status',
        'assigned_admin_name',
        'admin_typing_until',
        'last_visitor_message_at',
        'last_admin_read_at',
    ];

    protected $casts = [
        'last_visitor_message_at' => 'datetime',
        'last_admin_read_at'      => 'datetime',
        'admin_typing_until'      => 'datetime',
    ];

    public function getIsAdminTypingAttribute(): bool
    {
        return $this->admin_typing_until && $this->admin_typing_until->isFuture();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    /**
     * True when the visitor has sent something since the admin last
     * opened/read this session — used to bold/highlight it in the inbox.
     */
    public function getHasUnreadAttribute(): bool
    {
        if (! $this->last_visitor_message_at) {
            return false;
        }

        return ! $this->last_admin_read_at
            || $this->last_visitor_message_at->gt($this->last_admin_read_at);
    }
}