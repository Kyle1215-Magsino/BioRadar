<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'doctor_id',
        'risk_percentage',
        'risk_level',
        'evaluation_notes',
        'recommendations',
        'email_sent',
        'email_sent_at',
    ];

    protected $casts = [
        'risk_percentage' => 'decimal:2',
        'email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
    ];

    /**
     * Get the assessment that owns the risk evaluation
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get the doctor who created the risk evaluation
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Automatically determine risk level based on percentage
     */
    public function setRiskPercentageAttribute($value)
    {
        $this->attributes['risk_percentage'] = $value;
        
        if ($value < 25) {
            $this->attributes['risk_level'] = 'low';
        } elseif ($value < 50) {
            $this->attributes['risk_level'] = 'moderate';
        } elseif ($value < 75) {
            $this->attributes['risk_level'] = 'high';
        } else {
            $this->attributes['risk_level'] = 'critical';
        }
    }
}
