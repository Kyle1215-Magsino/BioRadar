<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'assessment_type',
        'additional_notes',
        'status',
        'submitted_at',
        'completed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the assessment
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor assigned to the assessment
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the symptoms associated with this assessment
     */
    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'assessment_symptoms')
            ->withPivot(['severity', 'duration_days', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get the risk evaluation for this assessment
     */
    public function riskEvaluation()
    {
        return $this->hasOne(RiskEvaluation::class);
    }

    /**
     * Scope to get pending assessments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get completed assessments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
