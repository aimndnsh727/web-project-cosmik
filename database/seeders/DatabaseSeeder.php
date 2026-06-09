<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a group leader
        $leader = User::factory()->create([
            'name' => 'Leader User',
            'email' => 'leader@example.com',
            'matric_number' => '1111111',
            'expertise_area' => 'Backend & APIs (PHP/Laravel)'
        ]);

        // 2. Create another member
        $member = User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'matric_number' => '2222222',
            'expertise_area' => 'Frontend Design (Vite/Tailwind)'
        ]);

        // 3. Create a third member
        $member2 = User::factory()->create([
            'name' => 'Ahmad Nur Adam',
            'email' => 'adam@example.com',
            'matric_number' => '2414137',
            'expertise_area' => 'Tailwind, Blade template engines'
        ]);

        // 4. Create study groups led by leader
        $group1 = \App\Models\StudyGroup::create([
            'leader_id' => $leader->id,
            'title' => 'Web Application Development BIIT 2305',
            'subj_code' => 'BIIT 2305',
            'description' => 'A collaborative study group focusing on building secure and performant web applications using Laravel, SQLite, and Tailwind CSS. We will cover advanced routing, database design, and blade layout techniques.',
            'venue' => 'Kuliyyah of ICT Lab 4',
            'session_date' => now()->addDays(5)->format('Y-m-d'),
            'session_time' => '14:30:00',
        ]);

        $group2 = \App\Models\StudyGroup::create([
            'leader_id' => $leader->id,
            'title' => 'Database Management Systems INFO 2102',
            'subj_code' => 'INFO 2102',
            'description' => 'Preparation for the upcoming final exams. We will discuss SQL optimization, normal forms, transaction management, and relational algebra questions from past years.',
            'venue' => 'Main Library Study Room 3',
            'session_date' => now()->addDays(12)->format('Y-m-d'),
            'session_time' => '10:00:00',
        ]);

        // 5. Create study group led by member
        $group3 = \App\Models\StudyGroup::create([
            'leader_id' => $member->id,
            'title' => 'Artificial Intelligence & Python Practical',
            'subj_code' => 'INFO 3510',
            'description' => 'Practical coding sessions for AI algorithms. Implementing search algorithms, basic neural networks, and sorting out library dependencies.',
            'venue' => 'KICT Seminar Room 1',
            'session_date' => now()->addDays(3)->format('Y-m-d'),
            'session_time' => '09:00:00',
        ]);

        // 6. Enroll users as members
        $group1->members()->attach([$member->id, $member2->id]);
        $group2->members()->attach([$member2->id]);
        $group3->members()->attach([$leader->id]);
    }
}
