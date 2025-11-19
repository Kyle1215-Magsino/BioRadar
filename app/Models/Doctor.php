<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'license_number',
        'qualifications',
        'phone',
    ];

    /**
     * Get the user that owns the doctor profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assessments assigned to this doctor
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    /**
     * Get the risk evaluations created by this doctor
     */
    public function riskEvaluations()
    {
        return $this->hasMany(RiskEvaluation::class);
    }
}
