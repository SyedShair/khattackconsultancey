<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'English',
                'description' => 'Our English programmes help adults at every level build strong communication skills for daily life, study, and work. From learning your first English words to preparing for advanced language exams, we offer a full pathway that supports your personal goals.',
                'items' => [
                    ['ESOL Skills for Life', 'Develop reading, writing, speaking, and listening for everyday communication.'],
                    ['Functional Skills English', 'Build your English skills for work, study, and life in the UK.'],
                    ['IELTS, SELT Test Preparation', 'Focused training for Home Office English requirements, for visa applications, university admissions and UK residency.'],
                ],
            ],
            [
                'title' => 'Digital & IT Skills',
                'description' => 'Digital confidence opens doors. Our IT and digital skills courses are designed for adults who want to learn computer basics or upgrade their tech abilities for the modern workplace.',
                'items' => [
                    ['Functional Skills Qualification in ICT', null],
                    ['Microsoft Office & Workplace Computing', null],
                ],
            ],
            [
                'title' => 'Vocational Training & Employability',
                'description' => 'Our vocational training courses give you recognised qualifications and the hands-on skills needed to work in health, education, administration, construction and community support.',
                'items' => [
                    ['Health & Medical Care', null],
                    ['Administration & Education', null],
                    ['Health, Safety & Food Hygiene', null],
                    ['Professional Development', null],
                    ['Adults & Children Safeguarding', null],
                    ['Employability Workshops', null],
                ],
            ],
            [
                'title' => 'Enterprise & Creative Skills',
                'description' => 'Our Enterprise & Creative Skills programme helps learners turn their passions into real income opportunities. Whether you love crafting, baking, or design, we\'ll teach you how to build a small business, develop products, and sell your work confidently.',
                'items' => [
                    ['Creative Workshops', null],
                    ['Entrepreneurship & Mentorship', null],
                ],
            ],
        ];

        foreach ($courses as $position => $data) {
            $course = Course::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title'       => $data['title'],
                    'description' => $data['description'],
                    'is_active'   => true,
                    'sort_order'  => $position + 1,
                ]
            );

            $course->items()->delete();

            foreach ($data['items'] as $i => [$title, $description]) {
                $course->items()->create([
                    'title'       => $title,
                    'description' => $description,
                    'sort_order'  => $i,
                ]);
            }
        }
    }
}
