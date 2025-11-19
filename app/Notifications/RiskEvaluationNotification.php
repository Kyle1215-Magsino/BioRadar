<?php

namespace App\Notifications;

use App\Models\RiskEvaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RiskEvaluationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $riskEvaluation;

    /**
     * Create a new notification instance.
     */
    public function __construct(RiskEvaluation $riskEvaluation)
    {
        $this->riskEvaluation = $riskEvaluation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $evaluation = $this->riskEvaluation;
        $assessment = $evaluation->assessment;
        $doctor = $evaluation->doctor;

        $greeting = "Dear {$notifiable->name},";
        $subject = "BIORADAR: Your Cancer Risk Assessment Results";

        $mail = (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line("Your recent health assessment has been reviewed by Dr. {$doctor->user->name}.");

        // Risk level message
        $riskLevel = ucfirst($evaluation->risk_level);
        $riskPercentage = number_format($evaluation->risk_percentage, 1);
        
        $mail->line("**Risk Level:** {$riskLevel}")
             ->line("**Risk Score:** {$riskPercentage}%");

        // Evaluation notes
        if ($evaluation->evaluation_notes) {
            $mail->line("### Evaluation Notes")
                 ->line($evaluation->evaluation_notes);
        }

        // Recommendations
        if ($evaluation->recommendations) {
            $mail->line("### Recommendations")
                 ->line($evaluation->recommendations);
        }

        // Add urgency based on risk level
        if ($evaluation->risk_level === 'critical' || $evaluation->risk_level === 'high') {
            $mail->line("⚠️ **Important:** Please take these recommendations seriously and seek medical attention promptly.");
        }

        $mail->line("If you have any questions or concerns, please don't hesitate to contact your healthcare provider.")
             ->line("Thank you for using BIORADAR - Early Cancer Detection and Notification System.");

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'risk_evaluation_id' => $this->riskEvaluation->id,
            'assessment_id' => $this->riskEvaluation->assessment_id,
            'risk_percentage' => $this->riskEvaluation->risk_percentage,
            'risk_level' => $this->riskEvaluation->risk_level,
        ];
    }
}
