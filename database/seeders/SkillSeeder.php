<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // Design
            ['name' => 'Graphic Design', 'category' => 'design'],
            ['name' => 'Canva', 'category' => 'design'],
            ['name' => 'Adobe Photoshop', 'category' => 'design'],
            ['name' => 'Adobe Illustrator', 'category' => 'design'],
            ['name' => 'Figma', 'category' => 'design'],
            ['name' => 'Video Editing', 'category' => 'design'],

            // Development
            ['name' => 'HTML/CSS', 'category' => 'development'],
            ['name' => 'JavaScript', 'category' => 'development'],
            ['name' => 'WordPress', 'category' => 'development'],
            ['name' => 'PHP', 'category' => 'development'],

            // Marketing
            ['name' => 'Social Media Management', 'category' => 'marketing'],
            ['name' => 'Content Writing', 'category' => 'marketing'],
            ['name' => 'Copywriting', 'category' => 'marketing'],
            ['name' => 'SEO', 'category' => 'marketing'],

            // Data
            ['name' => 'Microsoft Excel', 'category' => 'data'],
            ['name' => 'Google Sheets', 'category' => 'data'],
            ['name' => 'Data Entry', 'category' => 'data'],
            ['name' => 'Google Analytics', 'category' => 'data'],

            // Education
            ['name' => 'Digital Literacy', 'category' => 'education'],
            ['name' => 'Basic Computing', 'category' => 'education'],
            ['name' => 'Online Tools Training', 'category' => 'education'],
        ];

        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill['name'],
                'slug' => Str::slug($skill['name']),
                'category' => $skill['category'],
            ]);
        }
    }
}
