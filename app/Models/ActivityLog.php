<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'properties',
        'ip_address',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public const ACTIONS = [
        'login'   => 'Login',
        'logout'  => 'Logout',
        'created' => 'Created',
        'updated' => 'Updated',
        'deleted' => 'Deleted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Loose polymorphic accessor — subject_type/subject_id aren't a real
     * morph pair (no morph map needed), this just resolves the model
     * instance on demand for display purposes.
     */
    public function getSubjectAttribute()
    {
        if (! $this->subject_type || ! $this->subject_id || ! class_exists($this->subject_type)) {
            return null;
        }

        return $this->subject_type::find($this->subject_id);
    }

    public function getSubjectLabelAttribute(): ?string
    {
        if (! $this->subject_type) {
            return null;
        }

        return class_basename($this->subject_type) . ' #' . $this->subject_id;
    }
}