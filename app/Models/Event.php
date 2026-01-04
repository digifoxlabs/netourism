<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'form_id',
        'photo_path',
        'start_date',
        'end_date',
        'status',
        'is_active',
        'description',
        'submission_start_date',
        'submission_end_date',
        'fee',
        'auto_close_submission',
        'submission_limit',
        'show_remaining_seats',
        'admin_confirmation_enabled',
        'admin_confirmation_email_template',
        'admin_confirmation_email_subject'
    ];

    protected $dates = ['start_date', 'end_date', 'submission_start_date', 'submission_end_date',];

    protected $casts = [
        'is_active'  => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
        'submission_start_date' => 'date', 
        'submission_end_date' => 'date',
        'auto_close_submission' => 'boolean',
        'show_remaining_seats'  => 'boolean',
        'submission_limit'      => 'integer',
        'admin_confirmation_enabled' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    // computed status
    // public function getStatusAttribute()
    // {
    //     $today = now()->startOfDay();

    //     if ($this->end_date && Carbon::parse($this->end_date)->endOfDay()->lt($today)) {
    //         return 'expired';
    //     }

    //     if ($this->start_date && Carbon::parse($this->start_date)->startOfDay()->gt($today)) {
    //         return 'upcoming';
    //     }

    //     return $this->is_active ? 'active' : 'inactive';
    // }

      /**
     * Dynamically compute status if needed
     */
    public function computeStatus(): string
    {
        $today = Carbon::today();

        if ($this->end_date && $this->end_date->lt($today)) {
            return 'expired';
        }

        if ($this->start_date && $this->start_date->gt($today)) {
            return 'upcoming';
        }

        return 'active';
    }


    /**
     * Total submissions for this event
     */
    public function submissionsCount(): int
    {
        return $this->submissions()->count();
    }

    /**
     * Remaining seats
     */
    public function remainingSeats(): ?int
    {
        if (!$this->auto_close_submission) {
            return null;
        }

        return max(0, $this->submission_limit - $this->submissionsCount());
    }

    /**
     * Check if submissions are open
     */
    public function submissionsOpen(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $today = Carbon::today();

        if ($this->submission_start_date && $today->lt($this->submission_start_date)) {
            return false;
        }

        if ($this->submission_end_date && $today->gt($this->submission_end_date)) {
            return false;
        }

        if ($this->auto_close_submission && $this->submissionsCount() >= $this->submission_limit) {
            return false;
        }

        return true;
    }




}