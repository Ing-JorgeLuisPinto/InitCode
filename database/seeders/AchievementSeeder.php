<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'Primera línea',
                'description' => 'Has completado tu primer ejercicio con éxito.',
                'icon' => '⭐',
                'condition_type' => 'exercises_completed',
                'condition_value' => 1,
            ],
            [
                'name' => 'En racha',
                'description' => 'Mantén una racha de 3 días aprendiendo.',
                'icon' => '🔥',
                'condition_type' => 'streak_days',
                'condition_value' => 3,
            ],
            [
                'name' => 'Semana perfecta',
                'description' => 'Mantén una racha de 7 días aprendiendo.',
                'icon' => '🏆',
                'condition_type' => 'streak_days',
                'condition_value' => 7,
            ],
            [
                'name' => 'Velocista',
                'description' => 'Completaste un ejercicio correctamente en tu primer intento.',
                'icon' => '⚡',
                'condition_type' => 'first_try_correct',
                'condition_value' => 1,
            ],
            [
                'name' => 'Explorador',
                'description' => 'Has comenzado al menos 3 cursos diferentes.',
                'icon' => '🗺️',
                'condition_type' => 'courses_started',
                'condition_value' => 3,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
