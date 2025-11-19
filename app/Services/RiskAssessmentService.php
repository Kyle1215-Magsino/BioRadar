<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\RiskEvaluation;

class RiskAssessmentService
{
    /**
     * Calculate automated risk based on symptoms
     */
    public function calculateAutomatedRisk(Assessment $assessment)
    {
        $symptoms = $assessment->symptoms;
        
        if ($symptoms->isEmpty()) {
            return null;
        }

        $totalRiskScore = 0;
        $maxPossibleScore = 0;
        $severityMultipliers = [
            'mild' => 1.0,
            'moderate' => 1.5,
            'severe' => 2.0,
        ];

        foreach ($symptoms as $symptom) {
            $baseWeight = $symptom->risk_weight;
            $severity = $symptom->pivot->severity ?? 'mild';
            $multiplier = $severityMultipliers[$severity] ?? 1.0;
            
            // Duration factor (symptoms lasting longer are more concerning)
            $durationDays = $symptom->pivot->duration_days ?? 1;
            $durationFactor = min(1.0 + ($durationDays / 30), 2.0); // Cap at 2x
            
            $symptomScore = $baseWeight * $multiplier * $durationFactor;
            $totalRiskScore += $symptomScore;
            $maxPossibleScore += $baseWeight * 2.0 * 2.0; // Max possible per symptom
        }

        // Calculate percentage (normalize to 0-100 scale)
        $riskPercentage = min(($totalRiskScore / max($maxPossibleScore, 1)) * 100, 100);
        
        // Create risk evaluation
        $riskEvaluation = RiskEvaluation::create([
            'assessment_id' => $assessment->id,
            'risk_percentage' => round($riskPercentage, 2),
            'evaluation_notes' => $this->generateAutomatedNotes($symptoms, $riskPercentage),
            'recommendations' => $this->generateAutomatedRecommendations($riskPercentage),
        ]);

        return $riskEvaluation;
    }

    /**
     * Generate automated evaluation notes
     */
    protected function generateAutomatedNotes($symptoms, $riskPercentage)
    {
        $symptomNames = $symptoms->pluck('name')->join(', ');
        
        $notes = "Automated assessment based on reported symptoms: {$symptomNames}. ";
        $notes .= "The system has calculated a risk score of {$riskPercentage}%. ";
        
        if ($riskPercentage < 25) {
            $notes .= "The symptoms appear to be minor and may not indicate serious health concerns.";
        } elseif ($riskPercentage < 50) {
            $notes .= "The symptoms warrant attention and monitoring. Consider consulting a doctor if they persist.";
        } elseif ($riskPercentage < 75) {
            $notes .= "The combination of symptoms is concerning and should be evaluated by a medical professional.";
        } else {
            $notes .= "The symptoms indicate a potentially serious condition. Immediate medical consultation is strongly recommended.";
        }

        return $notes;
    }

    /**
     * Generate automated recommendations
     */
    protected function generateAutomatedRecommendations($riskPercentage)
    {
        if ($riskPercentage < 25) {
            return "Monitor your symptoms. Maintain a healthy lifestyle with proper diet, exercise, and rest. " .
                   "If symptoms worsen or new symptoms develop, consider consulting a healthcare provider.";
        } elseif ($riskPercentage < 50) {
            return "Schedule a consultation with a healthcare provider for a thorough evaluation. " .
                   "Keep track of your symptoms, their frequency, and any changes. " .
                   "Maintain healthy habits and avoid known risk factors.";
        } elseif ($riskPercentage < 75) {
            return "Seek medical attention promptly. Your symptoms require professional evaluation. " .
                   "A doctor may recommend diagnostic tests to determine the underlying cause. " .
                   "Do not delay seeking medical care.";
        } else {
            return "URGENT: Consult a healthcare provider immediately. Your symptoms indicate a potentially serious condition. " .
                   "Request comprehensive diagnostic testing and follow all medical advice. " .
                   "Consider seeking a second opinion if needed.";
        }
    }

    /**
     * Get risk level color for UI display
     */
    public function getRiskLevelColor($riskLevel)
    {
        return match($riskLevel) {
            'low' => 'success',
            'moderate' => 'warning',
            'high' => 'orange',
            'critical' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get risk level badge class
     */
    public function getRiskLevelBadge($riskLevel)
    {
        return match($riskLevel) {
            'low' => 'badge-success',
            'moderate' => 'badge-warning',
            'high' => 'badge-orange',
            'critical' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}
