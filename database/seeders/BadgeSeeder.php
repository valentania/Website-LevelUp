<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            // Milestone badges
            [
                'name' => 'First Step',
                'slug' => 'first-step',
                'description' => 'Selesaikan mission pertamamu!',
                'icon' => '🚀',
                'color' => '#10b981',
                'type' => 'milestone',
                'required_value' => 1,
                'criteria_json' => ['type' => 'missions_completed', 'value' => 1],
            ],
            [
                'name' => 'Rising Star',
                'slug' => 'rising-star',
                'description' => 'Selesaikan 5 mission. Kamu mulai bersinar!',
                'icon' => '⭐',
                'color' => '#f59e0b',
                'type' => 'milestone',
                'required_value' => 5,
                'criteria_json' => ['type' => 'missions_completed', 'value' => 5],
            ],
            [
                'name' => 'Digital Hero',
                'slug' => 'digital-hero',
                'description' => 'Selesaikan 10 mission. Pahlawan digital sejati!',
                'icon' => '🦸',
                'color' => '#6366f1',
                'type' => 'milestone',
                'required_value' => 10,
                'criteria_json' => ['type' => 'missions_completed', 'value' => 10],
            ],
            [
                'name' => 'Community Champion',
                'slug' => 'community-champion',
                'description' => 'Selesaikan 25 mission. Kontributor legendaris!',
                'icon' => '🏆',
                'color' => '#ec4899',
                'type' => 'milestone',
                'required_value' => 25,
                'criteria_json' => ['type' => 'missions_completed', 'value' => 25],
            ],

            // Category badges
            [
                'name' => 'Design Wizard',
                'slug' => 'design-wizard',
                'description' => 'Selesaikan 5 mission kategori desain.',
                'icon' => '🎨',
                'color' => '#8b5cf6',
                'type' => 'category',
                'required_value' => 5,
                'criteria_json' => ['type' => 'category_completed', 'category' => 'desain-poster', 'value' => 5],
            ],
            [
                'name' => 'Web Builder',
                'slug' => 'web-builder',
                'description' => 'Selesaikan 5 mission kategori landing page.',
                'icon' => '🌐',
                'color' => '#3b82f6',
                'type' => 'category',
                'required_value' => 5,
                'criteria_json' => ['type' => 'category_completed', 'category' => 'landing-page', 'value' => 5],
            ],
            [
                'name' => 'Social Guru',
                'slug' => 'social-guru',
                'description' => 'Selesaikan 5 mission kategori social media.',
                'icon' => '📱',
                'color' => '#f43f5e',
                'type' => 'category',
                'required_value' => 5,
                'criteria_json' => ['type' => 'category_completed', 'category' => 'social-media', 'value' => 5],
            ],
            [
                'name' => 'Data Master',
                'slug' => 'data-master',
                'description' => 'Selesaikan 5 mission kategori Excel.',
                'icon' => '📊',
                'color' => '#22c55e',
                'type' => 'category',
                'required_value' => 5,
                'criteria_json' => ['type' => 'category_completed', 'category' => 'excel', 'value' => 5],
            ],

            // Special badges
            [
                'name'           => '5-Star Performer',
                'slug'           => 'five-star-performer',
                'description'    => 'Raih rata-rata rating ≥ 4.5 dengan minimal 3 mission.',
                'icon'           => '🌟',
                'color'          => '#eab308',
                'type'           => 'special',
                'required_value' => 3,
                'criteria_json'  => ['type' => 'average_rating', 'value' => 4.5, 'min_missions' => 3],
            ],
            [
                'name'           => 'Speed Demon',
                'slug'           => 'speed-demon',
                'description'    => 'Selesaikan mission sebelum deadline.',
                'icon'           => '⚡',
                'color'          => '#f97316',
                'type'           => 'special',
                'required_value' => 1,
                'criteria_json'  => ['type' => 'early_completion', 'value' => 1],
            ],

            // XP Rank badges (Bronze / Silver / Gold / Master)
            [
                'name'           => 'Bronze',
                'slug'           => 'xp-bronze',
                'description'    => 'Kumpulkan 250 XP. Langkah pertama menuju puncak!',
                'icon'           => '🥉',
                'color'          => '#cd7f32',
                'type'           => 'xp_rank',
                'required_value' => 250,
                'criteria_json'  => ['type' => 'total_points', 'value' => 250],
            ],
            [
                'name'           => 'Silver',
                'slug'           => 'xp-silver',
                'description'    => 'Kumpulkan 1.000 XP. Kamu semakin bersinar!',
                'icon'           => '🥈',
                'color'          => '#94A3B8',
                'type'           => 'xp_rank',
                'required_value' => 1000,
                'criteria_json'  => ['type' => 'total_points', 'value' => 1000],
            ],
            [
                'name'           => 'Gold',
                'slug'           => 'xp-gold',
                'description'    => 'Kumpulkan 5.000 XP. Pencapaian luar biasa!',
                'icon'           => '🥇',
                'color'          => '#F59E0B',
                'type'           => 'xp_rank',
                'required_value' => 5000,
                'criteria_json'  => ['type' => 'total_points', 'value' => 5000],
            ],
            [
                'name'           => 'Master',
                'slug'           => 'xp-master',
                'description'    => 'Kumpulkan 10.000 XP. Legenda sesungguhnya!',
                'icon'           => '👑',
                'color'          => '#8B5CF6',
                'type'           => 'xp_rank',
                'required_value' => 10000,
                'criteria_json'  => ['type' => 'total_points', 'value' => 10000],
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['slug' => $badge['slug']],
                $badge
            );
        }
    }
}
