<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\Exercise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $principiante = Level::where('slug', 'principiante')->first();
        $aprendiz = Level::where('slug', 'aprendiz')->first();

        // Course 1
        $course1 = Course::create([
            'title' => 'Introducción a la Programación',
            'slug' => 'introduccion-a-la-programacion',
            'description' => 'Aprende los conceptos más básicos de la informática.',
            'icon' => '💡',
            'order' => 1,
            'level_id' => $principiante->id,
        ]);

        $lessons1 = [
            [
                'title' => '¿Qué es programar?',
                'content' => 'Programar es dar instrucciones a una computadora, como una receta de cocina.',
                'exercise' => [
                    'instructions' => 'Completa la instrucción para que diga Hola Mundo',
                    'starter_code' => "echo '___';",
                    'solution_code' => "echo 'Hola Mundo';",
                    'expected_output' => 'Hola Mundo',
                ]
            ],
            [
                'title' => '¿Qué es un algoritmo?',
                'content' => 'Un algoritmo es una serie de pasos ordenados para resolver un problema.',
                'exercise' => [
                    'instructions' => 'Ordena los pasos: primero declara $pasos=3, luego haz echo $pasos',
                    'starter_code' => "echo \$pasos;\n\$pasos = 3;",
                    'solution_code' => "\$pasos = 3;\necho \$pasos;",
                    'expected_output' => '3',
                ]
            ],
            [
                'title' => 'Variables',
                'content' => 'Una variable es como una caja con nombre donde guardas información.',
                'exercise' => [
                    'instructions' => "Crea una variable llamada \$nombre con el valor 'Ana' y muéstrala",
                    'starter_code' => "\$nombre = ___;\necho \$nombre;",
                    'solution_code' => "\$nombre = 'Ana';\necho \$nombre;",
                    'expected_output' => 'Ana',
                ]
            ],
            [
                'title' => 'Condicionales',
                'content' => 'Un condicional permite que tu programa tome decisiones. Si pasa X, haz Y.',
                'exercise' => [
                    'instructions' => "Completa el if para que muestre 'Mayor de edad' si \$edad es mayor a 18",
                    'starter_code' => "\$edad = 20;\nif(\$edad ___ 18){\n  echo 'Mayor de edad';\n}",
                    'solution_code' => "\$edad = 20;\nif(\$edad > 18){\n  echo 'Mayor de edad';\n}",
                    'expected_output' => 'Mayor de edad',
                ]
            ],
            [
                'title' => 'Tu primer programa',
                'content' => 'Vamos a unir todo lo aprendido en un pequeño programa completo.',
                'exercise' => [
                    'instructions' => "Crea una variable \$saludo con 'Hola CodePath' y muéstrala",
                    'starter_code' => "\$___ = '___';\necho \$saludo;",
                    'solution_code' => "\$saludo = 'Hola CodePath';\necho \$saludo;",
                    'expected_output' => 'Hola CodePath',
                ]
            ],
        ];

        foreach ($lessons1 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course1->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $data['content'],
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);

            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }

        // Course 2
        $course2 = Course::create([
            'title' => 'HTML desde cero',
            'slug' => 'html-desde-cero',
            'description' => 'Aprende a estructurar tus primeras páginas web.',
            'icon' => '🌐',
            'order' => 2,
            'level_id' => $principiante->id,
        ]);

        $lessons2 = [
            [
                'title' => '¿Qué es HTML?',
                'content' => 'HTML es el lenguaje que estructura las páginas web. Es como el esqueleto de una página.',
                'exercise' => [
                    'instructions' => 'Escribe la etiqueta correcta para un título principal',
                    'starter_code' => "<___>Mi primer título</___>",
                    'solution_code' => "<h1>Mi primer título</h1>",
                    'expected_output' => "<h1>Mi primer título</h1>",
                ]
            ],
            [
                'title' => 'Etiquetas básicas',
                'content' => 'Las etiquetas más usadas son h1-h6 para títulos, p para párrafos, y div para contenedores.',
                'exercise' => [
                    'instructions' => "Escribe un párrafo que diga 'Aprendiendo HTML'",
                    'starter_code' => "<___>Aprendiendo HTML</___>",
                    'solution_code' => "<p>Aprendiendo HTML</p>",
                    'expected_output' => "<p>Aprendiendo HTML</p>",
                ]
            ],
            [
                'title' => 'Títulos y párrafos',
                'content' => 'Los títulos van de h1 (más grande) a h6 (más pequeño). Los párrafos usan la etiqueta p.',
                'exercise' => [
                    'instructions' => "Crea un h2 con el texto 'Subtítulo'",
                    'starter_code' => "<___>Subtítulo</___>",
                    'solution_code' => "<h2>Subtítulo</h2>",
                    'expected_output' => "<h2>Subtítulo</h2>",
                ]
            ],
            [
                'title' => 'Enlaces',
                'content' => 'Los enlaces usan la etiqueta a con el atributo href para indicar el destino.',
                'exercise' => [
                    'instructions' => "Completa el enlace que apunte a google.com",
                    'starter_code' => "<a ___='https://google.com'>Ir a Google</a>",
                    'solution_code' => "<a href='https://google.com'>Ir a Google</a>",
                    'expected_output' => "<a href='https://google.com'>Ir a Google</a>",
                ]
            ],
            [
                'title' => 'Tu primera página',
                'content' => 'Una página HTML básica necesita las etiquetas html, head, y body.',
                'exercise' => [
                    'instructions' => "Completa la estructura básica de una página HTML",
                    'starter_code' => "<html>\n  <___>\n    <title>Mi página</title>\n  </___>\n  <body>\n  </body>\n</html>",
                    'solution_code' => "<html>\n  <head>\n    <title>Mi página</title>\n  </head>\n  <body>\n  </body>\n</html>",
                    'expected_output' => "<html>\n  <head>\n    <title>Mi página</title>\n  </head>\n  <body>\n  </body>\n</html>",
                ]
            ],
        ];

        foreach ($lessons2 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course2->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $data['content'],
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);

            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }

        // Course 3
        $course3 = Course::create([
            'title' => 'JavaScript Básico',
            'slug' => 'javascript-basico',
            'description' => 'Añade interactividad a tus proyectos web.',
            'icon' => '⚙️',
            'order' => 3,
            'level_id' => $aprendiz->id,
        ]);

        $lessons3 = [
            [
                'title' => '¿Qué es JavaScript?',
                'content' => 'JavaScript hace que las páginas web sean interactivas. Es como darle vida a una página.',
                'exercise' => [
                    'instructions' => "Escribe un alert que diga 'Hola desde JS'",
                    'starter_code' => "alert('___');",
                    'solution_code' => "alert('Hola desde JS');",
                    'expected_output' => "alert('Hola desde JS');",
                ]
            ],
            [
                'title' => 'Variables en JavaScript',
                'content' => "En JavaScript usamos let para declarar variables. Por ejemplo: let nombre = 'Ana';",
                'exercise' => [
                    'instructions' => "Declara una variable llamada edad con el valor 25",
                    'starter_code' => "___ edad = ___;",
                    'solution_code' => "let edad = 25;",
                    'expected_output' => "let edad = 25;",
                ]
            ],
            [
                'title' => 'Condicionales en JS',
                'content' => 'El if en JavaScript funciona igual que en otros lenguajes. Si la condición es true, ejecuta el bloque.',
                'exercise' => [
                    'instructions' => "Completa el if para que muestre 'Aprobado' si nota >= 60",
                    'starter_code' => "let nota = 75;\nif(nota ___ 60){\n  console.log('Aprobado');\n}",
                    'solution_code' => "let nota = 75;\nif(nota >= 60){\n  console.log('Aprobado');\n}",
                    'expected_output' => "let nota = 75;\nif(nota >= 60){\n  console.log('Aprobado');\n}",
                ]
            ],
            [
                'title' => 'Loops en JS',
                'content' => 'Un loop repite una acción varias veces. El for loop es el más común.',
                'exercise' => [
                    'instructions' => "Completa el loop para que cuente del 1 al 5",
                    'starter_code' => "for(let i=1; i<=___; i++){\n  console.log(i);\n}",
                    'solution_code' => "for(let i=1; i<=5; i++){\n  console.log(i);\n}",
                    'expected_output' => "for(let i=1; i<=5; i++){\n  console.log(i);\n}",
                ]
            ],
            [
                'title' => 'Funciones',
                'content' => 'Una función es un bloque de código con nombre que puedes reutilizar cuando quieras.',
                'exercise' => [
                    'instructions' => "Completa la función saludar que recibe un nombre y muestra 'Hola ' + nombre",
                    'starter_code' => "function ___(___){\n  console.log('Hola ' + nombre);\n}",
                    'solution_code' => "function saludar(nombre){\n  console.log('Hola ' + nombre);\n}",
                    'expected_output' => "function saludar(nombre){\n  console.log('Hola ' + nombre);\n}",
                ]
            ],
        ];

        foreach ($lessons3 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course3->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $data['content'],
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);

            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }
    }
}
