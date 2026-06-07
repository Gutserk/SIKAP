<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Models\Respondent;
use App\Models\Submission;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Get the first survey, or create one if none exist
        $survey = Survey::first();
        
        if (!$survey) {
            $survey = Survey::create([
                'admin_id' => 1,
                'title' => 'Survei Kepuasan Masyarakat (Data Dummy)',
                'description' => 'Ini adalah survei dummy untuk melihat detail analitik dan tabel responden.',
                'status' => 'active',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
            ]);
        }

        // --- 1. SEED QUESTIONS ---
        // Clean existing questions for this survey to avoid duplicates
        $survey->questions()->delete();

        $q1 = Question::create([
            'survey_id' => $survey->id,
            'question_text' => 'Bagaimana penilaian Anda terhadap kecepatan pelayanan kami?',
            'question_type' => 'multiple_choice',
            'is_required' => true,
            'order' => 1,
        ]);
        $optionsQ1 = [
            Option::create(['question_id' => $q1->id, 'option_text' => 'Sangat Cepat', 'order' => 1]),
            Option::create(['question_id' => $q1->id, 'option_text' => 'Cepat', 'order' => 2]),
            Option::create(['question_id' => $q1->id, 'option_text' => 'Lambat', 'order' => 3]),
            Option::create(['question_id' => $q1->id, 'option_text' => 'Sangat Lambat', 'order' => 4]),
        ];

        $q2 = Question::create([
            'survey_id' => $survey->id,
            'question_text' => 'Apakah informasi yang diberikan oleh petugas sudah jelas?',
            'question_type' => 'multiple_choice',
            'is_required' => true,
            'order' => 2,
        ]);
        $optionsQ2 = [
            Option::create(['question_id' => $q2->id, 'option_text' => 'Sangat Jelas', 'order' => 1]),
            Option::create(['question_id' => $q2->id, 'option_text' => 'Jelas', 'order' => 2]),
            Option::create(['question_id' => $q2->id, 'option_text' => 'Kurang Jelas', 'order' => 3]),
        ];

        $q3 = Question::create([
            'survey_id' => $survey->id,
            'question_text' => 'Apa saran Anda untuk peningkatan layanan kami?',
            'question_type' => 'essay',
            'is_required' => false,
            'order' => 3,
        ]);


        // --- 2. SEED RESPONDENTS & SUBMISSIONS ---
        // Create 25 dummy submissions
        for ($i = 0; $i < 25; $i++) {
            $email = $faker->userName . '@batam.go.id';
            
            $respondent = Respondent::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $faker->name,
                    'gender' => $faker->randomElement(['M', 'F']),
                    'education' => $faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
                    'age' => $faker->numberBetween(18, 60),
                    'created_at' => now()
                ]
            );

            $submission = Submission::create([
                'survey_id' => $survey->id,
                'respondent_id' => $respondent->id,
                'submitted_at' => $faker->dateTimeBetween('-10 days', 'now'),
            ]);

            // Answer Q1
            Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $q1->id,
                'option_id' => $faker->randomElement($optionsQ1)->id,
                'answer_text' => null,
            ]);

            // Answer Q2
            Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $q2->id,
                'option_id' => $faker->randomElement($optionsQ2)->id,
                'answer_text' => null,
            ]);

            // Answer Q3 (Essay - 50% chance to answer)
            if (rand(1, 100) > 50) {
                Answer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $q3->id,
                    'option_id' => null,
                    'answer_text' => $faker->sentence(),
                ]);
            }
        }
    }
}
