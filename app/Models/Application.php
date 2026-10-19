<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class Application extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'vacancy_id',
        'name',
        'email',
        'phone',
        'resume',
        'cover_letter',
        'current_location',
        'highest_qualification',
        'years_experience',
        'right_to_work',
        'requires_sponsorship',
        'suitability',
        'declaration_accepted',
        'declaration_accepted_at',
        'status',
    ];

    protected $casts = [
        'right_to_work'           => 'boolean',
        'requires_sponsorship'    => 'boolean',
        'declaration_accepted'    => 'boolean',
        'declaration_accepted_at' => 'datetime',
    ];

    public const STATUSES = [
        'pending'     => 'Pending',
        'reviewed'    => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'rejected'    => 'Rejected',
        'hired'       => 'Hired',
    ];

    // Option lists used by the application form, validation and the PDF
    public const QUALIFICATIONS = [
        'masters'   => "Master's Degree",
        'bachelors' => "Bachelor's Degree",
        'phd'       => 'PhD',
        'other'     => 'Other',
    ];

    public const EXPERIENCE = [
        'lt1'   => 'Less than 1 year',
        '1-3'   => '1-3 years',
        '3-5'   => '3-5 years',
        '5plus' => 'More than 5 years',
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