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
        // Clean up existing content to avoid duplicates
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Course::truncate();
        Lesson::truncate();
        Exercise::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $principiante = Level::where('slug', 'principiante')->first();
        $aprendiz = Level::where('slug', 'aprendiz')->first();

        // --- COURSE 1: INTRODUCCIÓN ---
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
                ]
            ],
        ];

        foreach ($lessons1 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course1->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);
            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }

        // --- COURSE 4: CSS DESDE CERO ---
        $course4 = Course::create([
            'title' => 'CSS desde cero',
            'slug' => 'css-desde-cero',
            'description' => 'Aprende a darle estilo y color a tus páginas.',
            'icon' => '🎨',
            'order' => 4,
            'level_id' => $principiante->id,
        ]);

        $lessons4 = [
            [
                'title' => '¿Qué es CSS?',
                'explanation' => 'CSS es el lenguaje que le da estilo y color a las páginas web. Si HTML es el esqueleto, CSS es la ropa y el maquillaje.',
                'analogy' => 'Imagina una casa (HTML) sin pintar, sin muebles. CSS es lo que la decora y la hace bonita.',
                'stepByStep' => 'Para cambiar el color del texto de un párrafo, usas la propiedad color.',
                'exactCode' => "p {\n  color: red;\n}",
                'expectedResult' => 'p { color: red; }',
                'exercise' => [
                    'instructions' => "Escribe la propiedad CSS para poner el color rojo al texto",
                    'starter_code' => "p {\n  ___: red;\n}",
                    'solution_code' => "p {\n  color: red;\n}",
                    'expected_output' => "p { color: red; }",
                ]
            ],
            [
                'title' => 'Selectores',
                'explanation' => 'Un selector le dice a CSS a qué elemento HTML quieres aplicarle el estilo.',
                'analogy' => 'Es como decir "quiero que TODOS los párrafos sean azules" o "quiero que solo el título sea grande".',
                'stepByStep' => 'Escribe el nombre de la etiqueta seguido de llaves { }.',
                'exactCode' => "h1 {\n  color: blue;\n}",
                'expectedResult' => 'h1 { color: blue; }',
                'exercise' => [
                    'instructions' => "Escribe el selector para aplicar estilo a todos los títulos h1",
                    'starter_code' => "___ {\n  color: blue;\n}",
                    'solution_code' => "h1 {\n  color: blue;\n}",
                    'expected_output' => "h1 { color: blue; }",
                ]
            ],
            [
                'title' => 'Colores y fondos',
                'explanation' => 'CSS puede cambiar el color del texto con color y el fondo con background-color.',
                'analogy' => 'Es como elegir el color de la tinta y el color del papel cuando escribes.',
                'stepByStep' => 'Usa background-color para el fondo.',
                'exactCode' => "body {\n  background-color: black;\n}",
                'expectedResult' => 'body { background-color: black; }',
                'exercise' => [
                    'instructions' => "Agrega un fondo negro al body",
                    'starter_code' => "body {\n  ___: black;\n}",
                    'solution_code' => "body {\n  background-color: black;\n}",
                    'expected_output' => "body { background-color: black; }",
                ]
            ],
            [
                'title' => 'Tamaños y espacios',
                'explanation' => 'Con CSS controlas el tamaño (font-size), el espacio interno (padding) y el espacio externo (margin).',
                'analogy' => 'Es como ajustar el tamaño de la letra y los márgenes de una hoja.',
                'stepByStep' => 'Usa padding para dar espacio dentro del elemento.',
                'exactCode' => "div {\n  padding: 10px;\n}",
                'expectedResult' => 'div { padding: 10px; }',
                'exercise' => [
                    'instructions' => "Agrega un padding de 10px a un div",
                    'starter_code' => "div {\n  ___: 10px;\n}",
                    'solution_code' => "div {\n  padding: 10px;\n}",
                    'expected_output' => "div { padding: 10px; }",
                ]
            ],
            [
                'title' => 'Tu primera página estilizada',
                'explanation' => 'Vamos a combinar todo lo aprendido para darle estilo a una página completa.',
                'analogy' => 'Es como terminar de decorar tu habitación: muebles, pintura y luces en su lugar.',
                'stepByStep' => 'Usa text-align para centrar el texto.',
                'exactCode' => "p {\n  text-align: center;\n}",
                'expectedResult' => 'p { text-align: center; }',
                'exercise' => [
                    'instructions' => "Escribe la propiedad para centrar texto en CSS",
                    'starter_code' => "p {\n  text-___: center;\n}",
                    'solution_code' => "p {\n  text-align: center;\n}",
                    'expected_output' => "p { text-align: center; }",
                ]
            ],
        ];

        foreach ($lessons4 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course4->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);
            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }

        // --- COURSE 5: LÓGICA ---
        $course5 = Course::create([
            'title' => 'Lógica de Programación',
            'slug' => 'logica-de-programacion',
            'description' => 'Aprende a pensar como un programador.',
            'icon' => '🧠',
            'order' => 5,
            'level_id' => $principiante->id,
        ]);

        $lessons5 = [
            [
                'title' => '¿Qué es la lógica?',
                'explanation' => 'La lógica de programación es la habilidad de pensar en pasos ordenados para resolver problemas.',
                'analogy' => 'Es como planear cómo llegar a un lugar: primero salgo de casa, luego tomo el bus, luego camino 2 cuadras.',
                'stepByStep' => 'Usa echo para mostrar resultados de operaciones matemáticas.',
                'exactCode' => "echo 5 + 3;",
                'expectedResult' => '8',
                'exercise' => [
                    'instructions' => "¿Cuánto es 5 + 3? Escribe: echo 5 + 3;",
                    'starter_code' => "echo ___ + ___;",
                    'solution_code' => "echo 5 + 3;",
                    'expected_output' => "8",
                ]
            ],
            [
                'title' => 'Verdadero y Falso',
                'explanation' => 'En programación todo es verdadero (true) o falso (false). Esto se llama valor booleano.',
                'analogy' => 'Como una luz: está encendida (true) o apagada (false). No hay término medio.',
                'stepByStep' => 'Usa el operador > para comparar si un número es mayor que otro.',
                'exactCode' => "echo var_dump(5 > 3);",
                'expectedResult' => 'bool(true)',
                'exercise' => [
                    'instructions' => "Escribe true o false: ¿5 es mayor que 3?",
                    'starter_code' => "echo var_dump(___ > 3);",
                    'solution_code' => "echo var_dump(5 > 3);",
                    'expected_output' => "bool(true)",
                ]
            ],
            [
                'title' => 'Operadores',
                'explanation' => 'Los operadores son símbolos que hacen operaciones: + suma, - resta, * multiplica, / divide, == compara.',
                'analogy' => 'Son como los botones de una calculadora.',
                'stepByStep' => 'Usa * para multiplicar.',
                'exactCode' => "echo 4 * 5;",
                'expectedResult' => '20',
                'exercise' => [
                    'instructions' => "Multiplica 4 por 5 y muestra el resultado",
                    'starter_code' => "echo 4 ___ 5;",
                    'solution_code' => "echo 4 * 5;",
                    'expected_output' => "20",
                ]
            ],
            [
                'title' => 'Decisiones',
                'explanation' => 'Un programa toma decisiones con if/else. Si algo es verdad, hace una cosa; si no, hace otra.',
                'analogy' => 'Como decidir si llevar paraguas: SI llueve, llevo paraguas. SI NO, no lo llevo.',
                'stepByStep' => 'Escribe if seguido de la condición entre paréntesis.',
                'exactCode' => "\$x = 15;\nif(\$x > 10){\n  echo 'grande';\n}",
                'expectedResult' => 'grande',
                'exercise' => [
                    'instructions' => "Completa: si \$x es mayor que 10 muestra 'grande'",
                    'starter_code' => "\$x = 15;\nif(\$x ___ 10){\n  echo 'grande';\n}",
                    'solution_code' => "\$x = 15;\nif(\$x > 10){\n  echo 'grande';\n}",
                    'expected_output' => "grande",
                ]
            ],
            [
                'title' => 'Repetición',
                'explanation' => 'Cuando necesitas hacer algo varias veces, usas un loop. En vez de repetir código, el loop lo hace automáticamente.',
                'analogy' => 'Como decirle a alguien: "Llama a cada persona de la lista y diles hola".',
                'stepByStep' => 'Usa for para repetir una acción un número fijo de veces.',
                'exactCode' => "for(\$i=0; \$i<3; \$i++){\n  echo 'hola ';\n}",
                'expectedResult' => 'hola hola hola',
                'exercise' => [
                    'instructions' => "Completa el loop para repetir 3 veces",
                    'starter_code' => "for(\$i=0; \$i<___; \$i++){\n  echo 'hola ';\n}",
                    'solution_code' => "for(\$i=0; \$i<3; \$i++){\n  echo 'hola ';\n}",
                    'expected_output' => "hola hola hola ",
                ]
            ],
        ];

        foreach ($lessons5 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course5->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);
            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }

        // --- COURSE 6: PYTHON ---
        $course6 = Course::create([
            'title' => 'Python para Principiantes',
            'slug' => 'python-para-principiantes',
            'description' => 'Aprende el lenguaje más popular y versátil.',
            'icon' => '🐍',
            'order' => 6,
            'level_id' => $aprendiz->id,
        ]);

        $lessons6 = [
            [
                'title' => '¿Qué es Python?',
                'explanation' => 'Python es uno de los lenguajes de programación más populares del mundo. Es famoso por ser fácil de leer y escribir.',
                'analogy' => 'Si los lenguajes de programación fueran idiomas humanos, Python sería el español: claro, directo y fácil de aprender.',
                'stepByStep' => 'Usa print() para mostrar mensajes.',
                'exactCode' => "print('Hola Python')",
                'expectedResult' => "Hola Python",
                'exercise' => [
                    'instructions' => "Escribe print('Hola Python') para mostrar un mensaje",
                    'starter_code' => "___('Hola Python')",
                    'solution_code' => "print('Hola Python')",
                    'expected_output' => "print('Hola Python')",
                ]
            ],
            [
                'title' => 'Variables en Python',
                'explanation' => 'En Python no necesitas decir el tipo de variable, solo escribes nombre = valor.',
                'analogy' => 'Es tan simple como poner una etiqueta a una caja sin trámites extra.',
                'stepByStep' => 'Escribe el nombre seguido de = y el valor.',
                'exactCode' => "nombre = 'Ana'",
                'expectedResult' => "Ana",
                'exercise' => [
                    'instructions' => "Crea una variable nombre con el valor 'Ana'",
                    'starter_code' => "___ = 'Ana'",
                    'solution_code' => "nombre = 'Ana'",
                    'expected_output' => "nombre = 'Ana'",
                ]
            ],
            [
                'title' => 'Listas',
                'explanation' => 'Una lista en Python guarda varios valores en una sola variable, como una lista del mercado.',
                'analogy' => 'Una lista es como una maleta donde metes varias cosas: [camisa, pantalón, zapatos].',
                'stepByStep' => 'Usa corchetes [ ] para crear la lista.',
                'exactCode' => "frutas = ['manzana', 'pera', 'uva']",
                'expectedResult' => "['manzana', 'pera', 'uva']",
                'exercise' => [
                    'instructions' => "Crea una lista llamada frutas con 3 frutas",
                    'starter_code' => "frutas = [___, ___, ___]",
                    'solution_code' => "frutas = ['manzana', 'pera', 'uva']",
                    'expected_output' => "frutas = ['manzana', 'pera', 'uva']",
                ]
            ],
            [
                'title' => 'Funciones en Python',
                'explanation' => 'Una función es un bloque de código con nombre que puedes usar cuando quieras.',
                'analogy' => 'Es como guardar una receta favorita: la escribes una vez y la usas siempre que quieras cocinar.',
                'stepByStep' => 'Usa la palabra def para definir la función.',
                'exactCode' => "def saludar():\n  print('Hola')",
                'expectedResult' => 'Función definida',
                'exercise' => [
                    'instructions' => "Define una función llamada saludar",
                    'starter_code' => "___ saludar():\n  print('Hola')",
                    'solution_code' => "def saludar():\n  print('Hola')",
                    'expected_output' => "def saludar():\n  print('Hola')",
                ]
            ],
            [
                'title' => 'Tu primer programa en Python',
                'explanation' => 'Vamos a crear un pequeño programa que imprime un saludo.',
                'analogy' => 'Es el primer paso oficial de todo gran programador.',
                'stepByStep' => 'Usa print para mostrar el mensaje final.',
                'exactCode' => "print('Bienvenido a Python')",
                'expectedResult' => 'Bienvenido a Python',
                'exercise' => [
                    'instructions' => "Escribe el código para imprimir 'Bienvenido a Python'",
                    'starter_code' => "print('___')",
                    'solution_code' => "print('Bienvenido a Python')",
                    'expected_output' => "print('Bienvenido a Python')",
                ]
            ],
        ];

        foreach ($lessons6 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course6->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);
            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }

        // --- COURSE 7: GIT ---
        $course7 = Course::create([
            'title' => 'Git y GitHub Básico',
            'slug' => 'git-y-github-basico',
            'description' => 'Aprende a controlar las versiones de tu código.',
            'icon' => '🗂️',
            'order' => 7,
            'level_id' => $aprendiz->id,
        ]);

        $lessons7 = [
            [
                'title' => '¿Qué es Git?',
                'explanation' => 'Git es una herramienta que guarda el historial de cambios de tu código. Es como tener versiones guardadas de un documento.',
                'analogy' => 'Imagina que escribes una novela y guardas una copia cada vez que haces un cambio importante.',
                'stepByStep' => 'Usa git init para empezar.',
                'exactCode' => "git init",
                'expectedResult' => "Repositorio inicializado",
                'exercise' => [
                    'instructions' => "Escribe el comando para inicializar Git en una carpeta",
                    'starter_code' => "git ___",
                    'solution_code' => "git init",
                    'expected_output' => "git init",
                ]
            ],
            [
                'title' => '¿Qué es GitHub?',
                'explanation' => 'GitHub es una plataforma web donde guardas tu código en la nube y puedes compartirlo con otros.',
                'analogy' => 'Si Git es tu cuaderno de notas, GitHub es la nube donde guardas copias de ese cuaderno.',
                'stepByStep' => 'Usa git add . para preparar todos los archivos.',
                'exactCode' => "git add .",
                'expectedResult' => "Archivos agregados",
                'exercise' => [
                    'instructions' => "Escribe el comando para agregar todos los archivos al staging",
                    'starter_code' => "git ___ .",
                    'solution_code' => "git add .",
                    'expected_output' => "git add .",
                ]
            ],
            [
                'title' => 'Tu primer commit',
                'explanation' => 'Un commit es como tomar una foto del estado actual de tu código con un mensaje descriptivo.',
                'analogy' => 'Es como marcar un punto de guardado en un videojuego.',
                'stepByStep' => 'Usa git commit -m seguido del mensaje.',
                'exactCode' => 'git commit -m "primer commit"',
                'expectedResult' => "Commit realizado",
                'exercise' => [
                    'instructions' => "Escribe el comando para hacer un commit con el mensaje 'primer commit'",
                    'starter_code' => 'git commit -m "___"',
                    'solution_code' => 'git commit -m "primer commit"',
                    'expected_output' => 'git commit -m "primer commit"',
                ]
            ],
            [
                'title' => 'Ramas (branches)',
                'explanation' => 'Una rama te permite trabajar en una nueva función sin afectar el código principal.',
                'analogy' => 'Como hacer una fotocopia de tu trabajo para experimentar.',
                'stepByStep' => 'Usa git branch para crear una rama.',
                'exactCode' => "git branch nueva-funcion",
                'expectedResult' => "Rama creada",
                'exercise' => [
                    'instructions' => "Escribe el comando para crear una rama llamada 'nueva-funcion'",
                    'starter_code' => "git ___ nueva-funcion",
                    'solution_code' => "git branch nueva-funcion",
                    'expected_output' => "git branch nueva-funcion",
                ]
            ],
            [
                'title' => 'Push y Pull',
                'explanation' => 'Push sube tus cambios a GitHub. Pull descarga los cambios que otros hicieron.',
                'analogy' => 'Es como subir fotos a Instagram (Push) o ver las fotos nuevas de tus amigos (Pull).',
                'stepByStep' => 'Usa git push para subir al servidor remoto.',
                'exactCode' => "git push origin main",
                'expectedResult' => "Cambios subidos",
                'exercise' => [
                    'instructions' => "Escribe el comando para subir tus cambios al repositorio remoto",
                    'starter_code' => "git ___ origin main",
                    'solution_code' => "git push origin main",
                    'expected_output' => "git push origin main",
                ]
            ],
        ];

        foreach ($lessons7 as $index => $data) {
            $lesson = Lesson::create([
                'course_id' => $course7->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'order' => $index + 1,
                'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep'], $data['exactCode'], $data['expectedResult']),
                'xp_reward' => 10,
                'type' => 'exercise',
            ]);
            Exercise::create(array_merge($data['exercise'], ['lesson_id' => $lesson->id, 'xp_reward' => 25]));
        }
    }
}
