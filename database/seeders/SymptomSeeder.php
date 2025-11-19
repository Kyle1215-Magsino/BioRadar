<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Symptom;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symptoms = [
            // Respiratory Symptoms
            ['name' => 'Persistent Cough', 'description' => 'Cough lasting more than 3 weeks', 'category' => 'Respiratory', 'risk_weight' => 7],
            ['name' => 'Coughing Blood', 'description' => 'Blood in sputum or coughing up blood', 'category' => 'Respiratory', 'risk_weight' => 9],
            ['name' => 'Shortness of Breath', 'description' => 'Difficulty breathing or breathlessness', 'category' => 'Respiratory', 'risk_weight' => 6],
            ['name' => 'Chest Pain', 'description' => 'Pain in chest area', 'category' => 'Respiratory', 'risk_weight' => 7],
            ['name' => 'Wheezing', 'description' => 'Whistling sound when breathing', 'category' => 'Respiratory', 'risk_weight' => 4],
            
            // Digestive Symptoms
            ['name' => 'Unexplained Weight Loss', 'description' => 'Losing weight without trying', 'category' => 'General', 'risk_weight' => 8],
            ['name' => 'Loss of Appetite', 'description' => 'Not feeling hungry or loss of interest in food', 'category' => 'Digestive', 'risk_weight' => 5],
            ['name' => 'Difficulty Swallowing', 'description' => 'Trouble swallowing food or liquids', 'category' => 'Digestive', 'risk_weight' => 7],
            ['name' => 'Abdominal Pain', 'description' => 'Persistent pain in stomach area', 'category' => 'Digestive', 'risk_weight' => 6],
            ['name' => 'Blood in Stool', 'description' => 'Rectal bleeding or blood in bowel movements', 'category' => 'Digestive', 'risk_weight' => 9],
            ['name' => 'Change in Bowel Habits', 'description' => 'Persistent diarrhea or constipation', 'category' => 'Digestive', 'risk_weight' => 6],
            ['name' => 'Nausea and Vomiting', 'description' => 'Persistent nausea or vomiting', 'category' => 'Digestive', 'risk_weight' => 4],
            
            // Skin Changes
            ['name' => 'New Mole or Skin Change', 'description' => 'New mole or changes to existing mole', 'category' => 'Skin', 'risk_weight' => 7],
            ['name' => 'Non-healing Sore', 'description' => 'Sore that does not heal', 'category' => 'Skin', 'risk_weight' => 8],
            ['name' => 'Skin Discoloration', 'description' => 'Unusual changes in skin color', 'category' => 'Skin', 'risk_weight' => 5],
            
            // General Symptoms
            ['name' => 'Persistent Fatigue', 'description' => 'Extreme tiredness that does not improve with rest', 'category' => 'General', 'risk_weight' => 5],
            ['name' => 'Unexplained Fever', 'description' => 'Recurring fever without obvious cause', 'category' => 'General', 'risk_weight' => 5],
            ['name' => 'Night Sweats', 'description' => 'Severe sweating during sleep', 'category' => 'General', 'risk_weight' => 6],
            ['name' => 'Unexplained Pain', 'description' => 'Persistent pain without clear cause', 'category' => 'General', 'risk_weight' => 6],
            
            // Lumps and Swelling
            ['name' => 'Unusual Lump', 'description' => 'New lump or swelling anywhere on body', 'category' => 'Physical', 'risk_weight' => 8],
            ['name' => 'Swollen Lymph Nodes', 'description' => 'Enlarged lymph nodes', 'category' => 'Physical', 'risk_weight' => 7],
            ['name' => 'Breast Changes', 'description' => 'Changes in breast size, shape, or nipple', 'category' => 'Physical', 'risk_weight' => 8],
            
            // Urinary Symptoms
            ['name' => 'Blood in Urine', 'description' => 'Visible blood in urine', 'category' => 'Urinary', 'risk_weight' => 9],
            ['name' => 'Frequent Urination', 'description' => 'Need to urinate more often than usual', 'category' => 'Urinary', 'risk_weight' => 4],
            ['name' => 'Painful Urination', 'description' => 'Pain or burning during urination', 'category' => 'Urinary', 'risk_weight' => 5],
            
            // Neurological Symptoms
            ['name' => 'Persistent Headaches', 'description' => 'Frequent or severe headaches', 'category' => 'Neurological', 'risk_weight' => 5],
            ['name' => 'Vision Changes', 'description' => 'Blurred vision or other vision problems', 'category' => 'Neurological', 'risk_weight' => 6],
            ['name' => 'Seizures', 'description' => 'Unexplained seizures', 'category' => 'Neurological', 'risk_weight' => 8],
            ['name' => 'Confusion or Memory Loss', 'description' => 'Difficulty thinking or remembering', 'category' => 'Neurological', 'risk_weight' => 6],
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }
    }
}
