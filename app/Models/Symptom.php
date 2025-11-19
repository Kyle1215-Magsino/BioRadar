<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'risk_weight',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'risk_weight' => 'integer',
    ];

    /**
     * Get the assessments that have this symptom
     */
    public function assessments()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_symptoms')
            ->withPivot(['severity', 'duration_days', 'notes'])
            ->withTimestamps();
    }

    /**
     * Scope to get only active symptoms
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
