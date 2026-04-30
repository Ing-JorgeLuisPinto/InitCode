<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Principiante',
                'slug' => 'principiante',
                'description' => 'Aprende los fundamentos básicos de la programación.',
                'icon' => '🌱',
                'min_xp' => 0,
                'max_xp' => 200,
            ],
            [
                'name' => 'Aprendiz',
                'slug' => 'aprendiz',
                'description' => 'Domina conceptos más complejos y comienza a construir.',
                'icon' => '📚',
                'min_xp' => 201,
                'max_xp' => 500,
            ],
            [
                'name' => 'Intermedio',
                'slug' => 'intermedio',
                'description' => 'Perfecciona tus habilidades con proyectos reales.',
                'icon' => '⚡',
                'min_xp' => 501,
                'max_xp' => 1000,
            ],
            [
                'name' => 'Avanzado',
                'slug' => 'avanzado',
                'description' => 'Conviértete en un experto y domina nuevas tecnologías.',
                'icon' => '🚀',
                'min_xp' => 1001,
                'max_xp' => 9999,
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
