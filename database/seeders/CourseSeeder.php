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
        // --- LEVEL: AVANZADO ---
        $avanzado = Level::where('slug', 'avanzado')->first();
        if (!$avanzado) {
            $avanzado = Level::create([
                'name' => 'Avanzado',
                'slug' => 'avanzado',
                'description' => 'Domina conceptos complejos y arquitectura de software.',
                'order' => 3,
                'xp_required' => 1200
            ]);
        }

        // --- COURSE 11: TypeScript Básico ---
        $course11 = Course::updateOrCreate(
            ['slug' => 'typescript-basico'],
            [
                'title' => 'TypeScript Básico',
                'description' => 'Aprende las bases de TypeScript para crear aplicaciones más robustas.',
                'icon' => '🔷',
                'order' => 11,
                'level_id' => $intermedio->id,
            ]
        );

        $lessons11 = [
            [
                'title' => '¿Qué es TypeScript?',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>TypeScript es JavaScript con tipos. Permite detectar errores antes de ejecutar el código, haciendo las aplicaciones más robustas y fáciles de mantener.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como escribir una receta con medidas exactas (TypeScript) en vez de "un poco de sal" (JavaScript). Sabes exactamente qué esperar.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>En TypeScript declaras el tipo de cada variable usando dos puntos después del nombre. Por ejemplo para un número usas el tipo number, para texto string.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Declara el tipo de la variable edad como number.',
                    'starter_code' => "let edad: ___ = 25;\nconsole.log(edad);",
                    'solution_code' => "let edad: number = 25;\nconsole.log(edad);",
                    'expected_output' => "let edad: number = 25;",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Tipos básicos',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>TypeScript tiene tipos básicos: number para números, string para texto, boolean para verdadero/falso, y any para cualquier tipo.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como las categorías de un formulario: el campo edad solo acepta números, el nombre solo texto, y activo solo sí/no.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Declara la variable con let o const, luego dos puntos y el tipo, luego el valor. El compilador te avisará si intentas poner el tipo equivocado.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Declara la variable activo como tipo boolean.',
                    'starter_code' => "let nombre: string = 'Ana';\nlet activo: ___ = true;\nconsole.log(nombre, activo);",
                    'solution_code' => "let nombre: string = 'Ana';\nlet activo: boolean = true;\nconsole.log(nombre, activo);",
                    'expected_output' => "let activo: boolean = true;",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Interfaces',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Una interfaz define la estructura que debe tener un objeto. Es como un contrato que dice qué propiedades y tipos debe tener.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como el formulario de registro de un banco que define exactamente qué campos son obligatorios y de qué tipo deben ser.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa la palabra clave interface seguida del nombre (con mayúscula), luego llaves con las propiedades y sus tipos.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa la palabra clave interface para definir el objeto Usuario.',
                    'starter_code' => "___ Usuario {\n  nombre: string;\n  edad: number;\n}",
                    'solution_code' => "interface Usuario {\n  nombre: string;\n  edad: number;\n}",
                    'expected_output' => "interface usuario {",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Funciones tipadas',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>En TypeScript puedes definir el tipo de los parámetros y el tipo de retorno de una función, evitando errores de tipo en tiempo de compilación.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una máquina expendedora: sabes exactamente qué monedas acepta (parámetros) y qué producto entrega (retorno).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Después de los paréntesis con parámetros tipados, agrega dos puntos y el tipo de retorno antes de las llaves de la función.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Indica que la función sumar retorna un tipo number.',
                    'starter_code' => "function sumar(a: number, b: number): ___ {\n  return a + b;\n}",
                    'solution_code' => "function sumar(a: number, b: number): number {\n  return a + b;\n}",
                    'expected_output' => "function sumar(a: number, b: number): number {",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Arrays tipados',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>En TypeScript los arrays pueden tener tipos específicos usando la sintaxis tipo[] o Array. Esto evita mezclar diferentes tipos en el mismo array.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una caja etiquetada "solo manzanas" — no puedes meter naranjas. El tipo del array garantiza que todos los elementos sean del mismo tipo.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Escribe el tipo seguido de corchetes [] para declarar un array tipado. Por ejemplo string[] es un array que solo acepta textos.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Declara que el array frutas es de tipo string.',
                    'starter_code' => "let frutas: ___[] = ['manzana', 'pera', 'uva'];\nconsole.log(frutas[0]);",
                    'solution_code' => "let frutas: string[] = ['manzana', 'pera', 'uva'];\nconsole.log(frutas[0]);",
                    'expected_output' => "let frutas: string[] =",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Enums',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Un enum es un conjunto de valores con nombre. Útil cuando tienes un conjunto fijo de opciones como días de la semana, estados, roles.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como las opciones de un menú desplegable: solo puedes elegir entre las opciones definidas, nada más.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa la palabra clave enum seguida del nombre and las opciones entre llaves separadas por comas.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa la palabra clave enum para definir el tipo Estado.',
                    'starter_code' => "___ Estado {\n  Activo,\n  Inactivo,\n  Pendiente\n}",
                    'solution_code' => "enum Estado {\n  Activo,\n  Inactivo,\n  Pendiente\n}",
                    'expected_output' => "enum estado {",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Tipos opcionales',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>En TypeScript puedes marcar propiedades como opcionales con el signo ?. Esto significa que pueden existir o no en el objeto.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como un formulario donde algunos campos son obligatorios y otros son opcionales. El ? marca los campos que no son obligatorios.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Agrega ? después del nombre de la propiedad en la interfaz para hacerla opcional.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Haz que la propiedad apellido sea opcional.',
                    'starter_code' => "interface Perfil {\n  nombre: string;\n  apellido___: string;\n}",
                    'solution_code' => "interface Perfil {\n  nombre: string;\n  apellido?: string;\n}",
                    'expected_output' => "apellido?: string;",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Union types',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los union types permiten que una variable acepte más de un tipo usando el símbolo |. Por ejemplo string | number acepta texto o número.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una puerta que acepta llave o tarjeta magnética — dos formas distintas de entrar, ambas válidas.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Escribe los tipos separados por | para crear un union type. La variable aceptará cualquiera de esos tipos.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el símbolo de union para que id acepte string o number.',
                    'starter_code' => "let id: string ___ number;\nid = 'abc123';\nid = 456;",
                    'solution_code' => "let id: string | number;\nid = 'abc123';\nid = 456;",
                    'expected_output' => "let id: string | number;",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Genéricos básicos',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los genéricos permiten crear funciones y clases que funcionan con cualquier tipo manteniendo la seguridad de tipos. Se usan con los símbolos T, U, etc.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una caja transparente — puede guardar cualquier cosa pero siempre sabes qué tipo de objeto contiene.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Agrega entre menor y mayor que el nombre del tipo genérico (generalmente T) después del nombre de la función.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Completa el tipo genérico T en la función.',
                    'starter_code' => "function identidad<___>(valor: T): T {\n  return valor;\n}\nconsole.log(identidad<string>('Hola'));",
                    'solution_code' => "function identidad<T>(valor: T): T {\n  return valor;\n}\nconsole.log(identidad<string>('Hola'));",
                    'expected_output' => "function identidad<t>(valor: t): t {",
                    'xp_reward' => 35
                ]
            ],
            [
                'title' => 'Clases en TypeScript',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>TypeScript mejora las clases de JavaScript con tipos, modificadores de acceso (public, private, protected) and constructores tipados.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como un plano arquitectónico detallado — especifica exactamente qué materiales usar (tipos) and qué partes son privadas (solo internas) o públicas (accesibles desde afuera).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Declara las propiedades con su tipo antes del constructor. Usa public para acceso libre and private para acceso solo dentro de la clase.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el modificador public para la propiedad nombre.',
                    'starter_code' => "class Persona {\n  ___nombre: string;\n  constructor(nombre: string) {\n    this.nombre = nombre;\n  }\n}",
                    'solution_code' => "class Persona {\n  public nombre: string;\n  constructor(nombre: string) {\n    this.nombre = nombre;\n  }\n}",
                    'expected_output' => "public nombre: string;",
                    'xp_reward' => 35
                ]
            ],
        ];

        foreach ($lessons11 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course11->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $data['content'],
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 12: Node.js Básico ---
        $course12 = Course::updateOrCreate(
            ['slug' => 'node-js-basico'],
            [
                'title' => 'Node.js Básico',
                'description' => 'Aprende a ejecutar JavaScript en el servidor.',
                'icon' => '🟢',
                'order' => 12,
                'level_id' => $intermedio->id,
            ]
        );

        $lessons12 = [
            [
                'title' => '¿Qué es Node.js?',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Node.js permite ejecutar JavaScript en el servidor, fuera del navegador. Es la base de frameworks como Express and es ideal para crear APIs and aplicaciones backend.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Si JavaScript es un chef que solo trabaja en cocinas con equipos especiales (navegadores), Node.js le permite cocinar en cualquier cocina (cualquier servidor).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Node.js usa el mismo JavaScript que conoces pero agrega módulos como fs para archivos, http para servidor, and path para rutas de archivos.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Qué función de Node.js muestra texto en consola? Escribe: console.log',
                    'starter_code' => "// ¿Qué función de Node.js muestra texto en consola?\n// Escribe: console.log",
                    'solution_code' => "// console.log",
                    'expected_output' => "// console.log",
                    'xp_reward' => 10
                ]
            ],
            [
                'title' => 'Módulos en Node',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Node.js usa un sistema de módulos. require() importa módulos and module.exports los exporta. Los módulos permiten organizar el código en archivos separados.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como importar herramientas de una caja de herramientas. Cada módulo es una caja especializada con herramientas específicas.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa require() con el nombre del módulo entre comillas para importarlo. Para módulos propios agrega ./ antes del nombre del archivo.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa require para importar el módulo path.',
                    'starter_code' => "const path = ___('path');\nconsole.log(path.join('carpeta', 'archivo.txt'));",
                    'solution_code' => "const path = require('path');\nconsole.log(path.join('carpeta', 'archivo.txt'));",
                    'expected_output' => "const path = require('path');",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Servidor HTTP básico',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Con el módulo http de Node.js puedes crear un servidor web básico que responde a peticiones sin necesitar Apache o Nginx.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como abrir una tienda: createServer crea la tienda, listen le dice en qué dirección and puerto estará abierta, and la función dentro maneja cada cliente que llega.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Importa el módulo http, usa createServer con una función que recibe req (petición) and res (respuesta), and llama a listen con el puerto.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Completa los parámetros del handler: req y res.',
                    'starter_code' => 'const http = require(\'http\');
http.createServer((req, ___) => {
  res.end(\'Hola Mundo\');
}).listen(3000);',
                    'solution_code' => 'const http = require(\'http\');
http.createServer((req, res) => {
  res.end(\'Hola Mundo\');
}).listen(3000);',
                    'expected_output' => 'http.createserver((req, res) =>',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'NPM y paquetes',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>NPM (Node Package Manager) es el gestor de paquetes de Node.js. Permite instalar librerías de terceros con un simple comando.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>NPM es como una tienda de herramientas online. En vez de fabricar cada herramienta tú mismo, simplemente la descargas e instalas.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Escribe npm install seguido del nombre del paquete en la terminal. El paquete se guarda en node_modules and se registra en package.json.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Qué comando instala el paquete express? Escribe: npm install express',
                    'starter_code' => "// ¿Qué comando instala el paquete express?\n// Escribe: npm install express",
                    'solution_code' => "// npm install express",
                    'expected_output' => "// npm install express",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Express básico',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Express es el framework web más popular de Node.js. Simplifica enormemente la creación de servidores and APIs REST.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Si Node.js es construir una casa desde los cimientos, Express es comprar una casa prefabricada — ya tiene la estructura lista and solo personalizas los detalles.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Importa express, llama a express() para crear la app, define rutas con app.get() o app.post(), and arranca el servidor con app.listen().</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método get para definir la ruta raíz.',
                    'starter_code' => "const express = require('express');\nconst app = express();\napp.___(('/', (req, res) => {\n  res.send('Hola desde Express');\n}));\napp.listen(3000);",
                    'solution_code' => "const express = require('express');\nconst app = express();\napp.get('/', (req, res) => {\n  res.send('Hola desde Express');\n});\napp.listen(3000);",
                    'expected_output' => "app.get('/', (req, res) =>",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Rutas en Express',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las rutas en Express definen qué código se ejecuta cuando el usuario accede a una URL específica. Cada método HTTP tiene su propio handler.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como las puertas de un edificio: cada puerta (ruta) lleva a una habitación diferente (funcionalidad) según cómo la abras (método HTTP).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa app.get() para GET, app.post() para POST, app.put() para PUT, app.delete() para DELETE, seguido de la ruta and la función handler.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método status(200) antes de enviar el JSON.',
                    'starter_code' => "app.get('/usuarios', (req, res) => {\n  res.___(200).json({ usuarios: [] });\n});",
                    'solution_code' => "app.get('/usuarios', (req, res) => {\n  res.status(200).json({ usuarios: [] });\n});",
                    'expected_output' => "res.status(200).json({ usuarios: [] });",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Middleware en Express',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los middleware son funciones que se ejecutan entre la petición and la respuesta. Sirven para autenticación, logging, validación, etc.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como los controles de seguridad en un aeropuerto: antes de llegar a tu destino (ruta), pasas por varios puntos de revisión (middlewares).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Un middleware recibe req, res and next. Debes llamar a next() para que la petición continúe al siguiente middleware o ruta.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Completa el tercer parámetro: next.',
                    'starter_code' => "app.use((req, res, ___) => {\n  console.log('Petición recibida:', req.url);\n  next();\n});",
                    'solution_code' => "app.use((req, res, next) => {\n  console.log('Petición recibida:', req.url);\n  next();\n});",
                    'expected_output' => "app.use((req, res, next) =>",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Variables de entorno',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las variables de entorno guardan configuración sensible fuera del código. En Node.js se acceden con process.env and se guardan en archivos .env.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como la combinación de tu caja fuerte: no la escribes en el código (donde cualquiera puede verla), sino que la guardas en un lugar seguro and separado.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa process.env.NOMBRE_VARIABLE para leer una variable de entorno. El paquete dotenv permite cargarlas desde un archivo .env.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Accede al objeto global process.',
                    'starter_code' => "const puerto = ___.env.PORT || 3000;\nconsole.log('Servidor en puerto:', puerto);",
                    'solution_code' => "const puerto = process.env.PORT || 3000;\nconsole.log('Servidor en puerto:', puerto);",
                    'expected_output' => "const puerto = process.env.port || 3000;",
                    'xp_reward' => 25
                ]
            ],
            [
                'title' => 'Async/Await en Node',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Async/await simplifica el manejo de operaciones asíncronas en Node.js como lectura de archivos, consultas a BD o llamadas a APIs.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Sin async/await el código asíncrono es como hacer malabares. Con async/await puedes escribirlo como si fuera código normal, paso a paso.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Marca la función con async, luego usa await antes de cualquier operación asíncrona para esperar su resultado antes de continuar.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Marca la función como async.',
                    'starter_code' => "___ function obtenerDatos() {\n  const datos = await fetch('https://api.example.com');\n  return datos.json();\n}",
                    'solution_code' => "async function obtenerDatos() {\n  const datos = await fetch('https://api.example.com');\n  return datos.json();\n}",
                    'expected_output' => "async function obtenerDatos() {",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Manejo de errores',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El manejo de errores con try/catch permite capturar and responder adecuadamente a errores en operaciones asíncronas sin que la aplicación crashee.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como tener un plan B: intentas algo (try), and si sale mal tienes un plan de contingencia (catch) para manejar el problema graciosamente.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Envuelve el código que puede fallar en un bloque try, and maneja el error en el bloque catch que recibe el objeto de error.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Inicia el bloque try.',
                    'starter_code' => "async function obtenerDatos() {\n  ___ {\n    const res = await fetch('https://api.example.com');\n    return await res.json();\n  } catch(error) {\n    console.error('Error:', error.message);\n  }\n}",
                    'solution_code' => "async function obtenerDatos() {\n  try {\n    const res = await fetch('https://api.example.com');\n    return await res.json();\n  } catch(error) {\n    console.error('Error:', error.message);\n  }\n}",
                    'expected_output' => "async function obtenerDatos() {\n  try {",
                    'xp_reward' => 30
                ]
            ],
        ];

        foreach ($lessons12 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course12->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $data['content'],
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 13: Algoritmos y Estructuras de Datos ---
        $course13 = Course::updateOrCreate(
            ['slug' => 'algoritmos-y-estructuras-de-datos'],
            [
                'title' => 'Algoritmos y Estructuras de Datos',
                'description' => 'Domina los fundamentos de la computación.',
                'icon' => '🧩',
                'order' => 13,
                'level_id' => $avanzado->id,
            ]
        );

        $lessons13 = [
            [
                'title' => '¿Qué son los algoritmos?',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Un algoritmo es una secuencia finita de pasos bien definidos para resolver un problema. La eficiencia de un algoritmo se mide por su complejidad temporal and espacial.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como el GPS: hay muchas rutas para llegar al destino, pero el algoritmo encuentra la más rápida o eficiente según el criterio que uses.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Un buen algoritmo es correcto, eficiente and claro. Antes de codificar, describe los pasos en pseudocódigo o en papel.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Cómo se llama la notación que describe la eficiencia de un algoritmo? Escribe: Big O',
                    'starter_code' => "// ¿Cómo se llama la notación que describe la eficiencia de un algoritmo?\n// Escribe: Big O",
                    'solution_code' => "// Big O",
                    'expected_output' => "// big o",
                    'xp_reward' => 10
                ]
            ],
            [
                'title' => 'Búsqueda lineal',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La búsqueda lineal recorre cada elemento de un array uno por uno hasta encontrar el buscado. Es simple pero lenta para arrays grandes: O(n).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como buscar tus llaves revisando cada bolsillo uno por uno hasta encontrarlas.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa un bucle for que recorra el array. En cada iteración compara el elemento actual con el valor buscado. Si coinciden devuelve el índice.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Completa el incremento del bucle for: i++.',
                    'starter_code' => "function buscarLineal(arr, objetivo) {\n  for (let i = 0; i < arr.length; ___) {\n    if (arr[i] === objetivo) return i;\n  }\n  return -1;\n}",
                    'solution_code' => "function buscarLineal(arr, objetivo) {\n  for (let i = 0; i < arr.length; i++) {\n    if (arr[i] === objetivo) return i;\n  }\n  return -1;\n}",
                    'expected_output' => "for (let i = 0; i < arr.length; i++)",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Búsqueda binaria',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La búsqueda binaria divide el array ordenado a la mitad en cada paso. Es mucho más eficiente que la lineal: O(log n) vs O(n).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como buscar una palabra en un diccionario: abres por el medio, si tu palabra va antes miras la mitad izquierda, si va después la mitad derecha. Nunca revisas todo.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Mantén dos punteros inicio and fin. Calcula el medio, compara con el objetivo and descarta la mitad que no puede contenerlo.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Calcula el índice medio usando inicio y fin.',
                    'starter_code' => "function busquedaBinaria(arr, objetivo) {\n  let inicio = 0, fin = arr.length - 1;\n  while (inicio <= fin) {\n    let medio = Math.floor((inicio + ___) / 2);\n    if (arr[medio] === objetivo) return medio;\n    if (arr[medio] < objetivo) inicio = medio + 1;\n    else fin = medio - 1;\n  }\n  return -1;\n}",
                    'solution_code' => "function busquedaBinaria(arr, objetivo) {\n  let inicio = 0, fin = arr.length - 1;\n  while (inicio <= fin) {\n    let medio = Math.floor((inicio + fin) / 2);\n    if (arr[medio] === objetivo) return medio;\n    if (arr[medio] < objetivo) inicio = medio + 1;\n    else fin = medio - 1;\n  }\n  return -1;\n}",
                    'expected_output' => "let medio = math.floor((inicio + fin) / 2);",
                    'xp_reward' => 30
                ]
            ],
            [
                'title' => 'Ordenamiento burbuja',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El ordenamiento burbuja compara pares adyacentes e intercambia si están en el orden incorrecto. Repite hasta que el array esté ordenado. Complejidad O(n²).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como ordenar cartas en tu mano: comparas dos cartas adyacentes and si están mal puestas las cambias, repitiendo hasta que todas estén en orden.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa dos bucles for anidados. El externo controla cuántas pasadas haces, el interno compara pares adyacentes e intercambia si es necesario.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Asigna el valor del siguiente elemento al elemento actual.',
                    'starter_code' => "function burbuja(arr) {\n  for (let i = 0; i < arr.length; i++) {\n    for (let j = 0; j < arr.length - i - 1; j++) {\n      if (arr[j] > arr[j+1]) {\n        let temp = arr[j];\n        arr[j] = arr[___];\n        arr[j+1] = temp;\n      }\n    }\n  }\n  return arr;\n}",
                    'solution_code' => "function burbuja(arr) {\n  for (let i = 0; i < arr.length; i++) {\n    for (let j = 0; j < arr.length - i - 1; j++) {\n      if (arr[j] > arr[j+1]) {\n        let temp = arr[j];\n        arr[j] = arr[j+1];\n        arr[j+1] = temp;\n      }\n    }\n  }\n  return arr;\n}",
                    'expected_output' => "arr[j] = arr[j+1];",
                    'xp_reward' => 35
                ]
            ],
            [
                'title' => 'Pilas (Stacks)',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Una pila es una estructura LIFO (Last In First Out). El último elemento en entrar es el primero en salir. Se usan en historial de navegación, undo/redo, llamadas de funciones.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una pila de platos: solo puedes agregar o quitar del tope. El último plato que pusiste es el primero que puedes retirar.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>En JavaScript puedes simular una pila con un array usando push() para agregar al tope and pop() para retirar del tope.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método push para agregar un elemento a la pila.',
                    'starter_code' => "class Pila {\n  constructor() { this.items = []; }\n  push(item) { this.items.___(item); }\n  pop() { return this.items.pop(); }\n  peek() { return this.items[this.items.length - 1]; }\n}",
                    'solution_code' => "class Pila {\n  constructor() { this.items = []; }\n  push(item) { this.items.push(item); }\n  pop() { return this.items.pop(); }\n  peek() { return this.items[this.items.length - 1]; }\n}",
                    'expected_output' => "this.items.push(item);",
                    'xp_reward' => 35
                ]
            ],
            [
                'title' => 'Colas (Queues)',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Una cola es una estructura FIFO (First In First Out). El primero en entrar es el primero en salir. Se usan en impresoras, sistemas de tickets, procesamiento de tareas.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una fila en el banco: el primero en llegar es el primero en ser atendido. No hay privilegios, el orden de llegada es el orden de atención.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>En JavaScript usa push() para encolar al final and shift() para desencolar del inicio. Esto simula perfectamente el comportamiento FIFO.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método shift para retirar el primer elemento de la cola.',
                    'starter_code' => "class Cola {\n  constructor() { this.items = []; }\n  encolar(item) { this.items.push(item); }\n  desencolar() { return this.items.___(); }\n}",
                    'solution_code' => "class Cola {\n  constructor() { this.items = []; }\n  encolar(item) { this.items.push(item); }\n  desencolar() { return this.items.shift(); }\n}",
                    'expected_output' => "return this.items.shift();",
                    'xp_reward' => 35
                ]
            ],
            [
                'title' => 'Recursión',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La recursión es cuando una función se llama a sí misma para resolver un problema dividiéndolo en subproblemas más pequeños. Toda función recursiva necesita un caso base.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como las muñecas rusas: abres una and hay otra más pequeña dentro, and otra dentro de esa, hasta llegar a la más pequeña que no se puede abrir (caso base).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Define el caso base (condición de parada) and el caso recursivo (la función llamándose con un parámetro más pequeño). Sin caso base tendrás un loop infinito.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Completa el caso base: si n es menor o igual a 1.',
                    'starter_code' => "function factorial(n) {\n  if (n ___ 1) return 1;\n  return n * factorial(n - 1);\n}",
                    'solution_code' => "function factorial(n) {\n  if (n <= 1) return 1;\n  return n * factorial(n - 1);\n}",
                    'expected_output' => "if (n <= 1) return 1;",
                    'xp_reward' => 40
                ]
            ],
            [
                'title' => 'Complejidad O(n)',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La notación Big O describe cómo crece el tiempo de ejecución según el tamaño de la entrada. O(1) es constante, O(n) es lineal, O(n²) es cuadrática.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>O(1) es saber cuánto mides sin medirte. O(n) es contar tus pasos caminando. O(n²) es contar todos los saludos posibles en una reunión.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Analiza cuántas veces se ejecuta cada línea según el tamaño n de la entrada. Los bucles simples son O(n), los anidados O(n²), las operaciones únicas O(1).</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Qué complejidad tiene un bucle for simple sobre n elementos? Escribe: O(n)',
                    'starter_code' => "// ¿Qué complejidad tiene un bucle for simple sobre n elementos?\n// Escribe: O(n)",
                    'solution_code' => "// O(n)",
                    'expected_output' => "// o(n)",
                    'xp_reward' => 25
                ]
            ],
        ];

        foreach ($lessons13 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course13->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $data['content'],
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 14: APIs REST con Laravel ---
        $course14 = Course::updateOrCreate(
            ['slug' => 'apis-rest-con-laravel'],
            [
                'title' => 'APIs REST con Laravel',
                'description' => 'Aprende a crear servicios web profesionales.',
                'icon' => '🔌',
                'order' => 14,
                'level_id' => $avanzado->id,
            ]
        );

        $lessons14 = [
            [
                'title' => '¿Qué es una API REST?',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Una API REST es una interfaz que permite a aplicaciones comunicarse entre sí usando HTTP. Usa métodos estándar: GET (leer), POST (crear), PUT (actualizar), DELETE (eliminar).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como un menú de restaurante: el cliente (frontend) pide lo que quiere, el mesero (API) transmite el pedido a la cocina (backend) and trae la respuesta.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>En Laravel, las rutas API van en routes/api.php and retornan JSON. Usa Route::get(), Route::post(), etc. para definir los endpoints.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿En qué archivo de Laravel van las rutas de la API? Escribe: routes/api.php',
                    'starter_code' => "// ¿En qué archivo de Laravel van las rutas de la API?\n// Escribe: routes/api.php",
                    'solution_code' => "// routes/api.php",
                    'expected_output' => "// routes/api.php",
                    'xp_reward' => 10
                ]
            ],
            [
                'title' => 'Rutas API en Laravel',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>En routes/api.php defines los endpoints de tu API. Laravel agrega automáticamente el prefijo /api a todas estas rutas.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Las rutas API son las puertas de tu aplicación que el mundo exterior puede usar. Cada puerta tiene una dirección (URL) and acepta ciertos tipos de visitas (métodos HTTP).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>En api.php usa Route::get() para consultas, Route::post() para crear, Route::put() para actualizar and Route::delete() para eliminar recursos.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método get para definir una ruta API.',
                    'starter_code' => "Route::___(('/usuarios', [UsuarioController::class, 'index']));",
                    'solution_code' => "Route::get('/usuarios', [UsuarioController::class, 'index']);",
                    'expected_output' => "route::get('/usuarios',",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'Resource Controllers',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los Resource Controllers en Laravel crean automáticamente las 7 rutas CRUD (index, create, store, show, edit, update, destroy) con un solo comando.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como pedir un combo en vez de pedir cada cosa por separado. Route::resource crea todos los endpoints CRUD de una sola vez.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa Route::resource(\'nombre\', Controller::class) en api.php para crear todas las rutas CRUD automáticamente.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método resource para definir las rutas CRUD.',
                    'starter_code' => "Route::___(('productos', [ProductoController::class]));",
                    'solution_code' => "Route::resource('productos', ProductoController::class);",
                    'expected_output' => "route::resource('productos',",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Respuestas JSON',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las APIs devuelven datos en formato JSON. En Laravel puedes retornar JSON con response()->json() especificando los datos and el código HTTP.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>JSON es el idioma universal entre frontend and backend. Es como usar inglés en una reunión internacional — todos lo entienden sin importar qué tecnología usen.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa return response()->json() con un array de datos and opcionalmente el código HTTP. 200 es éxito, 201 es creado, 404 es no encontrado, 500 es error.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el método json para retornar la respuesta.',
                    'starter_code' => 'public function index() {
  $usuarios = Usuario::all();
  return response()->___([
    \'success\' => true,
    \'data\' => $usuarios
  ], 200);
}',
                    'solution_code' => 'public function index() {
  $usuarios = Usuario::all();
  return response()->json([
    \'success\' => true,
    \'data\' => $usuarios
  ], 200);
}',
                    'expected_output' => 'return response()->json([',
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'Sanctum — Autenticación API',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Laravel Sanctum provee autenticación para APIs usando tokens. El usuario hace login, recibe un token, and lo envía en cada petición en el header Authorization.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como una pulsera de acceso a un evento: la obtienes al registrarte (login) and la presentas cada vez que entras a una zona restringida (endpoint protegido).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Protege las rutas con el middleware auth:sanctum. El cliente envía el token en el header como: Authorization: Bearer tu-token-aqui.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Usa el guard de sanctum para proteger las rutas.',
                    'starter_code' => "Route::middleware('auth:___')->group(function () {\n  Route::get('/perfil', [PerfilController::class, 'show']);\n});",
                    'solution_code' => "Route::middleware('auth:sanctum')->group(function () {\n  Route::get('/perfil', [PerfilController::class, 'show']);\n});",
                    'expected_output' => "route::middleware('auth:sanctum')",
                    'xp_reward' => 30
                ]
            ],
        ];

        foreach ($lessons14 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course14->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $data['content'],
                    'xp_reward' => 10,
                    'type' => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                $data['exercise']
            );
        }

        // --- COURSE 15: Principios SOLID ---
        $course15 = Course::updateOrCreate(
            ['slug' => 'principios-solid'],
            [
                'title' => 'Principios SOLID',
                'description' => 'Escribe código limpio, mantenible and escalable.',
                'icon' => '🏗️',
                'order' => 15,
                'level_id' => $avanzado->id,
            ]
        );

        $lessons15 = [
            [
                'title' => '¿Qué son los principios SOLID?',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>SOLID son 5 principios de diseño orientado a objetos que hacen el código más mantenible, flexible and escalable. Son la base del buen diseño de software.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Son como las reglas de construcción: si las sigues, tu edificio (código) será sólido and fácil de modificar. Si las ignoras, cualquier cambio puede derrumbar todo.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>SOLID es un acrónimo: S=Single Responsibility, O=Open/Closed, L=Liskov, I=Interface Segregation, D=Dependency Inversion.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Qué significa la S en SOLID? Escribe: Single Responsibility',
                    'starter_code' => "// ¿Qué significa la S en SOLID?\n// Escribe: Single Responsibility",
                    'solution_code' => "// Single Responsibility",
                    'expected_output' => "// single responsibility",
                    'xp_reward' => 10
                ]
            ],
            [
                'title' => 'S — Responsabilidad única',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El principio de Responsabilidad Única dice que una clase debe tener una sola razón para cambiar. Cada clase debe hacer una sola cosa and hacerla bien.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como contratar empleados especializados: el contador hace contabilidad, el diseñador diseña. Un empleado que hace todo acaba haciéndolo todo mal.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Si tu clase hace más de una cosa, divídela. Una clase Usuario solo gestiona datos del usuario. Una clase EmailService solo envía emails.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Una clase que cumple SRP debe tener cuántas responsabilidades? Escribe: una',
                    'starter_code' => "// Una clase que cumple SRP debe tener cuántas responsabilidades?\n// Escribe: una",
                    'solution_code' => "// una",
                    'expected_output' => "// una",
                    'xp_reward' => 15
                ]
            ],
            [
                'title' => 'O — Abierto/Cerrado',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El principio Open/Closed dice que el código debe estar abierto para extensión pero cerrado para modificación. Agrega funcionalidad nueva sin cambiar el código existente.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como un enchufe universal: puedes conectar nuevos dispositivos (extender) sin modificar el enchufe (modificar). El enchufe original queda intacto.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Usa interfaces o clases abstractas. Las nuevas funcionalidades se agregan creando nuevas clases que implementan la interfaz, sin tocar las existentes.</p></div></div>',
                'exercise' => [
                    'instructions' => 'El código debe estar abierto para extensión y cerrado para... Escribe: modificacion',
                    'starter_code' => "// El código debe estar abierto para extensión y cerrado para...\n// Escribe: modificacion",
                    'solution_code' => "// modificacion",
                    'expected_output' => "// modificacion",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'L — Principio de Liskov',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El principio de Liskov dice que las clases hijas deben poder sustituir a sus clases padre sin alterar el comportamiento correcto del programa.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Si tienes una función que acepta Vehículo, debe funcionar igual con Carro, Moto o Bus — todos son vehículos and deben comportarse como tales.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Las subclases no deben romper el comportamiento esperado de la clase padre. Si Pato extends Ave, Pato debe poder hacer todo lo que hace Ave.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Las subclases pueden reemplazar a sus clases padre sin romper el programa? Escribe: si',
                    'starter_code' => "// ¿Las subclases pueden reemplazar a sus clases padre sin romper el programa?\n// Escribe: si",
                    'solution_code' => "// si",
                    'expected_output' => "// si",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'I — Segregación de interfaces',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El principio de Segregación de Interfaces dice que es mejor tener muchas interfaces pequeñas and específicas que una interfaz grande and general.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es mejor tener un control remoto para el TV and otro para el AC, que uno enorme con 200 botones donde solo usas 5. Las interfaces deben ser específicas.</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>Divide interfaces grandes en interfaces más pequeñas and específicas. Cada clase solo implementa las interfaces que realmente necesita.</p></div></div>',
                'exercise' => [
                    'instructions' => 'Es mejor tener interfaces pequeñas y específicas que interfaces... Escribe: grandes',
                    'starter_code' => "// Es mejor tener interfaces pequeñas y específicas que interfaces...\n// Escribe: grandes",
                    'solution_code' => "// grandes",
                    'expected_output' => "// grandes",
                    'xp_reward' => 20
                ]
            ],
            [
                'title' => 'D — Inversión de dependencias',
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El principio de Inversión de Dependencias dice que los módulos de alto nivel no deben depender de los de bajo nivel. Ambos deben depender de abstracciones (interfaces).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Tu lámpara no depende de una bombilla específica, depende del concepto de bombilla. Puedes cambiar la bombilla (implementación) sin cambiar la lámpara (módulo de alto nivel).</p></div><div class="example-block"><h3>✍️ ¿Cómo se hace?</h3><p>En vez de crear dependencias directas con new, inyéctales a través del constructor. Así puedes cambiar la implementación sin modificar la clase que la usa.</p></div></div>',
                'exercise' => [
                    'instructions' => '¿Cómo se llama la técnica de pasar dependencias a través del constructor? Escribe: inyeccion de dependencias',
                    'starter_code' => "// ¿Cómo se llama la técnica de pasar dependencias a través del constructor?\n// Escribe: inyeccion de dependencias",
                    'solution_code' => "// inyeccion de dependencias",
                    'expected_output' => "// inyeccion de dependencias",
                    'xp_reward' => 25
                ]
            ],
        ];

        foreach ($lessons15 as $index => $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $course15->id, 'slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'order' => $index + 1,
                    'content' => $data['content'],
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
