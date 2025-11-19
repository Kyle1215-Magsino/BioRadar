<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'height',
        'weight',
        'bmi',
        'blood_group',
        'medical_history',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    /**
     * Get the user that owns the patient profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assessments for this patient
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    /**
     * Calculate BMI based on height and weight
     */
    public function calculateBmi()
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            $this->bmi = round($this->weight / ($heightInMeters * $heightInMeters), 2);
            $this->save();
        }
    }

    /**
     * Get age from date of birth
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
