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
    private function formatContent($explanation, $analogy, $stepByStep, $exactCode, $expectedResult)
    {
        return '<div class="lesson-content space-y-8">
  <div class="explanation-block bg-primary/5 border-l-4 border-primary p-6 rounded-r-2xl">
    <h3 class="text-xl font-bold text-primary mb-2 flex items-center gap-2">📖 ¿Qué vas a aprender?</h3>
    <p class="text-on-surface-variant leading-relaxed">' . $explanation . '</p>
  </div>
  <div class="analogy-block bg-secondary/5 border-l-4 border-secondary p-6 rounded-r-2xl">
    <h3 class="text-xl font-bold text-secondary mb-2 flex items-center gap-2">💡 Piénsalo así</h3>
    <p class="text-on-surface-variant leading-relaxed">' . $analogy . '</p>
  </div>
  <div class="example-block bg-surface-container-high border border-outline-variant p-6 rounded-2xl">
    <h3 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2">✍️ ¿Qué debo escribir?</h3>
    <div class="space-y-4">
        <p class="text-sm text-on-surface-variant">' . $stepByStep . '</p>
        <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant font-mono text-primary">
            <pre><code>' . e($exactCode) . '</code></pre>
        </div>
        <div class="bg-green-500/10 border border-green-500/30 p-4 rounded-xl">
            <p class="text-xs font-bold text-green-400 uppercase tracking-widest mb-1">Resultado esperado</p>
            <p class="text-on-surface">Esto produce: <strong class="text-green-400">' . e($expectedResult) . '</strong></p>
        </div>
    </div>
  </div>
</div>';
    }

    public function run(): void
    {
        $principiante = Level::where('slug', 'principiante')->first();
        $aprendiz = Level::where('slug', 'aprendiz')->first();

        // --- COURSE 1: INTRODUCCIÓN ---
        $course1 = Course::updateOrCreate(
            ['slug' => 'introduccion-a-la-programacion'],
            [
                'title' => 'Introducción a la Programación',
                'description' => 'Aprende los conceptos más básicos de la informática.',
                'icon' => '💡',
                'order' => 1,
                'level_id' => $principiante->id,
            ]
        );

        $lessons1 = [
            // Existing 5 (placeholder content for brevity in seeder logic if needed, but I will provide full definitions)
            [
                'title' => '¿Qué es programar?',
                'explanation' => 'Programar es darle instrucciones a la computadora. Como cuando le dices a alguien paso a paso cómo hacer algo.',
                'analogy' => 'Es como escribir una receta de cocina. Cada línea es un paso que la computadora sigue en orden.',
                'stepByStep' => 'Para mostrar un mensaje en pantalla en PHP escribes echo seguido del texto entre comillas.',
                'exactCode' => "echo 'Hola Mundo';",
                'expectedResult' => 'Hola Mundo',
                'exercise' => [
                    'instructions' => 'Completa la instrucción para que diga Hola Mundo',
                    'starter_code' => "echo '___';",
                    'solution_code' => "echo 'Hola Mundo';",
                    'expected_output' => 'Hola Mundo',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Variables',
                'explanation' => 'Una variable es un espacio con nombre donde guardamos información que puede cambiar.',
                'analogy' => 'Es como una caja con una etiqueta. Puedes guardar un número, un nombre o cualquier dato dentro.',
                'stepByStep' => 'En PHP las variables empiezan con $. Escribes $nombre = "valor";',
                'exactCode' => "\$nombre = 'Ana';\necho \$nombre;",
                'expectedResult' => 'Ana',
                'exercise' => [
                    'instructions' => "Crea una variable llamada \$nombre con el valor 'Ana' y muéstrala",
                    'starter_code' => "\$nombre = ___;\necho \$nombre;",
                    'solution_code' => "\$nombre = 'Ana';\necho \$nombre;",
                    'expected_output' => 'Ana',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Concatenación',
                'explanation' => 'Concatenar es unir dos o más textos para formar uno solo.',
                'analogy' => 'Es como armar un tren uniendo vagones. En PHP usamos un punto (.) para unir los textos.',
                'stepByStep' => 'Usa el punto (.) entre dos strings o variables.',
                'exactCode' => "echo 'Hola' . ' ' . 'Mundo';",
                'expectedResult' => 'Hola Mundo',
                'exercise' => [
                    'instructions' => "Une 'Hola' y 'Mundo' con un punto",
                    'starter_code' => "echo 'Hola' ___ 'Mundo';",
                    'solution_code' => "echo 'Hola' . 'Mundo';",
                    'expected_output' => 'HolaMundo',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Números y Matemáticas',
                'explanation' => 'Las computadoras son excelentes con los números. Puedes hacer cualquier operación matemática directamente.',
                'analogy' => 'PHP funciona como una calculadora super potente.',
                'stepByStep' => 'Escribe los números directamente sin comillas para que PHP los trate como números.',
                'exactCode' => "echo 10 + 5;",
                'expectedResult' => '15',
                'exercise' => [
                    'instructions' => 'Suma 10 + 5',
                    'starter_code' => "echo 10 ___ 5;",
                    'solution_code' => "echo 10 + 5;",
                    'expected_output' => '15',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Comentarios',
                'explanation' => 'Los comentarios son notas para los humanos que la computadora ignora completamente.',
                'analogy' => 'Son como notas adhesivas en un libro que explican algo pero no cambian la historia.',
                'stepByStep' => 'Usa // para comentarios de una sola línea.',
                'exactCode' => "// Esto es un comentario\necho 'Hola';",
                'expectedResult' => 'Hola',
                'exercise' => [
                    'instructions' => 'Agrega un comentario antes del echo usando //',
                    'starter_code' => "___ Mi comentario\necho 'Hola';",
                    'solution_code' => "// Mi comentario\necho 'Hola';",
                    'expected_output' => 'Hola',
                    'xp_reward' => 25
                ]
            ],
            // New Lessons (6-15)
            [
                'title' => 'Tipos de datos',
                'explanation' => 'Los datos pueden ser números, texto, o verdadero/falso. Cada tipo tiene su uso.',
                'analogy' => 'Como en la vida real: tu edad es un número, tu nombre es texto, y si tienes mascota es sí/no.',
                'stepByStep' => 'Usa true o false para valores booleanos.',
                'exactCode' => "\$numero = 42;\n\$texto = 'Hola';\n\$booleano = true;",
                'expectedResult' => 'true',
                'exercise' => [
                    'instructions' => 'Completa el booleano con el valor verdadero',
                    'starter_code' => "\$numero = 42;\n\$texto = 'Hola';\n\$booleano = ___;",
                    'solution_code' => "\$numero = 42;\n\$texto = 'Hola';\n\$booleano = true;",
                    'expected_output' => "true",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Operadores aritméticos',
                'explanation' => 'Los operadores son símbolos para hacer matemáticas: + suma, - resta, * multiplica, / divide, % residuo.',
                'analogy' => 'Son exactamente las matemáticas que ya conoces, pero escritas en código.',
                'stepByStep' => 'El operador % devuelve el residuo de una división.',
                'exactCode' => "\$resultado = 10 % 3;\necho \$resultado;",
                'expectedResult' => '1',
                'exercise' => [
                    'instructions' => 'Usa el operador de residuo (%) para saber cuánto sobra de 10 dividido 3',
                    'starter_code' => "\$resultado = 10 ___ 3;\necho \$resultado;",
                    'solution_code' => "\$resultado = 10 % 3;\necho \$resultado;",
                    'expected_output' => '1',
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Operadores de comparación',
                'explanation' => 'Comparan dos valores y devuelven true o false. == igual, != diferente, > mayor, < menor, >= mayor o igual.',
                'analogy' => 'Es como preguntar: ¿Es este zapato más grande que el otro?',
                'stepByStep' => 'Usa < para verificar si un valor es menor que otro.',
                'exactCode' => "\$a = 5;\n\$b = 10;\necho var_dump(\$a < \$b);",
                'expectedResult' => 'bool(true)',
                'exercise' => [
                    'instructions' => 'Compara si \$a es menor que \$b',
                    'starter_code' => "\$a = 5;\n\$b = 10;\necho var_dump(\$a ___ \$b);",
                    'solution_code' => "\$a = 5;\n\$b = 10;\necho var_dump(\$a < \$b);",
                    'expected_output' => 'bool(true)',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Condicional if/else',
                'explanation' => 'Si la condición es verdadera ejecuta el primer bloque, si no ejecuta el else.',
                'analogy' => 'Como decidir: SI tengo hambre, como. SI NO, sigo trabajando.',
                'stepByStep' => 'Usa la palabra else para el caso contrario.',
                'exactCode' => "\$edad = 15;\nif(\$edad >= 18){\n  echo 'Mayor';\n} else {\n  echo 'Menor';\n}",
                'expectedResult' => 'Menor',
                'exercise' => [
                    'instructions' => 'Completa el bloque else',
                    'starter_code' => "\$edad = 15;\nif(\$edad >= 18){\n  echo 'Mayor';\n} ___ {\n  echo 'Menor';\n}",
                    'solution_code' => "\$edad = 15;\nif(\$edad >= 18){\n  echo 'Mayor';\n} else {\n  echo 'Menor';\n}",
                    'expected_output' => 'Menor',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Condicional else if',
                'explanation' => 'Puedes encadenar múltiples condiciones con else if para manejar más casos.',
                'analogy' => 'Como un semáforo: SI es verde, paso. SI NO, SI es amarillo, precaución. SI NO, paro.',
                'stepByStep' => 'Escribe else if para una segunda condición.',
                'exactCode' => "\$nota = 75;\nif(\$nota >= 90){\n  echo 'Excelente';\n} else if(\$nota >= 60){\n  echo 'Aprobado';\n} else {\n  echo 'Reprobado';\n}",
                'expectedResult' => 'Aprobado',
                'exercise' => [
                    'instructions' => 'Agrega el else if para notas mayores a 60',
                    'starter_code' => "\$nota = 75;\nif(\$nota >= 90){\n  echo 'Excelente';\n} ___ if(\$nota >= 60){\n  echo 'Aprobado';\n} else {\n  echo 'Reprobado';\n}",
                    'solution_code' => "\$nota = 75;\nif(\$nota >= 90){\n  echo 'Excelente';\n} else if(\$nota >= 60){\n  echo 'Aprobado';\n} else {\n  echo 'Reprobado';\n}",
                    'expected_output' => 'Aprobado',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Bucle while',
                'explanation' => 'El while repite un bloque de código mientras una condición sea verdadera.',
                'analogy' => 'Como decir "mientras haya comida en el plato, sigue comiendo".',
                'stepByStep' => 'Usa while seguido de la condición.',
                'exactCode' => "\$i = 1;\nwhile(\$i <= 5){\n  echo \$i . ' ';\n  \$i++;\n}",
                'expectedResult' => '1 2 3 4 5',
                'exercise' => [
                    'instructions' => 'Completa el inicio del bucle while',
                    'starter_code' => "\$i = 1;\n___(\$i <= 5){\n  echo \$i . ' ';\n  \$i++;\n}",
                    'solution_code' => "\$i = 1;\nwhile(\$i <= 5){\n  echo \$i . ' ';\n  \$i++;\n}",
                    'expected_output' => '1 2 3 4 5 ',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Bucle for',
                'explanation' => 'El for es más compacto que el while. Define inicio, condición y paso en una sola línea.',
                'analogy' => 'Es como decir: "Haz 10 flexiones" (ya sabes cuándo empiezas, cuándo terminas y cómo cuentas).',
                'stepByStep' => 'Usa \$i++ para incrementar el contador en cada paso.',
                'exactCode' => "for(\$i = 1; \$i <= 5; \$i++) {\n  echo \$i . ' ';\n}",
                'expectedResult' => '1 2 3 4 5',
                'exercise' => [
                    'instructions' => 'Completa el incremento del bucle for',
                    'starter_code' => "for(\$i = 1; \$i <= 5; ___) {\n  echo \$i . ' ';\n}",
                    'solution_code' => "for(\$i = 1; \$i <= 5; \$i++) {\n  echo \$i . ' ';\n}",
                    'expected_output' => '1 2 3 4 5 ',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Arrays (listas)',
                'explanation' => 'Un array guarda múltiples valores en una sola variable. Se accede a cada elemento por su posición (índice), empezando en 0.',
                'analogy' => 'Como una lista de compras numerada que empieza desde el número 0.',
                'stepByStep' => 'Los índices siempre empiezan en 0.',
                'exactCode' => "\$frutas = ['manzana', 'pera', 'uva'];\necho \$frutas[0];",
                'expectedResult' => 'manzana',
                'exercise' => [
                    'instructions' => 'Accede al primer elemento (índice 0) del array',
                    'starter_code' => "\$frutas = ['manzana', 'pera', 'uva'];\necho \$frutas[___];",
                    'solution_code' => "\$frutas = ['manzana', 'pera', 'uva'];\necho \$frutas[0];",
                    'expected_output' => 'manzana',
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Recorrer arrays con foreach',
                'explanation' => 'El foreach recorre cada elemento de un array automáticamente sin necesidad de índices.',
                'analogy' => 'Como ir repartiendo volantes a cada persona de una fila, uno por uno.',
                'stepByStep' => 'Usa foreach seguido del array as el nombre de la variable temporal.',
                'exactCode' => "\$colores = ['rojo', 'verde', 'azul'];\nforeach (\$colores as \$color) {\n  echo \$color . ' ';\n}",
                'expectedResult' => 'rojo verde azul',
                'exercise' => [
                    'instructions' => 'Usa foreach para recorrer el array de colores',
                    'starter_code' => "\$colores = ['rojo', 'verde', 'azul'];\n___ (\$colores as \$color) {\n  echo \$color . ' ';\n}",
                    'solution_code' => "\$colores = ['rojo', 'verde', 'azul'];\nforeach (\$colores as \$color) {\n  echo \$color . ' ';\n}",
                    'expected_output' => 'rojo verde azul ',
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Funciones',
                'explanation' => 'Una función es un bloque de código reutilizable con nombre. La defines una vez y la llamas cuantas veces quieras.',
                'analogy' => 'Como un botón de una máquina: presionas "hacer café" y la máquina sigue los pasos internos para dártelo.',
                'stepByStep' => 'Usa el nombre de la variable de argumento dentro de la función.',
                'exactCode' => "function saludar(\$nombre) {\n  return 'Hola ' . \$nombre;\n}\necho saludar('Ana');",
                'expectedResult' => 'Hola Ana',
                'exercise' => [
                    'instructions' => 'Completa la función para que use el argumento \$nombre',
                    'starter_code' => "function saludar(\$nombre) {\n  return 'Hola ' . ___;\n}\necho saludar('Ana');",
                    'solution_code' => "function saludar(\$nombre) {\n  return 'Hola ' . \$nombre;\n}\necho saludar('Ana');",
                    'expected_output' => 'Hola Ana',
                    'xp_reward' => 35
                ]
            ],
        ];

        foreach ($lessons1 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course1->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                array_merge($data['exercise'], ['xp_reward' => $data['exercise']['xp_reward'] ?? 25])
            );
        }

        // --- COURSE 2: HTML ---
        $course2 = Course::updateOrCreate(
            ['slug' => 'html-desde-cero'],
            [
                'title' => 'HTML desde cero',
                'description' => 'Domina el lenguaje de las páginas web.',
                'icon' => '🌐',
                'order' => 2,
                'level_id' => $principiante->id,
            ]
        );

        $lessons2 = [
             [
                'title' => '¿Qué es HTML?',
                'explanation' => 'HTML es el lenguaje de marcado que usamos para estructurar las páginas web. Es como el esqueleto de un edificio.',
                'analogy' => 'Imagina que estás construyendo una casa. HTML es la estructura de las paredes, puertas y ventanas.',
                'stepByStep' => 'Usa la etiqueta h1 para crear el título principal de tu página.',
                'exactCode' => '<h1>Mi primera página</h1>',
                'expectedResult' => '<h1>Mi primera página</h1>',
                'exercise' => [
                    'instructions' => 'Crea un título h1 que diga "Mi primera página"',
                    'starter_code' => '<___>Mi primera página</___>',
                    'solution_code' => '<h1>Mi primera página</h1>',
                    'expected_output' => '<h1>Mi primera página</h1>',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Párrafos',
                'explanation' => 'Para añadir texto normal a tu página usamos la etiqueta p de "párrafo".',
                'analogy' => 'Como las líneas de texto en un libro.',
                'stepByStep' => 'Encierra tu texto entre <p> y </p>.',
                'exactCode' => '<p>Hola, este es un párrafo.</p>',
                'expectedResult' => '<p>Hola, este es un párrafo.</p>',
                'exercise' => [
                    'instructions' => 'Crea un párrafo que diga "Hola mundo"',
                    'starter_code' => '<___>Hola mundo</___>',
                    'solution_code' => '<p>Hola mundo</p>',
                    'expected_output' => '<p>Hola mundo</p>',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Enlaces (Links)',
                'explanation' => 'Los enlaces nos permiten navegar de una página a otra. Usamos la etiqueta a con el atributo href.',
                'analogy' => 'Es como una puerta mágica que te lleva instantáneamente a otro lugar.',
                'stepByStep' => 'Usa href="..." para poner la dirección a donde quieres ir.',
                'exactCode' => '<a href="https://google.com">Ir a Google</a>',
                'expectedResult' => '<a href="https://google.com">Ir a Google</a>',
                'exercise' => [
                    'instructions' => 'Completa el atributo para ir a https://google.com',
                    'starter_code' => '<a ___="https://google.com">Ir a Google</a>',
                    'solution_code' => '<a href="https://google.com">Ir a Google</a>',
                    'expected_output' => 'href="https://google.com"',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Etiquetas de cierre',
                'explanation' => 'La mayoría de etiquetas HTML tienen una de apertura y otra de cierre con una barra inclinada /.',
                'analogy' => 'Es como abrir y cerrar un paréntesis o una caja.',
                'stepByStep' => 'Asegúrate de poner la barra / en la etiqueta final.',
                'exactCode' => '<b>Texto en negrita</b>',
                'expectedResult' => '<b>Texto en negrita</b>',
                'exercise' => [
                    'instructions' => 'Cierra correctamente la etiqueta b de negrita',
                    'starter_code' => '<b>Texto en negrita<___b>',
                    'solution_code' => '<b>Texto en negrita</b>',
                    'expected_output' => '</b>',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'El esqueleto básico',
                'explanation' => 'Toda página HTML necesita una estructura mínima: html, head y body.',
                'analogy' => 'Como el cuerpo humano: cabeza (head) para pensar/configurar y cuerpo (body) para lo que se ve.',
                'stepByStep' => 'Todo lo visible va dentro de la etiqueta body.',
                'exactCode' => '<body>Contenido visible</body>',
                'expectedResult' => '<body>Contenido visible</body>',
                'exercise' => [
                    'instructions' => 'Crea la etiqueta body para el contenido',
                    'starter_code' => '<___>Contenido visible</___>',
                    'solution_code' => '<body>Contenido visible</body>',
                    'expected_output' => '<body>Contenido visible</body>',
                    'xp_reward' => 25
                ]
            ],
            // New Lessons (6-15)
            [
                'title' => 'Listas en HTML',
                'explanation' => 'HTML tiene dos tipos de listas: ordenadas (ol) con números y desordenadas (ul) con puntos.',
                'analogy' => 'Como una lista de tareas (desordenada) o los pasos de una receta (ordenada).',
                'stepByStep' => 'Usa ul para listas con puntos.',
                'exactCode' => "<ul>\n  <li>Manzana</li>\n  <li>Pera</li>\n</ul>",
                'expectedResult' => "<ul> <li>Manzana</li> <li>Pera</li> </ul>",
                'exercise' => [
                    'instructions' => 'Crea una lista desordenada (ul)',
                    'starter_code' => "<___>\n  <li>Manzana</li>\n  <li>Pera</li>\n</___>",
                    'solution_code' => "<ul>\n  <li>Manzana</li>\n  <li>Pera</li>\n</ul>",
                    'expected_output' => "<ul> <li>Manzana</li> <li>Pera</li> </ul>",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Imágenes',
                'explanation' => 'La etiqueta img muestra imágenes. Usa src para la ruta y alt para el texto alternativo.',
                'analogy' => 'Es como poner un cuadro en la pared de tu casa digital.',
                'stepByStep' => 'Usa el atributo src para la fuente de la imagen.',
                'exactCode' => "<img src='foto.jpg' alt='Mi foto'>",
                'expectedResult' => "<img src='foto.jpg' alt='Mi foto'>",
                'exercise' => [
                    'instructions' => 'Completa el atributo src',
                    'starter_code' => "<img ___='foto.jpg' alt='Mi foto'>",
                    'solution_code' => "<img src='foto.jpg' alt='Mi foto'>",
                    'expected_output' => "src='foto.jpg'",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Tablas',
                'explanation' => 'Las tablas organizan datos en filas y columnas con table, tr (fila), th (encabezado) y td (celda).',
                'analogy' => 'Como una hoja de Excel o un horario escolar.',
                'stepByStep' => 'Usa th para las celdas de encabezado.',
                'exactCode' => "<table>\n  <tr>\n    <th>Nombre</th>\n    <th>Edad</th>\n  </tr>\n</table>",
                'expectedResult' => "<table> <tr> <th>Nombre</th> <th>Edad</th> </tr> </table>",
                'exercise' => [
                    'instructions' => 'Completa los encabezados de la tabla (th)',
                    'starter_code' => "<table>\n  <tr>\n    <___>Nombre</___>\n    <___>Edad</___>\n  </tr>\n</table>",
                    'solution_code' => "<table>\n  <tr>\n    <th>Nombre</th>\n    <th>Edad</th>\n  </tr>\n</table>",
                    'expected_output' => "<th>Nombre</th> <th>Edad</th>",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Formularios',
                'explanation' => 'Los formularios recopilan datos del usuario. Usan form, input, label y button.',
                'analogy' => 'Como llenar una ficha de inscripción en papel.',
                'stepByStep' => 'Usa el atributo type para definir qué tipo de dato recibe el input.',
                'exactCode' => "<form>\n  <input type='text' name='nombre' placeholder='Tu nombre'>\n  <button>Enviar</button>\n</form>",
                'expectedResult' => "<input type='text'>",
                'exercise' => [
                    'instructions' => 'Define el input como tipo texto',
                    'starter_code' => "<form>\n  <input ___='text' name='nombre' placeholder='Tu nombre'>\n  <button>Enviar</button>\n</form>",
                    'solution_code' => "<form>\n  <input type='text' name='nombre' placeholder='Tu nombre'>\n  <button>Enviar</button>\n</form>",
                    'expected_output' => "type='text'",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Divs y estructura',
                'explanation' => 'El div es un contenedor genérico para agrupar elementos y darles estilo o estructura.',
                'analogy' => 'Como cajas transparentes donde guardas cosas relacionadas.',
                'stepByStep' => 'Usa div para agrupar elementos.',
                'exactCode' => "<div>\n  <h1>Título</h1>\n  <p>Contenido</p>\n</div>",
                'expectedResult' => "<div> ... </div>",
                'exercise' => [
                    'instructions' => 'Envuelve el contenido en un div',
                    'starter_code' => "<___>\n  <h1>Título</h1>\n  <p>Contenido</p>\n</___>",
                    'solution_code' => "<div>\n  <h1>Título</h1>\n  <p>Contenido</p>\n</div>",
                    'expected_output' => "<div> <h1>Título</h1> <p>Contenido</p> </div>",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Atributos class e id',
                'explanation' => 'class e id identifican elementos para aplicarles estilos o comportamiento. id es único, class puede repetirse.',
                'analogy' => 'id es como tu número de identidad (único). class es como tu uniforme (muchos lo pueden usar).',
                'stepByStep' => 'Usa class para identificar grupos de elementos.',
                'exactCode' => "<div class='contenedor'>\n  <p id='intro'>Hola</p>\n</div>",
                'expectedResult' => "class='contenedor' id='intro'",
                'exercise' => [
                    'instructions' => 'Asigna la clase "contenedor" y el id "intro"',
                    'starter_code' => "<div ___='contenedor'>\n  <p ___='intro'>Hola</p>\n</div>",
                    'solution_code' => "<div class='contenedor'>\n  <p id='intro'>Hola</p>\n</div>",
                    'expected_output' => "class='contenedor' id='intro'",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Semántica HTML5',
                'explanation' => 'HTML5 tiene etiquetas con significado: header, nav, main, section, article, footer. Hacen el código más legible.',
                'analogy' => 'Es como usar etiquetas reales en las cajas: "Ropa", "Libros", en lugar de solo "Caja 1", "Caja 2".',
                'stepByStep' => 'Usa header para la parte superior y main para el contenido principal.',
                'exactCode' => "<header>\n  <nav>Menú</nav>\n</header>\n<main>\n  <p>Contenido</p>\n</main>",
                'expectedResult' => "<header> <nav>Menú</nav> </header> <main> <p>Contenido</p> </main>",
                'exercise' => [
                    'instructions' => 'Usa etiquetas semánticas para el encabezado y el contenido principal',
                    'starter_code' => "<___>\n  <nav>Menú</nav>\n</___>\n<___>\n  <p>Contenido</p>\n</___>",
                    'solution_code' => "<header>\n  <nav>Menú</nav>\n</header>\n<main>\n  <p>Contenido</p>\n</main>",
                    'expected_output' => "<header> <nav>Menú</nav> </header> <main> <p>Contenido</p> </main>",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Metaetiquetas',
                'explanation' => 'Las metaetiquetas van en el head y dan información sobre la página al navegador y buscadores.',
                'analogy' => 'Como la ficha técnica de un producto o los metadatos de una foto.',
                'stepByStep' => 'Usa la etiqueta meta.',
                'exactCode' => "<head>\n  <meta charset='UTF-8'>\n  <meta name='description' content='Mi sitio'>\n</head>",
                'expectedResult' => "<meta charset='UTF-8'>",
                'exercise' => [
                    'instructions' => 'Agrega las etiquetas meta necesarias',
                    'starter_code' => "<head>\n  <___ charset='UTF-8'>\n  <___ name='description' content='Mi sitio'>\n</head>",
                    'solution_code' => "<head>\n  <meta charset='UTF-8'>\n  <meta name='description' content='Mi sitio'>\n</head>",
                    'expected_output' => "<meta charset='UTF-8'> <meta name='description' content='Mi sitio'>",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Vincular CSS externo',
                'explanation' => 'Puedes enlazar un archivo CSS externo usando la etiqueta link en el head.',
                'analogy' => 'Como llamar a un decorador de interiores externo para que arregle tu casa.',
                'stepByStep' => 'Usa rel="stylesheet" para indicar que es una hoja de estilo.',
                'exactCode' => "<head>\n  <link rel='stylesheet' href='estilos.css'>\n</head>",
                'expectedResult' => "<link rel='stylesheet'>",
                'exercise' => [
                    'instructions' => 'Vincula el archivo estilos.css',
                    'starter_code' => "<head>\n  <___ rel='stylesheet' href='estilos.css'>\n</head>",
                    'solution_code' => "<head>\n  <link rel='stylesheet' href='estilos.css'>\n</head>",
                    'expected_output' => "<link rel='stylesheet' href='estilos.css'>",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Página completa estructurada',
                'explanation' => 'Una página profesional combina header, nav, main con sections y footer bien organizados.',
                'analogy' => 'Es tu obra maestra final: una casa completa y bien organizada.',
                'stepByStep' => 'Usa <!DOCTYPE html> al inicio de todo.',
                'exactCode' => "<!DOCTYPE html>\n<html lang='es'>\n<head>\n  <meta charset='UTF-8'>\n  <title>Mi Página</title>\n</head>\n<body>\n  <header><h1>Mi Sitio</h1></header>\n  <main><p>Contenido principal</p></main>\n  <footer><p>© 2025</p></footer>\n</body>\n</html>",
                'expectedResult' => "<!DOCTYPE html>",
                'exercise' => [
                    'instructions' => 'Agrega el DOCTYPE y el contenedor main',
                    'starter_code' => "<!DOCTYPE ___>\n<html lang='es'>\n<head>\n  <meta charset='UTF-8'>\n  <title>Mi Página</title>\n</head>\n<body>\n  <header><h1>Mi Sitio</h1></header>\n  <___><p>Contenido principal</p></___>\n  <footer><p>© 2025</p></footer>\n</body>\n</html>",
                    'solution_code' => "<!DOCTYPE html>\n<html lang='es'>\n<head>\n  <meta charset='UTF-8'>\n  <title>Mi Página</title>\n</head>\n<body>\n  <header><h1>Mi Sitio</h1></header>\n  <main><p>Contenido principal</p></main>\n  <footer><p>© 2025</p></footer>\n</body>\n</html>",
                    'expected_output' => "<!DOCTYPE html>",
                    'xp_reward' => 40
                ]
            ],
        ];

        foreach ($lessons2 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course2->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                array_merge($data['exercise'], ['xp_reward' => $data['exercise']['xp_reward'] ?? 25])
            );
        }

        // --- COURSE 3: JAVASCRIPT ---
        $course3 = Course::updateOrCreate(
            ['slug' => 'javascript-basico'],
            [
                'title' => 'JavaScript Básico',
                'description' => 'Aprende a darle vida e interactividad a tus proyectos.',
                'icon' => '⚡',
                'order' => 3,
                'level_id' => $principiante->id,
            ]
        );

        $lessons3 = [
            [
                'title' => '¿Qué es JavaScript?',
                'explanation' => 'JavaScript es el lenguaje que da interactividad a las páginas web. Si HTML es el esqueleto y CSS es la ropa, JS es el cerebro y los músculos.',
                'analogy' => 'Como los sistemas eléctricos de una casa: permiten que las luces se enciendan, que el timbre suene y que el aire acondicionado funcione.',
                'stepByStep' => 'Usa console.log() para imprimir mensajes en la consola del navegador.',
                'exactCode' => "console.log('Hola desde JS');",
                'expectedResult' => 'Hola desde JS',
                'exercise' => [
                    'instructions' => "Muestra 'Hola JS' en la consola",
                    'starter_code' => "console.log('___');",
                    'solution_code' => "console.log('Hola JS');",
                    'expected_output' => 'Hola JS',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Variables (let y const)',
                'explanation' => 'En JS moderno usamos let para variables que cambian y const para constantes que nunca cambian.',
                'analogy' => 'let es como un lápiz (puedes borrar y reescribir). const es como un lapicero permanente.',
                'stepByStep' => 'Usa let seguido del nombre de la variable.',
                'exactCode' => "let puntaje = 100;\nconsole.log(puntaje);",
                'expectedResult' => '100',
                'exercise' => [
                    'instructions' => "Crea una variable llamada puntaje con el valor 100",
                    'starter_code' => "___ puntaje = 100;\nconsole.log(puntaje);",
                    'solution_code' => "let puntaje = 100;\nconsole.log(puntaje);",
                    'expected_output' => '100',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Operaciones Matemáticas',
                'explanation' => 'JavaScript puede realizar cálculos matemáticos complejos de forma instantánea.',
                'analogy' => 'Es como tener una supercomputadora integrada en tu navegador.',
                'stepByStep' => 'Puedes sumar, restar, multiplicar y dividir directamente.',
                'exactCode' => "let total = 50 * 2;\nconsole.log(total);",
                'expectedResult' => '100',
                'exercise' => [
                    'instructions' => 'Multiplica 50 por 2',
                    'starter_code' => "let total = 50 ___ 2;\nconsole.log(total);",
                    'solution_code' => "let total = 50 * 2;\nconsole.log(total);",
                    'expected_output' => '100',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Strings (Cadenas de texto)',
                'explanation' => 'Los strings son secuencias de caracteres encerradas en comillas.',
                'analogy' => 'Como las palabras o frases que escribes en un chat.',
                'stepByStep' => 'Usa comillas simples o dobles.',
                'exactCode' => "let saludo = 'Hola';\nconsole.log(saludo);",
                'expectedResult' => 'Hola',
                'exercise' => [
                    'instructions' => "Asigna el texto 'Hola' a la variable saludo",
                    'starter_code' => "let saludo = ___;",
                    'solution_code' => "let saludo = 'Hola';",
                    'expected_output' => 'Hola',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Alertas',
                'explanation' => 'Una alerta es una ventana emergente que muestra un mensaje al usuario.',
                'analogy' => 'Como un aviso importante que aparece de repente en tu pantalla.',
                'stepByStep' => 'Usa la función alert().',
                'exactCode' => "alert('¡Cuidado!');",
                'expectedResult' => 'Ventana de alerta',
                'exercise' => [
                    'instructions' => "Muestra una alerta con el texto 'Error'",
                    'starter_code' => "___('Error');",
                    'solution_code' => "alert('Error');",
                    'expected_output' => "alert('Error')",
                    'xp_reward' => 25
                ]
            ],
            // New Lessons (6-15)
            [
                'title' => 'Tipos de datos en JS',
                'explanation' => 'JavaScript tiene tipos de datos como Number, String, Boolean, null y undefined.',
                'analogy' => 'Como las diferentes categorías de cosas en tu casa: ropa, comida, herramientas.',
                'stepByStep' => 'Usa typeof para saber el tipo de un dato.',
                'exactCode' => "let booleano = true;\nconsole.log(typeof booleano);",
                'expectedResult' => 'boolean',
                'exercise' => [
                    'instructions' => 'Define booleano como verdadero',
                    'starter_code' => "let numero = 42;\nlet texto = 'Hola';\nlet booleano = ___;\nconsole.log(typeof booleano);",
                    'solution_code' => "let numero = 42;\nlet texto = 'Hola';\nlet booleano = true;\nconsole.log(typeof booleano);",
                    'expected_output' => "boolean",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Operadores en JS',
                'explanation' => 'JS usa operadores similares a otros lenguajes para matemáticas y comparaciones.',
                'analogy' => 'Como los signos que usas en una hoja de papel para hacer cuentas.',
                'stepByStep' => 'El operador % devuelve el residuo.',
                'exactCode' => "let a = 10;\nlet b = 3;\nconsole.log(a % b);",
                'expectedResult' => '1',
                'exercise' => [
                    'instructions' => 'Obtén el residuo de 10 entre 3',
                    'starter_code' => "let a = 10;\nlet b = 3;\nconsole.log(a ___ b);",
                    'solution_code' => "let a = 10;\nlet b = 3;\nconsole.log(a % b);",
                    'expected_output' => "1",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Arrays en JS',
                'explanation' => 'Los arrays en JS son listas ordenadas que pueden guardar cualquier tipo de dato.',
                'analogy' => 'Como una caja de herramientas donde cada compartimento está numerado.',
                'stepByStep' => 'Usa corchetes [ ] para definir el array.',
                'exactCode' => "let frutas = ['manzana', 'pera', 'uva'];\nconsole.log(frutas[1]);",
                'expectedResult' => 'pera',
                'exercise' => [
                    'instructions' => 'Accede al segundo elemento (pera)',
                    'starter_code' => "let frutas = ['manzana', 'pera', 'uva'];\nconsole.log(frutas[___]);",
                    'solution_code' => "let frutas = ['manzana', 'pera', 'uva'];\nconsole.log(frutas[1]);",
                    'expected_output' => "pera",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Métodos de arrays',
                'explanation' => 'Los arrays tienen métodos útiles: push() agrega, pop() elimina el último, length cuenta elementos.',
                'analogy' => 'Como añadir o quitar cosas de tu carrito de compras.',
                'stepByStep' => 'Usa .length para saber cuántos elementos hay.',
                'exactCode' => "let nums = [1, 2, 3];\nnums.push(4);\nconsole.log(nums.length);",
                'expectedResult' => '4',
                'exercise' => [
                    'instructions' => 'Agrega el número 4 al array usando push',
                    'starter_code' => "let nums = [1, 2, 3];\nnums.___(4);\nconsole.log(nums.length);",
                    'solution_code' => "let nums = [1, 2, 3];\nnums.push(4);\nconsole.log(nums.length);",
                    'expected_output' => "4",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Objetos en JS',
                'explanation' => 'Un objeto agrupa propiedades relacionadas. Se accede con punto: objeto.propiedad.',
                'analogy' => 'Como una ficha de persona con nombre, edad y profesión todo junto.',
                'stepByStep' => 'Usa el nombre de la propiedad después del punto.',
                'exactCode' => "let persona = {\n  nombre: 'Ana',\n  edad: 25\n};\nconsole.log(persona.nombre);",
                'expectedResult' => 'Ana',
                'exercise' => [
                    'instructions' => 'Accede a la propiedad nombre del objeto persona',
                    'starter_code' => "let persona = {\n  nombre: 'Ana',\n  edad: 25\n};\nconsole.log(persona.___);",
                    'solution_code' => "let persona = {\n  nombre: 'Ana',\n  edad: 25\n};\nconsole.log(persona.nombre);",
                    'expected_output' => "Ana",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Funciones con return',
                'explanation' => 'Las funciones pueden devolver un valor usando la palabra return.',
                'analogy' => 'Como pedirle a alguien que vaya a la tienda y te traiga (devuelva) el cambio.',
                'stepByStep' => 'Escribe return seguido del valor a devolver.',
                'exactCode' => "function sumar(a, b) {\n  return a + b;\n}\nconsole.log(sumar(3, 4));",
                'expectedResult' => '7',
                'exercise' => [
                    'instructions' => 'Haz que la función devuelva la suma',
                    'starter_code' => "function sumar(a, b) {\n  ___ a + b;\n}\nconsole.log(sumar(3, 4));",
                    'solution_code' => "function sumar(a, b) {\n  return a + b;\n}\nconsole.log(sumar(3, 4));",
                    'expected_output' => "7",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Arrow functions',
                'explanation' => 'Las arrow functions son una forma más corta de escribir funciones en JS moderno.',
                'analogy' => 'Es como usar abreviaturas cuando escribes rápido un mensaje.',
                'stepByStep' => 'Usa => entre los argumentos y el cuerpo.',
                'exactCode' => "const multiplicar = (a, b) => a * b;\nconsole.log(multiplicar(3, 4));",
                'expectedResult' => '12',
                'exercise' => [
                    'instructions' => 'Usa la flecha (=>) para completar la función',
                    'starter_code' => "const multiplicar = (a, b) ___ a * b;\nconsole.log(multiplicar(3, 4));",
                    'solution_code' => "const multiplicar = (a, b) => a * b;\nconsole.log(multiplicar(3, 4));",
                    'expected_output' => "12",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'DOM - Seleccionar elementos',
                'explanation' => 'El DOM es la representación del HTML en JS. Con getElementById puedes seleccionar y modificar elementos.',
                'analogy' => 'Es como tener un control remoto para cada parte de tu página web.',
                'stepByStep' => 'Usa getElementById para buscar por id.',
                'exactCode' => "const titulo = document.getElementById('miTitulo');\ntitulo.textContent = 'Hola Mundo';",
                'expectedResult' => 'Cambio de título',
                'exercise' => [
                    'instructions' => 'Selecciona el elemento con id "miTitulo"',
                    'starter_code' => "const titulo = document.___('miTitulo');\ntitulo.textContent = 'Hola Mundo';",
                    'solution_code' => "const titulo = document.getElementById('miTitulo');\ntitulo.textContent = 'Hola Mundo';",
                    'expected_output' => "getElementById",
                    'xp_reward' => 35
                ]
            ],
            [
                'title' => 'Eventos en JS',
                'explanation' => 'Los eventos reaccionan a acciones del usuario como clicks, teclas o movimientos del mouse.',
                'analogy' => 'Como un timbre que suena cuando alguien presiona el botón.',
                'stepByStep' => 'Usa addEventListener para escuchar un evento.',
                'exactCode' => "const btn = document.getElementById('miBoton');\nbtn.addEventListener(\"click\", function() {\n  alert('¡Hiciste click!');\n});",
                'expectedResult' => 'Evento registrado',
                'exercise' => [
                    'instructions' => 'Agrega un escuchador de eventos para el "click"',
                    'starter_code' => "const btn = document.getElementById('miBoton');\nbtn.___(\"click\", function() {\n  alert('¡Hiciste click!');\n});",
                    'solution_code' => "const btn = document.getElementById('miBoton');\nbtn.addEventListener(\"click\", function() {\n  alert('¡Hiciste click!');\n});",
                    'expected_output' => "addEventListener",
                    'xp_reward' => 35
                ]
            ],
            [
                'title' => 'Fetch y APIs',
                'explanation' => 'fetch() permite hacer peticiones a servidores externos para obtener datos sin recargar la página.',
                'analogy' => 'Como pedir comida por una app: haces el pedido y te lo traen sin que tengas que salir de casa.',
                'stepByStep' => 'Usa fetch seguido de la URL.',
                'exactCode' => "fetch(\"https://api.example.com/datos\")\n  .then(response => response.json())\n  .then(data => console.log(data));",
                'expectedResult' => 'Petición enviada',
                'exercise' => [
                    'instructions' => 'Usa fetch para obtener datos',
                    'starter_code' => "___(\"https://api.example.com/datos\")\n  .then(response => response.json())\n  .then(data => console.log(data));",
                    'solution_code' => "fetch(\"https://api.example.com/datos\")\n  .then(response => response.json())\n  .then(data => console.log(data));",
                    'expected_output' => "fetch",
                    'xp_reward' => 40
                ]
            ],
        ];

        foreach ($lessons3 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course3->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'] ?? 'Sigue las instrucciones.', $data['exactCode'] ?? '', $data['expectedResult'] ?? ''),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                array_merge($data['exercise'], ['xp_reward' => $data['exercise']['xp_reward'] ?? 25])
            );
        }

        // --- COURSE 8: SQL ---
        $course8 = Course::updateOrCreate(
            ['slug' => 'bases-de-datos-con-sql'],
            [
                'title' => 'Bases de Datos con SQL',
                'description' => 'Aprende a guardar y organizar información de forma profesional.',
                'icon' => '🗃️',
                'order' => 8,
                'level_id' => $aprendiz->id,
            ]
        );

        $lessons8 = [
            ['title' => '¿Qué es una base de datos?', 'explanation' => 'Una base de datos es un lugar organizado donde guardas información de forma estructurada para consultarla fácilmente.', 'analogy' => 'Es como una hoja de cálculo de Excel, pero mucho más potente y organizada.', 'starter_code' => "-- Escribe el comando para ver todas las tablas\n___", 'solution_code' => "SHOW TABLES;", 'expected_output' => "show tables;", 'xp_reward' => 10],
            ['title' => 'Crear una tabla', 'explanation' => 'Una tabla en SQL organiza datos en filas y columnas, como una hoja de Excel con tipos de datos definidos.', 'starter_code' => "___ TABLE usuarios (\n  id INT PRIMARY KEY,\n  nombre VARCHAR(100)\n);", 'solution_code' => "CREATE TABLE usuarios (\n  id INT PRIMARY KEY,\n  nombre VARCHAR(100)\n);", 'expected_output' => "create table usuarios", 'xp_reward' => 15],
            ['title' => 'INSERT — Agregar datos', 'explanation' => 'INSERT INTO agrega nuevas filas a una tabla.', 'analogy' => 'Es como agregar una fila nueva a tu hoja de cálculo.', 'starter_code' => "___ INTO usuarios (id, nombre) ___ (1, 'Ana');", 'solution_code' => "INSERT INTO usuarios (id, nombre) VALUES (1, 'Ana');", 'expected_output' => "insert into usuarios", 'xp_reward' => 15],
            ['title' => 'SELECT — Consultar datos', 'explanation' => 'SELECT es el comando más usado en SQL. Sirve para consultar y ver los datos de una tabla.', 'starter_code' => "___ * FROM usuarios;", 'solution_code' => "SELECT * FROM usuarios;", 'expected_output' => "select * from usuarios;", 'xp_reward' => 20],
            ['title' => 'WHERE — Filtrar resultados', 'explanation' => 'WHERE filtra los resultados de una consulta según una condición.', 'analogy' => 'Es como usar el filtro de Excel para ver solo las filas que cumplan una condición.', 'starter_code' => "SELECT * FROM usuarios\n___ nombre = 'Ana';", 'solution_code' => "SELECT * FROM usuarios\nWHERE nombre = 'Ana';", 'expected_output' => "select * from usuarios where nombre = 'ana';", 'xp_reward' => 20],
            ['title' => 'UPDATE — Modificar datos', 'explanation' => 'UPDATE modifica registros existentes en una tabla.', 'starter_code' => "___ usuarios SET nombre = 'Carlos'\nWHERE id = 1;", 'solution_code' => "UPDATE usuarios SET nombre = 'Carlos'\nWHERE id = 1;", 'expected_output' => "update usuarios set nombre", 'xp_reward' => 25],
            ['title' => 'DELETE — Eliminar datos', 'explanation' => 'DELETE elimina filas de una tabla. Siempre usa WHERE para no borrar todo.', 'analogy' => 'Como borrar una fila de Excel, pero sin deshacer posible.', 'starter_code' => "___ FROM usuarios WHERE id = 1;", 'solution_code' => "DELETE FROM usuarios WHERE id = 1;", 'expected_output' => "delete from usuarios", 'xp_reward' => 25],
            ['title' => 'ORDER BY — Ordenar resultados', 'explanation' => 'ORDER BY ordena los resultados de una consulta de forma ascendente (ASC) o descendente (DESC).', 'starter_code' => "SELECT * FROM usuarios\nORDER BY nombre ___;", 'solution_code' => "SELECT * FROM usuarios\nORDER BY nombre ASC;", 'expected_output' => "select * from usuarios order by nombre asc;", 'xp_reward' => 25],
            ['title' => 'LIMIT — Limitar resultados', 'explanation' => 'LIMIT controla cuántas filas devuelve una consulta. Muy útil para paginación.', 'starter_code' => "SELECT * FROM usuarios\nORDER BY id DESC\n___ 5;", 'solution_code' => "SELECT * FROM usuarios\nORDER BY id DESC\nLIMIT 5;", 'expected_output' => "select * from usuarios order by id desc limit 5;", 'xp_reward' => 25],
            ['title' => 'COUNT — Contar registros', 'explanation' => 'COUNT() cuenta cuántas filas hay en una consulta.', 'starter_code' => "SELECT ___(id) FROM usuarios;", 'solution_code' => "SELECT COUNT(id) FROM usuarios;", 'expected_output' => "select count(id) from usuarios;", 'xp_reward' => 30],
            ['title' => 'JOIN — Unir tablas', 'explanation' => 'JOIN une dos tablas relacionadas en una sola consulta.', 'analogy' => 'Como buscar el nombre del cliente en la tabla clientes mientras ves sus pedidos en la tabla pedidos.', 'starter_code' => "SELECT u.nombre, p.producto\nFROM usuarios u\n___ JOIN pedidos p ON u.id = p.usuario_id;", 'solution_code' => "SELECT u.nombre, p.producto\nFROM usuarios u\nINNER JOIN pedidos p ON u.id = p.usuario_id;", 'expected_output' => "inner join pedidos p on u.id = p.usuario_id;", 'xp_reward' => 35],
            ['title' => 'GROUP BY — Agrupar datos', 'explanation' => 'GROUP BY agrupa filas con el mismo valor para hacer cálculos por grupo.', 'starter_code' => "SELECT ciudad, COUNT(*) as total\nFROM usuarios\n___ BY ciudad;", 'solution_code' => "SELECT ciudad, COUNT(*) as total\nFROM usuarios\nGROUP BY ciudad;", 'expected_output' => "group by ciudad;", 'xp_reward' => 35],
            ['title' => 'LIKE — Buscar patrones', 'explanation' => 'LIKE busca texto que coincida con un patrón. % significa cualquier cantidad de caracteres.', 'starter_code' => "SELECT * FROM usuarios\nWHERE nombre ___ 'A%';", 'solution_code' => "SELECT * FROM usuarios\nWHERE nombre LIKE 'A%';", 'expected_output' => "where nombre like 'a%';", 'xp_reward' => 30],
            ['title' => 'Claves foráneas', 'explanation' => 'Una clave foránea (FOREIGN KEY) conecta dos tablas relacionadas para mantener integridad de datos.', 'starter_code' => "CREATE TABLE pedidos (\n  id INT PRIMARY KEY,\n  usuario_id INT,\n  ___ KEY (usuario_id) REFERENCES usuarios(id)\n);", 'solution_code' => "CREATE TABLE pedidos (\n  id INT PRIMARY KEY,\n  usuario_id INT,\n  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)\n);", 'expected_output' => "foreign key (usuario_id) references usuarios(id)", 'xp_reward' => 40],
            ['title' => 'Proyecto final SQL', 'explanation' => 'Combina SELECT, JOIN, WHERE y ORDER BY para hacer una consulta completa real.', 'starter_code' => "SELECT u.nombre, COUNT(p.id) as total_pedidos\nFROM usuarios u\nLEFT ___ pedidos p ON u.id = p.usuario_id\nGROUP BY u.nombre\nORDER BY total_pedidos ___;", 'solution_code' => "SELECT u.nombre, COUNT(p.id) as total_pedidos\nFROM usuarios u\nLEFT JOIN pedidos p ON u.id = p.usuario_id\nGROUP BY u.nombre\nORDER BY total_pedidos DESC;", 'expected_output' => "left join pedidos p on u.id = p.usuario_id", 'xp_reward' => 50],
        ];

        foreach ($lessons8 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course8->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'] ?? 'Piénsalo como organizar datos.', 'Sigue las instrucciones.', $data['solution_code'], $data['expected_output']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                [
                    'instructions' => $data['explanation'],
                    'starter_code' => $data['starter_code'],
                    'solution_code' => $data['solution_code'],
                    'expected_output' => $data['expected_output'],
                    'xp_reward' => $data['xp_reward']
                ]
            );
        }

        // --- COURSE 9: React ---
        $intermedio = Level::where('slug', 'intermedio')->first();
        $course9 = Course::updateOrCreate(
            ['slug' => 'react-para-principiantes'],
            [
                'title' => 'React para Principiantes',
                'description' => 'Construye interfaces modernas con la librería más popular.',
                'icon' => '⚛️',
                'order' => 9,
                'level_id' => $intermedio->id,
            ]
        );

        $lessons9 = [
            ['title' => '¿Qué es React?', 'explanation' => 'React es una librería de JavaScript para construir interfaces de usuario con componentes reutilizables.', 'analogy' => 'Es como tener piezas de LEGO para construir páginas web. Cada pieza es un componente que puedes reusar.', 'starter_code' => "import ___ from 'react';\nfunction App() {\n  return <h1>Hola React</h1>;\n}", 'solution_code' => "import React from 'react';\nfunction App() {\n  return <h1>Hola React</h1>;\n}", 'expected_output' => "import react from 'react';", 'xp_reward' => 15],
            ['title' => 'Componentes', 'explanation' => 'Un componente es una función que devuelve HTML. Es la unidad básica de React.', 'starter_code' => "function ___() {\n  return <div>Mi primer componente</div>;\n}\nexport default Tarjeta;", 'solution_code' => "function Tarjeta() {\n  return <div>Mi primer componente</div>;\n}\nexport default Tarjeta;", 'expected_output' => "function tarjeta()", 'xp_reward' => 15],
            ['title' => 'JSX', 'explanation' => 'JSX es la sintaxis especial de React que mezcla JavaScript con HTML. Se parece al HTML pero tiene diferencias.', 'starter_code' => "function App() {\n  const nombre = 'Ana';\n  return <h1>Hola, {___}</h1>;\n}", 'solution_code' => "function App() {\n  const nombre = 'Ana';\n  return <h1>Hola, {nombre}</h1>;\n}", 'expected_output' => "return <h1>hola, {nombre}</h1>;", 'xp_reward' => 20],
            ['title' => 'Props', 'explanation' => 'Las props son como parámetros que le pasas a un componente para personalizarlo.', 'analogy' => 'Como pasar ingredientes a una receta — la receta es el componente y los ingredientes son las props.', 'starter_code' => "function Saludo({ ___ }) {\n  return <h1>Hola, {nombre}</h1>;\n}\n<Saludo nombre='Ana' />", 'solution_code' => "function Saludo({ nombre }) {\n  return <h1>Hola, {nombre}</h1>;\n}\n<Saludo nombre='Ana' />", 'expected_output' => "function saludo({ nombre })", 'xp_reward' => 25],
            ['title' => 'useState', 'explanation' => 'useState es un hook que permite a un componente recordar información que puede cambiar.', 'analogy' => 'Es como una variable que cuando cambia, React actualiza automáticamente la pantalla.', 'starter_code' => "import { ___ } from 'react';\nfunction Contador() {\n  const [cuenta, setCuenta] = useState(0);\n  return <button onClick={() => setCuenta(cuenta + 1)}>{cuenta}</button>;\n}", 'solution_code' => "import { useState } from 'react';\nfunction Contador() {\n  const [cuenta, setCuenta] = useState(0);\n  return <button onClick={() => setCuenta(cuenta + 1)}>{cuenta}</button>;\n}", 'expected_output' => "import { usestate } from 'react';", 'xp_reward' => 30],
            ['title' => 'useEffect', 'explanation' => 'useEffect ejecuta código cuando el componente se monta o cuando cambia algo. Útil para cargar datos.', 'starter_code' => "import { useState, ___ } from 'react';\nuseEffect(() => {\n  console.log('Componente montado');\n}, []);", 'solution_code' => "import { useState, useEffect } from 'react';\nuseEffect(() => {\n  console.log('Componente montado');\n}, []);", 'expected_output' => "import { usestate, useeffect } from 'react';", 'xp_reward' => 35],
            ['title' => 'Listas en React', 'explanation' => 'Para mostrar listas en React usas el método .map() del array.', 'starter_code' => "const frutas = ['🍎', '🍊', '🍇'];\nreturn (\n  <ul>\n    {frutas.___(fruta => <li key={fruta}>{fruta}</li>)}\n  </ul>\n);", 'solution_code' => "const frutas = ['🍎', '🍊', '🍇'];\nreturn (\n  <ul>\n    {frutas.map(fruta => <li key={fruta}>{fruta}</li>)}\n  </ul>\n);", 'expected_output' => "frutas.map(fruta =>", 'xp_reward' => 30],
            ['title' => 'Eventos', 'explanation' => 'Los eventos en React se escriben en camelCase: onClick, onChange, onSubmit.', 'starter_code' => "function Boton() {\n  function handleClick() {\n    alert('¡Hiciste clic!');\n  }\n  return <button ___={handleClick}>Clic aquí</button>;\n}", 'solution_code' => "function Boton() {\n  function handleClick() {\n    alert('¡Hiciste clic!');\n  }\n  return <button onClick={handleClick}>Clic aquí</button>;\n}", 'expected_output' => "return <button onclick={handleclick}>clic aquí</button>;", 'xp_reward' => 30],
            ['title' => 'Formularios en React', 'explanation' => 'En React los formularios usan estado controlado — el valor del input se guarda en useState.', 'starter_code' => "const [nombre, setNombre] = useState('');\nreturn (\n  <input \n    value={nombre}\n    ___={(e) => setNombre(e.target.value)}\n  />\n);", 'solution_code' => "const [nombre, setNombre] = useState('');\nreturn (\n  <input \n    value={nombre}\n    onChange={(e) => setNombre(e.target.value)}\n  />\n);", 'expected_output' => "onchange={(e) => setnombre(e.target.value)}", 'xp_reward' => 35],
            ['title' => 'Condicionales en JSX', 'explanation' => 'Puedes mostrar elementos condicionalmente usando el operador ternario o &&.', 'starter_code' => "const logueado = true;\nreturn (\n  <div>\n    {logueado ___ <p>Bienvenido</p> : <p>Inicia sesión</p>}\n  </div>\n);", 'solution_code' => "const logueado = true;\nreturn (\n  <div>\n    {logueado ? <p>Bienvenido</p> : <p>Inicia sesión</p>}\n  </div>\n);", 'expected_output' => "{logueado ? <p>bienvenido</p> : <p>inicia sesión</p>}", 'xp_reward' => 30],
            ['title' => 'Componentes hijo', 'explanation' => 'Los componentes pueden contener otros componentes — esto crea una jerarquía de componentes.', 'starter_code' => "function Tarjeta({ titulo, contenido }) {\n  return (\n    <div>\n      <___ texto={titulo} />\n      <p>{contenido}</p>\n    </div>\n  );\n}\nfunction Titulo({ texto }) {\n  return <h2>{texto}</h2>;\n}", 'solution_code' => "function Tarjeta({ titulo, contenido }) {\n  return (\n    <div>\n      <Titulo texto={titulo} />\n      <p>{contenido}</p>\n    </div>\n  );\n}\nfunction Titulo({ texto }) {\n  return <h2>{texto}</h2>;\n}", 'expected_output' => "<titulo texto={titulo} />", 'xp_reward' => 35],
            ['title' => 'Context API', 'explanation' => 'Context API permite compartir datos entre componentes sin pasar props manualmente por cada nivel.', 'starter_code' => "const TemaContext = React.___({});\nfunction App() {\n  return (\n    <TemaContext.Provider value={{ color: 'azul' }}>\n      <Hijo />\n    </TemaContext.Provider>\n  );\n}", 'solution_code' => "const TemaContext = React.createContext({});\nfunction App() {\n  return (\n    <TemaContext.Provider value={{ color: 'azul' }}>\n      <Hijo />\n    </TemaContext.Provider>\n  );\n}", 'expected_output' => "react.createcontext({})", 'xp_reward' => 40],
            ['title' => 'React Router básico', 'explanation' => 'React Router permite navegar entre páginas sin recargar el navegador.', 'starter_code' => "import { BrowserRouter, ___, Route } from 'react-router-dom';\n<BrowserRouter>\n  <Routes>\n    <Route path='/' element={<Inicio />} />\n  </Routes>\n</BrowserRouter>", 'solution_code' => "import { BrowserRouter, Routes, Route } from 'react-router-dom';\n<BrowserRouter>\n  <Routes>\n    <Route path='/' element={<Inicio />} />\n  </Routes>\n</BrowserRouter>", 'expected_output' => "import { browserrouter, routes, route } from 'react-router-dom';", 'xp_reward' => 40],
            ['title' => 'Fetch con useEffect', 'explanation' => 'Combina useEffect y fetch para cargar datos de una API cuando el componente se monta.', 'starter_code' => "useEffect(() => {\n  ___(\"https://api.example.com/datos\")\n    .then(r => r.json())\n    .then(data => setDatos(data));\n}, []);", 'solution_code' => "useEffect(() => {\n  fetch(\"https://api.example.com/datos\")\n    .then(r => r.json())\n    .then(data => setDatos(data));\n}, []);", 'expected_output' => "fetch(\"https://api.example.com/datos\")", 'xp_reward' => 40],
            ['title' => 'Proyecto final React', 'explanation' => 'Crea un componente completo con estado, props, lista y eventos.', 'starter_code' => "function ListaTareas() {\n  const [tareas, setTareas] = ___([]); \n  const [nueva, setNueva] = useState('');\n  function agregar() {\n    setTareas([...tareas, nueva]);\n    setNueva('');\n  }\n  return (\n    <div>\n      <input value={nueva} onChange={e => setNueva(e.target.value)} />\n      <button onClick={agregar}>Agregar</button>\n      <ul>{tareas.map((t, i) => <li key={i}>{t}</li>)}</ul>\n    </div>\n  );\n}", 'solution_code' => "function ListaTareas() {\n  const [tareas, setTareas] = useState([]);\n  const [nueva, setNueva] = useState('');\n  function agregar() {\n    setTareas([...tareas, nueva]);\n    setNueva('');\n  }\n  return (\n    <div>\n      <input value={nueva} onChange={e => setNueva(e.target.value)} />\n      <button onClick={agregar}>Agregar</button>\n      <ul>{tareas.map((t, i) => <li key={i}>{t}</li>)}</ul>\n    </div>\n  );\n}", 'expected_output' => "const [tareas, settareas] = usestate([]);", 'xp_reward' => 50],
        ];

        foreach ($lessons9 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course9->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'] ?? 'Piénsalo como bloques de construcción.', 'Sigue las instrucciones.', $data['solution_code'], $data['expected_output']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                [
                    'instructions' => $data['explanation'],
                    'starter_code' => $data['starter_code'],
                    'solution_code' => $data['solution_code'],
                    'expected_output' => $data['expected_output'],
                    'xp_reward' => $data['xp_reward']
                ]
            );
        }

        // --- COURSE 10: Security ---
        $course10 = Course::updateOrCreate(
            ['slug' => 'seguridad-web-basica'],
            [
                'title' => 'Seguridad Web Básica',
                'description' => 'Aprende a proteger tus aplicaciones de los ataques más comunes.',
                'icon' => '🔐',
                'order' => 10,
                'level_id' => $intermedio->id,
            ]
        );

        $lessons10 = [
            ['title' => '¿Qué es la seguridad web?', 'explanation' => 'La seguridad web protege aplicaciones y usuarios de ataques maliciosos.', 'analogy' => 'Es como poner cerraduras, alarmas y cámaras en tu casa digital.', 'starter_code' => "// ¿Cuál es la práctica MÁS importante en seguridad web?\n// Escribe: validar_entradas", 'solution_code' => "// validar_entradas", 'expected_output' => "// validar_entradas", 'xp_reward' => 10],
            ['title' => 'SQL Injection', 'explanation' => 'SQL Injection ocurre cuando un atacante inyecta código SQL malicioso en un formulario para manipular la base de datos.', 'analogy' => 'Como cuando alguien escribe en un formulario de nombre: \' OR \'1\'=\'1 para engañar al sistema.', 'starter_code' => "// ¿Cómo se previene SQL Injection en Laravel?\n// Escribe: prepared_statements", 'solution_code' => "// prepared_statements", 'expected_output' => "// prepared_statements", 'xp_reward' => 20],
            ['title' => 'XSS - Cross Site Scripting', 'explanation' => 'XSS ocurre cuando un atacante inyecta JavaScript malicioso en una página web que otros usuarios visitan.', 'starter_code' => "// En Blade, ¿qué símbolo escapa automáticamente el HTML?\n// Escribe: {{ doble_llave }}", 'solution_code' => "// {{ doble_llave }}", 'expected_output' => "// {{ doble_llave }}", 'xp_reward' => 20],
            ['title' => 'CSRF Protection', 'explanation' => 'CSRF (Cross-Site Request Forgery) es un ataque donde un sitio malicioso hace peticiones en nombre del usuario. Laravel lo previene con tokens.', 'starter_code' => "<!-- ¿Qué directiva Blade agrega protección CSRF a los formularios? -->\n<form method='POST'>\n  @___\n</form>", 'solution_code' => "<!-- csrf -->\n<form method='POST'>\n  @csrf\n</form>", 'expected_output' => "@csrf", 'xp_reward' => 25],
            ['title' => 'Contraseñas seguras', 'explanation' => 'Las contraseñas nunca deben guardarse en texto plano. Siempre deben encriptarse con hashing.', 'starter_code' => "// En Laravel, ¿qué facade se usa para encriptar contraseñas?\n// Escribe: Hash::make", 'solution_code' => "// Hash::make", 'expected_output' => "// hash::make", 'xp_reward' => 20],
            ['title' => 'HTTPS', 'explanation' => 'HTTPS encripta la comunicación entre el navegador y el servidor. Sin HTTPS, los datos viajan en texto plano y pueden ser interceptados.', 'starter_code' => "// ¿Qué protocolo seguro deben usar los sitios web?\n// Escribe: https", 'solution_code' => "// https", 'expected_output' => "// https", 'xp_reward' => 15],
            ['title' => 'Autenticación vs Autorización', 'explanation' => 'Autenticación verifica QUIÉN eres. Autorización verifica QUÉ puedes hacer.', 'analogy' => 'Autenticación es mostrar tu cédula para entrar al edificio. Autorización es qué pisos puedes visitar.', 'starter_code' => "// En Laravel, ¿qué middleware verifica si el usuario está autenticado?\n// Escribe: auth", 'solution_code' => "// auth", 'expected_output' => "// auth", 'xp_reward' => 20],
            ['title' => 'Validación de entrada', 'explanation' => 'Siempre valida los datos que envían los usuarios antes de procesarlos o guardarlos en la BD.', 'starter_code' => '$request->' . "___([\n  'email' => 'required|email',\n  'password' => 'required|min:8'\n]);", 'solution_code' => '$request->' . "validate([\n  'email' => 'required|email',\n  'password' => 'required|min:8'\n]);", 'expected_output' => '$request->' . "validate([", 'xp_reward' => 25],
            ['title' => 'Headers de seguridad', 'explanation' => 'Los headers HTTP de seguridad protegen contra ataques comunes. X-Frame-Options previene clickjacking.', 'starter_code' => "// ¿Qué header previene que tu sitio sea embebido en un iframe?\n// Escribe: X-Frame-Options", 'solution_code' => "// X-Frame-Options", 'expected_output' => "// x-frame-options", 'xp_reward' => 25],
            ['title' => 'Rate Limiting', 'explanation' => 'Rate limiting limita cuántas peticiones puede hacer un usuario en un tiempo determinado. Previene ataques de fuerza bruta.', 'starter_code' => "// En Laravel routes, ¿qué middleware limita las peticiones?\n// Escribe: throttle", 'solution_code' => "// throttle", 'expected_output' => "// throttle", 'xp_reward' => 25],
            ['title' => 'Principio de mínimo privilegio', 'explanation' => 'Cada usuario y proceso debe tener solo los permisos mínimos necesarios para hacer su trabajo.', 'analogy' => 'Un cajero de banco puede ver saldos de clientes pero no puede cambiarlos sin autorización adicional.', 'starter_code' => "// ¿Qué principio de seguridad dice que los usuarios deben tener solo los permisos necesarios?\n// Escribe: minimo_privilegio", 'solution_code' => "// minimo_privilegio", 'expected_output' => "// minimo_privilegio", 'xp_reward' => 20],
            ['title' => 'Logs y monitoreo', 'explanation' => 'Registrar actividad sospechosa te permite detectar y responder a ataques. Laravel tiene un sistema de logs integrado.', 'starter_code' => "// ¿Qué facade de Laravel se usa para registrar eventos de seguridad?\n// Escribe: Log::warning", 'solution_code' => "// Log::warning", 'expected_output' => "// log::warning", 'xp_reward' => 25],
            ['title' => 'Variables de entorno', 'explanation' => 'Las credenciales y claves secretas NUNCA deben estar en el código. Siempre en variables de entorno (.env).', 'starter_code' => "// ¿En qué archivo de Laravel se guardan las claves secretas?\n// Escribe: .env", 'solution_code' => "// .env", 'expected_output' => "// .env", 'xp_reward' => 20],
            ['title' => 'Backups', 'explanation' => 'Los backups regulares son esenciales para recuperarse de ataques como ransomware o pérdida de datos.', 'starter_code' => "// ¿Cada cuánto se recomienda hacer backup en una app de producción?\n// Escribe: diario", 'solution_code' => "// diario", 'expected_output' => "// diario", 'xp_reward' => 20],
            ['title' => 'Checklist de seguridad', 'explanation' => 'Una aplicación segura combina: HTTPS, validación, hashing, CSRF, logs, backups y mínimo privilegio.', 'starter_code' => "// ¿Cuántos principios de seguridad mencionados debes aplicar?\n// Escribe: todos", 'solution_code' => "// todos", 'expected_output' => "// todos", 'xp_reward' => 30],
        ];

        foreach ($lessons10 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course10->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'] ?? 'Protege tu casa digital.', 'Sigue las instrucciones.', $data['solution_code'], $data['expected_output']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                [
                    'instructions' => $data['explanation'],
                    'starter_code' => $data['starter_code'],
                    'solution_code' => $data['solution_code'],
                    'expected_output' => $data['expected_output'],
                    'xp_reward' => $data['xp_reward']
                ]
            );
        }
    }
}
