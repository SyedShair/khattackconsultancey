<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'name',
        'email',
        'phone',
        'resume',
        'cover_letter',
        'status',
    ];

    public const STATUSES = [
        'pending'     => 'Pending',
        'reviewed'    => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'rejected'    => 'Rejected',
        'hired'       => 'Hired',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    /**
     * True when this was submitted with no open vacancy to apply to
     * (general application: name, email, phone, resume only).
     */
    public function getIsGeneralAttribute(): bool
    {
        return is_null($this->vacancy_id);
    }

    public function resumeExists(): bool
    {
        return Storage::disk('local')->exists($this->resume);
    }
}