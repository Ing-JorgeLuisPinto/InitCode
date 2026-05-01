<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\Level;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $aprendiz = Level::where('slug', 'aprendiz')->first();
        if (!$aprendiz) {
            $aprendiz = Level::create([
                'name' => 'Aprendiz',
                'slug' => 'aprendiz',
                'description' => 'Tus primeros pasos en el mundo del desarrollo.',
                'order' => 1,
                'xp_required' => 0
            ]);
        }

        // --- COURSE 1: PROGRAMMING ---
        $course1 = Course::updateOrCreate(
            ['slug' => 'programacion-desde-cero'],
            [
                'title' => 'Programación desde Cero',
                'description' => 'Aprende las bases de la lógica de programación sin complicaciones.',
                'icon' => '💻',
                'order' => 1,
                'level_id' => $aprendiz->id,
            ]
        );

        $lessons1 = [
            [
                'title' => '¿Qué son las Variables?',
                'explanation' => 'Una variable es un espacio en la memoria de la computadora donde guardamos un dato para usarlo después. Cada variable tiene un nombre (como "nombre") y un valor (como "Juan").',
                'analogy' => 'Imagina que una variable es una caja con una etiqueta. Puedes guardar un juguete dentro y cambiarlo cuando quieras, pero la etiqueta siempre te dirá qué hay allí.',
                'stepByStep' => '1. Escribe la palabra clave <code>let</code>.<br>2. Ponle el nombre <code>usuario</code>.<br>3. Usa el signo igual <code>=</code> para asignar el valor.<br>4. Escribe el texto <code>"Juan"</code> entre comillas.',
                'exercise' => [
                    'instructions' => 'Crea una variable llamada usuario con el valor "Juan".',
                    'starter_code' => '___ usuario = "___";',
                    'solution_code' => 'let usuario = "Juan";',
                    'expected_output' => 'let usuario = "juan";',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Condicionales (If)',
                'explanation' => 'Los condicionales permiten que tu programa tome decisiones. Si una condición es verdadera, el código dentro del bloque se ejecuta; si no, se ignora.',
                'analogy' => 'Es como un semáforo: SI la luz es verde, entonces puedes pasar. SI NO, debes esperar.',
                'stepByStep' => '1. Escribe <code>if</code> seguido de paréntesis <code>()</code>.<br>2. Dentro de los paréntesis pon la condición <code>edad >= 18</code>.<br>3. Abre llaves <code>{}</code> para escribir lo que pasará si se cumple.',
                'exercise' => [
                    'instructions' => 'Completa el condicional para verificar si la edad es mayor o igual a 18.',
                    'starter_code' => 'if (edad ___ 18) { ___("Eres mayor"); }',
                    'solution_code' => 'if (edad >= 18) { console.log("Eres mayor"); }',
                    'expected_output' => 'if (edad >= 18)',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Bucle While',
                'explanation' => 'Un bucle <code>while</code> repite una acción una y otra vez MIENTRAS una condición sea verdadera. Es fundamental para tareas repetitivas.',
                'analogy' => 'Es como lavar los platos: MIENTRAS queden platos sucios, continúa lavando. Cuando no queden más, te detienes.',
                'stepByStep' => '1. Usamos la palabra <code>while</code>.<br>2. Definimos la condición entre paréntesis (ej. <code>contador < 5</code>).<br>3. Dentro de las llaves aumentamos el contador para que el bucle no sea infinito.',
                'exercise' => [
                    'instructions' => 'Crea un bucle que se ejecute mientras el contador sea menor a 5.',
                    'starter_code' => '___ (contador < 5) { \n  contador = contador + 1;\n}',
                    'solution_code' => 'while (contador < 5) { \n  contador = contador + 1;\n}',
                    'expected_output' => 'while (contador < 5)',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Arrays (Listas)',
                'explanation' => 'Un Array es una lista de elementos ordenados. Permite guardar muchos datos en una sola variable y acceder a ellos por su posición (índice).',
                'analogy' => 'Imagina un estante de zapatos: cada espacio tiene un número. El primer par está en la posición 0, el segundo en la 1, y así sucesivamente.',
                'stepByStep' => '1. Crea una variable con <code>let</code>.<br>2. Usa corchetes <code>[]</code> para definir la lista.<br>3. Separa los elementos con comas.',
                'exercise' => [
                    'instructions' => 'Crea una lista llamada colores que contenga "rojo" y "azul".',
                    'starter_code' => 'let colores = [ "___", "___" ];',
                    'solution_code' => 'let colores = [ "rojo", "azul" ];',
                    'expected_output' => '["rojo", "azul"]',
                    'xp_reward' => 25
                ]
            ],
        ];

        foreach ($lessons1 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course1->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 2: HTML ---
        $course2 = Course::updateOrCreate(
            ['slug' => 'estructura-web-con-html'],
            [
                'title' => 'Estructura Web con HTML',
                'description' => 'Aprende el lenguaje que da forma a toda la internet.',
                'icon' => '🧱',
                'order' => 2,
                'level_id' => $aprendiz->id,
            ]
        );

        $lessons2 = [
            [
                'title' => 'Tablas en HTML',
                'explanation' => 'Las tablas organizan datos en filas (tr) y celdas (td). Son perfectas para mostrar horarios, precios o listas estructuradas.',
                'analogy' => 'Imagina un tablero de ajedrez: cada cuadro es una celda definida por una fila y una columna.',
                'stepByStep' => '1. Abre la etiqueta <code>&lt;table&gt;</code>.<br>2. Crea una fila con <code>&lt;tr&gt;</code>.<br>3. Agrega datos con <code>&lt;td&gt;</code>.',
                'exercise' => [
                    'instructions' => 'Crea una fila de tabla con una celda que diga "Hola".',
                    'starter_code' => '<tr>\n  <td>___</td>\n</tr>',
                    'solution_code' => '<tr>\n  <td>Hola</td>\n</tr>',
                    'expected_output' => '<td>hola</td>',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Formularios Básicos',
                'explanation' => 'Los formularios permiten que el usuario envíe información a la web. Se usan etiquetas como <code>input</code> para escribir texto.',
                'analogy' => 'Es como un formulario de papel en el médico: tienes espacios en blanco donde escribes tu nombre, edad y motivo de consulta.',
                'stepByStep' => '1. Usa <code>&lt;form&gt;</code> para envolver todo.<br>2. Agrega un <code>&lt;input&gt;</code> para que el usuario escriba.<br>3. No olvides el atributo <code>type="text"</code>.',
                'exercise' => [
                    'instructions' => 'Crea un campo de entrada de texto sencillo.',
                    'starter_code' => '<input type="___">',
                    'solution_code' => '<input type="text">',
                    'expected_output' => 'type="text"',
                    'xp_reward' => 25
                ]
            ],
        ];

        foreach ($lessons2 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course2->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 3: JAVASCRIPT INTERACTIVE ---
        $course3 = Course::updateOrCreate(
            ['slug' => 'interactividad-con-javascript'],
            [
                'title' => 'Interactividad con JavaScript',
                'description' => 'Dale vida a tus páginas web con lógica y movimiento.',
                'icon' => '⚡',
                'order' => 3,
                'level_id' => $aprendiz->id,
            ]
        );

        $lessons3 = [
            [
                'title' => 'Objetos en JS',
                'explanation' => 'Un objeto es una colección de propiedades. Cada propiedad tiene un nombre (clave) y un valor. Es ideal para representar cosas reales.',
                'analogy' => 'Imagina un carro: tiene propiedades como "color: rojo", "marca: Toyota" y "modelo: 2024". Todo el conjunto es el objeto "carro".',
                'stepByStep' => '1. Declara la variable con <code>const</code>.<br>2. Abre llaves <code>{}</code>.<br>3. Escribe el par clave: valor separado por comas.',
                'exercise' => [
                    'instructions' => 'Crea un objeto persona con nombre "Ana".',
                    'starter_code' => 'const persona = { ___: "___" };',
                    'solution_code' => 'const persona = { nombre: "Ana" };',
                    'expected_output' => 'nombre: "ana"',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Manipular el DOM',
                'explanation' => 'El DOM es la estructura de tu página web. JavaScript puede acceder a él para cambiar textos, colores o eliminar elementos en tiempo real.',
                'analogy' => 'Es como ser el director de una obra de teatro: puedes decirle a un actor (un elemento HTML) que cambie su vestuario o diga una línea diferente.',
                'stepByStep' => '1. Usa <code>document.getElementById()</code> para encontrar el elemento.<br>2. Usa <code>.innerText</code> para cambiar su contenido.',
                'exercise' => [
                    'instructions' => 'Cambia el texto de un elemento con ID "titulo" a "Nuevo".',
                    'starter_code' => 'document.getElementById("titulo").___ = "Nuevo";',
                    'solution_code' => 'document.getElementById("titulo").innerText = "Nuevo";',
                    'expected_output' => 'innerText = "nuevo"',
                    'xp_reward' => 30
                ]
            ],
        ];

        foreach ($lessons3 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course3->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
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
            [
                'title' => '¿Qué es una base de datos?',
                'explanation' => 'Una base de datos es un sistema digital para guardar información de forma estructurada. SQL es el lenguaje que usamos para "hablar" con ella.',
                'analogy' => 'Es como un gran archivador con gavetas etiquetadas. SQL es el bibliotecario que sabe exactamente dónde está cada documento y te lo trae si se lo pides correctamente.',
                'stepByStep' => '1. Usamos comandos en mayúsculas por convención.<br>2. El comando <code>SHOW TABLES;</code> muestra todas las tablas disponibles.',
                'exercise' => [
                    'instructions' => 'Escribe el comando para ver todas las tablas.',
                    'starter_code' => '___ TABLES;',
                    'solution_code' => 'SHOW TABLES;',
                    'expected_output' => 'show tables;',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'SELECT — Consultar datos',
                'explanation' => 'SELECT sirve para pedirle a la base de datos que nos muestre información. El asterisco <code>*</code> significa "tráeme todas las columnas".',
                'analogy' => 'Es como pedir un menú completo: "SELECCIONA TODO de la CATEGORÍA PlatosPrincipales".',
                'stepByStep' => '1. Escribe <code>SELECT</code>.<br>2. Pon <code>*</code> para traer todo.<br>3. Usa <code>FROM</code> seguido del nombre de la tabla.',
                'exercise' => [
                    'instructions' => 'Selecciona todos los datos de la tabla usuarios.',
                    'starter_code' => '___ * FROM usuarios;',
                    'solution_code' => 'SELECT * FROM usuarios;',
                    'expected_output' => 'select * from usuarios;',
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'JOIN — Unir tablas',
                'explanation' => 'JOIN permite combinar filas de dos o más tablas basándose en una columna relacionada entre ellas.',
                'analogy' => 'Imagina que tienes una lista de "Estudiantes" y otra de "Cursos". Con un JOIN puedes saber qué estudiante está inscrito en qué curso usando su ID.',
                'stepByStep' => '1. Especificas las tablas que quieres unir.<br>2. Usas <code>INNER JOIN</code> para traer solo los que coinciden en ambas.<br>3. Usas <code>ON</code> para decir qué columnas son iguales.',
                'exercise' => [
                    'instructions' => 'Une la tabla usuarios con pedidos usando el ID.',
                    'starter_code' => 'SELECT * FROM usuarios ___ JOIN pedidos ON usuarios.id = pedidos.usuario_id;',
                    'solution_code' => 'SELECT * FROM usuarios INNER JOIN pedidos ON usuarios.id = pedidos.usuario_id;',
                    'expected_output' => 'inner join pedidos',
                    'xp_reward' => 40
                ]
            ],
        ];

        foreach ($lessons8 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course8->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 9: REACT ---
        $intermedio = Level::where('slug', 'intermedio')->first();
        if (!$intermedio) {
            $intermedio = Level::create([
                'name' => 'Intermedio',
                'slug' => 'intermedio',
                'description' => 'Domina herramientas avanzadas del desarrollo web.',
                'order' => 2,
                'xp_required' => 500
            ]);
        }
        
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
            [
                'title' => '¿Qué es React?',
                'explanation' => 'React es una librería de JavaScript para construir interfaces de usuario basadas en componentes.',
                'analogy' => 'Es como construir con bloques de LEGO: cada pieza (componente) es independiente y puedes unirlas para crear algo grande.',
                'stepByStep' => '1. Importamos React.<br>2. Creamos una función que devuelve HTML (JSX).',
                'exercise' => [
                    'instructions' => 'Importa React al inicio del archivo.',
                    'starter_code' => 'import ___ from "react";',
                    'solution_code' => 'import React from "react";',
                    'expected_output' => 'import react',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'useState Hook',
                'explanation' => 'useState permite que tus componentes "recuerden" información que cambia, como un contador o el texto de un input.',
                'analogy' => 'Es como la memoria a corto plazo de tu componente: guarda un dato y, si ese dato cambia, el componente se vuelve a dibujar automáticamente.',
                'stepByStep' => '1. Importa <code>useState</code> de react.<br>2. Declara el estado y la función para cambiarlo.',
                'exercise' => [
                    'instructions' => 'Usa useState para crear un contador con valor inicial 0.',
                    'starter_code' => 'const [cuenta, setCuenta] = ___ (0);',
                    'solution_code' => 'const [cuenta, setCuenta] = useState(0);',
                    'expected_output' => 'useState(0)',
                    'xp_reward' => 30
                ]
            ],
        ];

        foreach ($lessons9 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course9->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 10: SECURITY ---
        $course10 = Course::updateOrCreate(
            ['slug' => 'seguridad-web-basica'],
            [
                'title' => 'Seguridad Web Básica',
                'description' => 'Protege tus aplicaciones de los ataques más comunes.',
                'icon' => '🔐',
                'order' => 10,
                'level_id' => $intermedio->id,
            ]
        );

        $lessons10 = [
            [
                'title' => 'CSRF Protection',
                'explanation' => 'CSRF es un ataque que engaña al navegador para enviar peticiones no deseadas. Laravel usa tokens para validar que las peticiones sean legítimas.',
                'analogy' => 'Es como un sello de autenticidad en una carta: si la carta no tiene el sello oficial del remitente, el destinatario no la acepta.',
                'stepByStep' => '1. En tus formularios de Laravel, siempre agrega la directiva <code>@csrf</code>.',
                'exercise' => [
                    'instructions' => 'Agrega la protección CSRF al formulario.',
                    'starter_code' => '<form method="POST">\n  @___\n</form>',
                    'solution_code' => '<form method="POST">\n  @csrf\n</form>',
                    'expected_output' => '@csrf',
                    'xp_reward' => 25
                ]
            ],
        ];

        foreach ($lessons10 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course10->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $this->formatContent($data['explanation'], $data['analogy'], $data['stepByStep']),
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }
    }

    private function formatContent($explanation, $analogy, $stepByStep)
    {
        return '
            <div class="space-y-8">
                <section>
                    <h3 class="text-xl font-bold text-blue-400 mb-4 flex items-center gap-2">
                        <span>📖</span> ¿Qué vas a aprender?
                    </h3>
                    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed text-lg">
                        ' . $explanation . '
                    </div>
                </section>

                <section class="bg-blue-600/5 border border-blue-500/10 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-blue-300 mb-3 flex items-center gap-2">
                        <span>💡</span> Piénsalo así
                    </h3>
                    <p class="text-blue-100/80 italic leading-relaxed text-lg">
                        "' . $analogy . '"
                    </p>
                </section>

                <section class="bg-slate-800/30 border border-slate-700/50 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-lg font-semibold text-slate-200 mb-4 flex items-center gap-2">
                        <span>✍️</span> ¿Qué debo escribir?
                    </h3>
                    <div class="space-y-4">
                        <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed">
                            ' . $stepByStep . '
                        </div>
                    </div>
                </section>
            </div>
        ';
    }
}
