<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Course, Lesson, Exercise, Level};
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $principiante = Level::where('slug', 'principiante')->first();
        $aprendiz     = Level::where('slug', 'aprendiz')->first();
        $intermedio   = Level::where('slug', 'intermedio')->first();
        $avanzado     = Level::where('slug', 'avanzado')->first();

        // ============================================================
        // COURSE 1: Introducción a la Programación
        // ============================================================
        $c1 = Course::updateOrCreate(
            ['slug' => 'introduccion-a-la-programacion'],
            [
                'title'       => 'Introducción a la Programación',
                'description' => 'Aprende los conceptos fundamentales de la programación desde cero usando PHP.',
                'icon'        => '💡',
                'order'       => 1,
                'level_id'    => $principiante->id,
                'is_premium'  => false,
            ]
        );

        $lessons1 = [
            [
                'title' => '¿Qué es programar?',
                'order' => 1,
                'xp'    => 15,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Programar es darle instrucciones precisas a una computadora para que realice tareas. La computadora hace exactamente lo que le dices, ni más ni menos. Por eso las instrucciones deben ser exactas y ordenadas.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Imagina que tienes que explicarle a alguien cómo hacer un sandwich, pero esa persona no sabe absolutamente nada del mundo. Si dices "haz un sandwich", no sabrá qué hacer. Debes decir: abre el pan, pon el queso, cierra el pan. La programación es igual de específica.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>En PHP, la palabra <strong>echo</strong> le dice a la computadora "muestra este texto en pantalla". El texto que quieres mostrar va entre comillas simples. Al final de toda instrucción en PHP va un punto y coma (;) obligatorio.</p>
<p>Tu tarea es escribir una instrucción echo que muestre el texto <em>Hola Mundo</em>. Recuerda: la palabra echo, luego un espacio, luego el texto entre comillas simples, y al final el punto y coma.</p></div></div>',
                'instructions' => 'Escribe la instrucción completa que muestre el texto Hola Mundo en pantalla usando echo. Recuerda que el texto va entre comillas simples y al final va punto y coma.',
                'starter'      => "echo '___';",
                'solution'     => "echo 'Hola Mundo';",
                'expected'     => "echo 'hola mundo';",
            ],
            [
                'title' => 'Variables — Guardar información',
                'order' => 2,
                'xp'    => 20,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Una variable es un espacio en la memoria de la computadora donde guardas información para usarla después. En PHP, todas las variables empiezan con el símbolo dólar ($) seguido del nombre que le quieras dar.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Imagina una caja de cartón con una etiqueta pegada. La etiqueta es el nombre de la variable (por ejemplo $nombre) y lo que metes dentro de la caja es el valor (por ejemplo la palabra Ana). Cuando necesitas ese dato, llamas a la caja por su etiqueta y obtienes lo que guardaste.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Para crear una variable en PHP escribes: el símbolo $, el nombre de la variable, el signo igual (=), y el valor. Si el valor es texto, va entre comillas simples. Para mostrar una variable usas echo seguido del nombre de la variable con su $.</p>
<p>Tu tarea tiene dos líneas: primero crea la variable $nombre con el valor Ana, y en la segunda línea muéstrala usando echo.</p></div></div>',
                'instructions' => 'Completa la variable $nombre asignándole el valor Ana entre comillas simples. La segunda línea ya está escrita — muestra la variable con echo.',
                'starter'      => '$nombre = \'___\';' . "\n" . 'echo $nombre;',
                'solution'     => '$nombre = \'Ana\';' . "\n" . 'echo $nombre;',
                'expected'     => '$nombre = \'ana\';' . "\n" . 'echo $nombre;',
            ],
            [
                'title' => 'Números y operaciones matemáticas',
                'order' => 3,
                'xp'    => 15,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Las computadoras son excelentes calculadoras. En PHP puedes hacer cualquier operación matemática directamente. Los números NO llevan comillas — solo el texto las necesita. Los operadores son: + para sumar, - para restar, * para multiplicar, / para dividir.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>PHP actúa como una calculadora científica. Escribes la operación y guarda el resultado en una variable. La diferencia con una calculadora normal es que puedes guardar ese resultado y usarlo en otras partes del programa.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Debes guardar en la variable $resultado la suma de 10 más 5. Los números van directamente sin comillas. Luego la segunda línea muestra el resultado. El valor que quieres obtener es 15.</p></div></div>',
                'instructions' => 'Completa el número que falta en la suma para que $resultado valga 15. El primer número es 10, debes escribir el segundo número después del signo +.',
                'starter'      => '$resultado = 10 + ___;' . "\n" . 'echo $resultado;',
                'solution'     => '$resultado = 10 + 5;' . "\n" . 'echo $resultado;',
                'expected'     => '$resultado = 10 + 5;' . "\n" . 'echo $resultado;',
            ],
            [
                'title' => 'Tipos de datos',
                'order' => 4,
                'xp'    => 20,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Los datos en programación tienen tipos. Los más básicos son: string (texto entre comillas), integer (número entero sin comillas), float (número con decimales), boolean (solo puede ser true o false, sin comillas). Cada tipo se comporta diferente en el código.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>En la vida real los datos también tienen tipos: tu nombre es texto, tu edad es un número entero, tu estatura puede ser decimal, y si tienes mascota la respuesta es sí (true) o no (false). En programación es exactamente igual, solo que usamos términos en inglés.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes cuatro variables declaradas. La última, $verdadero, necesita un valor booleano. Los valores booleanos en PHP son dos palabras reservadas: true (verdadero) y false (falso). Se escriben sin comillas y en minúsculas.</p></div></div>',
                'instructions' => 'Completa la variable $verdadero con el valor booleano que representa verdadero. Es una de dos palabras: true o false. Va sin comillas.',
                'starter'      => '$texto = \'Hola\';' . "\n" . '$numero = 42;' . "\n" . '$decimal = 3.14;' . "\n" . '$verdadero = ___;',
                'solution'     => '$texto = \'Hola\';' . "\n" . '$numero = 42;' . "\n" . '$decimal = 3.14;' . "\n" . '$verdadero = true;',
                'expected'     => '$texto = \'hola\';' . "\n" . '$numero = 42;' . "\n" . '$decimal = 3.14;' . "\n" . '$verdadero = true;',
            ],
            [
                'title' => 'Condicionales if/else — Tomando decisiones',
                'order' => 5,
                'xp'    => 25,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Un condicional if permite que tu programa tome decisiones. Si la condición entre paréntesis es verdadera, ejecuta el código del primer bloque. Si es falsa, ejecuta el bloque else. Esto hace que los programas sean inteligentes y respondan de forma diferente según los datos.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Es como decidir qué ropa ponerte en la mañana: SI la temperatura es menor a 15 grados, me pongo abrigo. SI NO (else), me pongo camiseta. El programa evalúa una condición y elige qué camino tomar.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes una variable $edad con valor 20. La estructura if ya está casi completa. Falta la palabra que introduce el bloque alternativo cuando la condición es falsa. Esa palabra en inglés significa "si no" o "de lo contrario".</p></div></div>',
                'instructions' => 'Escribe la palabra clave en inglés que introduce el bloque alternativo cuando la condición if es falsa. Es la misma palabra que significa "si no" en la estructura if/___.',
                'starter'      => '$edad = 20;' . "\n" . 'if($edad >= 18){' . "\n" . '  echo \'Mayor de edad\';' . "\n" . '} ___ {' . "\n" . '  echo \'Menor de edad\';' . "\n" . '}',
                'solution'     => '$edad = 20;' . "\n" . 'if($edad >= 18){' . "\n" . '  echo \'Mayor de edad\';' . "\n" . '} else {' . "\n" . '  echo \'Menor de edad\';' . "\n" . '}',
                'expected'     => '$edad = 20;' . "\n" . 'if($edad >= 18){' . "\n" . '  echo \'mayor de edad\';' . "\n" . '} else {' . "\n" . '  echo \'menor de edad\';' . "\n" . '}',
            ],
            [
                'title' => 'Operadores de comparación',
                'order' => 6,
                'xp'    => 20,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Los operadores de comparación comparan dos valores y devuelven true o false. Son esenciales para las condiciones. Los principales son: == (igual a), != (diferente de), > (mayor que), < (menor que), >= (mayor o igual), <= (menor o igual).</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Son como las preguntas que le haces al programa: ¿Es el precio mayor a 100? ¿Es el nombre igual a Ana? ¿Es la edad menor o igual a 18? La respuesta siempre es sí (true) o no (false), y con esa respuesta el programa decide qué hacer.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes dos variables: $a con valor 10 y $b con valor 5. La condición del if necesita un operador para preguntar si $a es mayor que $b. Ese operador es el símbolo de mayor que, que es como una flecha apuntando hacia la derecha.</p></div></div>',
                'instructions' => 'Completa con el operador que verifica si $a es mayor que $b. Es el símbolo matemático de mayor que — una sola letra o símbolo que separa los dos valores en la condición.',
                'starter'      => '$a = 10;' . "\n" . '$b = 5;' . "\n" . 'if($a ___ $b){' . "\n" . '  echo \'$a es mayor\';' . "\n" . '}',
                'solution'     => '$a = 10;' . "\n" . '$b = 5;' . "\n" . 'if($a > $b){' . "\n" . '  echo \'$a es mayor\';' . "\n" . '}',
                'expected'     => '$a = 10;' . "\n" . '$b = 5;' . "\n" . 'if($a > $b){' . "\n" . '  echo \'$a es mayor\';' . "\n" . '}',
            ],
            [
                'title' => 'Bucle while — Repetir mientras',
                'order' => 7,
                'xp'    => 25,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Un bucle while repite un bloque de código mientras una condición sea verdadera. Necesita tres cosas: una variable contador antes del bucle, la condición de repetición, y dentro del bucle el incremento del contador. Sin el incremento el bucle nunca terminaría.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Imagina que tienes que darle la vuelta a un parque. Sigues caminando MIENTRAS no hayas completado las 5 vueltas. Cada vez que terminas una vuelta, incrementas tu contador. Cuando el contador llega a 5, la condición es falsa y te detienes.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>El bucle while ya está casi completo. Tiene el contador $i iniciado en 1, la condición mientras $i sea menor o igual a 5, y dentro muestra el valor de $i. Pero falta la instrucción que aumenta $i en 1 cada vez. En PHP escribir $i++ es la forma corta de decir suma 1 a $i.</p></div></div>',
                'instructions' => 'Completa con la instrucción que incrementa $i en 1 cada vez que el bucle se repite. En PHP existe una forma corta de escribir esto usando el nombre de la variable seguido de dos signos de suma.',
                'starter'      => '$i = 1;' . "\n" . 'while($i <= 5){' . "\n" . '  echo $i . \' \';' . "\n" . '  ___;' . "\n" . '}',
                'solution'     => '$i = 1;' . "\n" . 'while($i <= 5){' . "\n" . '  echo $i . \' \';' . "\n" . '  $i++;' . "\n" . '}',
                'expected'     => '$i = 1;' . "\n" . 'while($i <= 5){' . "\n" . '  echo $i . \' \';' . "\n" . '  $i++;' . "\n" . '}',
            ],
            [
                'title' => 'Bucle for — Repetir con contador',
                'order' => 8,
                'xp'    => 25,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>El bucle for es más compacto que el while. En una sola línea define las tres partes: inicio del contador, condición de parada, e incremento. Es ideal cuando sabes exactamente cuántas veces quieres repetir algo. La estructura es: for(inicio; condición; incremento){ código }</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Es como programar una alarma que suene 10 veces. Le dices: empieza en 1, sigue mientras sea menor o igual a 10, y suma 1 cada vez. Todo eso en una sola línea, mucho más compacto que el while.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes un bucle for que debe contar del 1 al 10 mostrando cada número seguido de un espacio. El bucle ya tiene el inicio ($i = 1), la condición ($i <= 10), pero falta la tercera parte que incrementa $i en 1 cada vez. Es la misma instrucción del bucle while.</p></div></div>',
                'instructions' => 'Completa la tercera parte del for con la instrucción que incrementa $i. Va entre el segundo punto y coma y el paréntesis de cierre. Es la forma corta de sumar 1 a $i.',
                'starter'      => 'for($i = 1; $i <= 10; ___){' . "\n" . '  echo $i . \' \';' . "\n" . '}',
                'solution'     => 'for($i = 1; $i <= 10; $i++){' . "\n" . '  echo $i . \' \';' . "\n" . '}',
                'expected'     => 'for($i = 1; $i <= 10; $i++){' . "\n" . '  echo $i . \' \';' . "\n" . '}',
            ],
            [
                'title' => 'Arrays — Listas de datos',
                'order' => 9,
                'xp'    => 25,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Un array es una variable especial que puede guardar múltiples valores al mismo tiempo. Se crea con corchetes y los valores separados por comas. Cada valor tiene una posición numérica llamada índice que empieza SIEMPRE desde 0, nunca desde 1.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Imagina una estantería con cajones numerados empezando desde 0. El cajón 0 tiene la primera cosa, el cajón 1 tiene la segunda, el cajón 2 la tercera. Si tienes [\'rojo\', \'verde\', \'azul\'], el rojo está en la posición 0, el verde en la 1, y el azul en la 2.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes un array $colores con tres colores. Para acceder a un elemento específico escribes el nombre del array seguido de corchetes con el número de la posición. Si quieres el segundo elemento (verde), ¿en qué posición está si los índices empiezan desde 0?</p></div></div>',
                'instructions' => 'Escribe el número de índice correcto para acceder al segundo elemento del array (verde). Recuerda que los índices empiezan desde 0, así que el segundo elemento está en la posición número uno.',
                'starter'      => '$colores = [\'rojo\', \'verde\', \'azul\'];' . "\n" . 'echo $colores[___];',
                'solution'     => '$colores = [\'rojo\', \'verde\', \'azul\'];' . "\n" . 'echo $colores[1];',
                'expected'     => '$colores = [\'rojo\', \'verde\', \'azul\'];' . "\n" . 'echo $colores[1];',
            ],
            [
                'title' => 'foreach — Recorrer listas',
                'order' => 10,
                'xp'    => 30,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>El foreach recorre automáticamente cada elemento de un array, uno por uno, desde el primero hasta el último. Es más sencillo que usar un for con índices porque no necesitas llevar la cuenta. La estructura es: foreach($array as $elemento){ código con $elemento }</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Como leer una lista de asistencia en clase: vas diciendo cada nombre uno por uno hasta terminar la lista. El foreach hace eso automáticamente — saca cada elemento del array, lo pone en una variable temporal, ejecuta el código, y pasa al siguiente.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>La estructura foreach necesita la palabra clave que la inicia, el array que recorre, la palabra as, y el nombre de la variable temporal. La variable temporal es $animal — en cada vuelta tendrá el valor de un animal diferente del array.</p></div></div>',
                'instructions' => 'Completa con la palabra clave que inicia el bucle de recorrido de arrays en PHP. Es una palabra en inglés formada por for y each (para cada uno).',
                'starter'      => '$animales = [\'perro\', \'gato\', \'pez\'];' . "\n" . '___($animales as $animal){' . "\n" . '  echo $animal . \' \';' . "\n" . '}',
                'solution'     => '$animales = [\'perro\', \'gato\', \'pez\'];' . "\n" . 'foreach($animales as $animal){' . "\n" . '  echo $animal . \' \';' . "\n" . '}',
                'expected'     => '$animales = [\'perro\', \'gato\', \'pez\'];' . "\n" . 'foreach($animales as $animal){' . "\n" . '  echo $animal . \' \';' . "\n" . '}',
            ],
            [
                'title' => 'Funciones — Código reutilizable',
                'order' => 11,
                'xp'    => 30,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Una función es un bloque de código con nombre que puedes ejecutar todas las veces que quieras sin repetir el código. Se define una vez con la palabra function, y se usa escribiendo su nombre con paréntesis. Puede recibir valores (parámetros) y devolver un resultado (return).</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Como una receta guardada en tu teléfono. La escribes una vez (defines la función) y la puedes hacer todas las veces que quieras (llamar la función). Cada vez que la haces puedes usar ingredientes diferentes (parámetros) y obtienes el plato terminado (return).</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes una función llamada sumar que recibe dos parámetros $a y $b. Dentro de la función hay un return que debe devolver la suma de los dos parámetros. El operador que une los dos valores sumándolos es el signo más. El segundo parámetro que falta en el return empieza con dólar.</p></div></div>',
                'instructions' => 'Completa el return de la función con el segundo parámetro que falta. La función recibe $a y $b, y debe devolver su suma. El primer parámetro ya está, falta el segundo después del operador +.',
                'starter'      => 'function sumar($a, $b){' . "\n" . '  return $a + ___;' . "\n" . '}' . "\n" . 'echo sumar(3, 7);',
                'solution'     => 'function sumar($a, $b){' . "\n" . '  return $a + $b;' . "\n" . '}' . "\n" . 'echo sumar(3, 7);',
                'expected'     => 'function sumar($a, $b){' . "\n" . '  return $a + $b;' . "\n" . '}' . "\n" . 'echo sumar(3, 7);',
            ],
            [
                'title' => 'Arrays asociativos — Diccionarios',
                'order' => 12,
                'xp'    => 30,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>Los arrays asociativos usan palabras como índice en vez de números. En lugar de $arr[0] usas $arr[\'nombre\']. Se crean con el operador => que separa la clave del valor. Son perfectos para representar objetos del mundo real con sus características.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Como una ficha de contacto en tu teléfono: buscas por el nombre del campo (nombre, teléfono, email) en lugar de por posición. Es mucho más intuitivo que recordar que el email está en la posición 3.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes un array asociativo $persona con tres campos: nombre, edad y ciudad. Para acceder al valor de ciudad, escribes el nombre del array, luego corchetes, y dentro de los corchetes el nombre del campo entre comillas simples. El campo que quieres mostrar tiene que ver con la ubicación geográfica.</p></div></div>',
                'instructions' => 'Completa el acceso al array escribiendo entre los corchetes el nombre del campo que corresponde a la ciudad de la persona. El campo existe en el array y su nombre describe una ubicación.',
                'starter'      => '$persona = [\'nombre\' => \'Carlos\', \'edad\' => 30, \'ciudad\' => \'Bogotá\'];' . "\n" . 'echo $persona[\'___\'];',
                'solution'     => '$persona = [\'nombre\' => \'Carlos\', \'edad\' => 30, \'ciudad\' => \'Bogotá\'];' . "\n" . 'echo $persona[\'ciudad\'];',
                'expected'     => '$persona = [\'nombre\' => \'carlos\', \'edad\' => 30, \'ciudad\' => \'bogotá\'];' . "\n" . 'echo $persona[\'ciudad\'];',
            ],
            [
                'title' => 'Funciones nativas de PHP',
                'order' => 13,
                'xp'    => 25,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>PHP incluye cientos de funciones ya programadas que puedes usar directamente. Para contar caracteres de un texto existe strlen(). Para contar elementos de un array existe count(). Para convertir texto a mayúsculas existe strtoupper(). Las usas escribiendo su nombre con el valor entre paréntesis.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Como las aplicaciones preinstaladas en tu teléfono. No tienes que programar la calculadora, solo la usas. PHP tiene "aplicaciones" para casi todo: buscar en textos, ordenar arrays, trabajar con fechas, hacer operaciones matemáticas.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>Tienes la variable $texto con una palabra. Necesitas usar la función de PHP que cuenta cuántos caracteres tiene un texto. El nombre de esa función viene de las palabras en inglés string length (longitud de cadena). Va antes del paréntesis con la variable adentro.</p></div></div>',
                'instructions' => 'Escribe el nombre de la función PHP que cuenta los caracteres de un texto. Su nombre en inglés es string length, abreviado. Va antes del paréntesis que contiene $texto.',
                'starter'      => '$texto = \'Programacion\';' . "\n" . 'echo ___(texto);',
                'solution'     => '$texto = \'Programacion\';' . "\n" . 'echo strlen($texto);',
                'expected'     => '$texto = \'programacion\';' . "\n" . 'echo strlen($texto);',
            ],
            [
                'title' => 'Manejo de errores — try/catch',
                'order' => 14,
                'xp'    => 30,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>En programación los errores son inevitables. PHP tiene una estructura try/catch para capturarlos sin que el programa se caiga. El bloque try contiene el código que podría fallar. El bloque catch contiene qué hacer cuando hay un error. Si no hay error, el catch se ignora.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Como usar casco cuando andas en bicicleta. Intentas (try) hacer el recorrido normalmente. Si te caes (error), el casco (catch) te protege y puedes continuar. Sin el casco, una caída podría ser fatal para el programa.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>La estructura tiene el bloque try ya completo. Falta la palabra que inicia el bloque que captura los errores. Esta palabra en inglés significa atrapar o capturar. Va seguida de paréntesis con el tipo de excepción.</p></div></div>',
                'instructions' => 'Escribe la palabra clave en inglés que introduce el bloque que captura errores en PHP. Significa atrapar. Va después del cierre del bloque try y antes del paréntesis (Exception $e).',
                'starter'      => 'try {' . "\n" . '  $resultado = 10 / 2;' . "\n" . '  echo $resultado;' . "\n" . '} ___ (Exception $e) {' . "\n" . '  echo \'Error: \' . $e->getMessage();' . "\n" . '}',
                'solution'     => 'try {' . "\n" . '  $resultado = 10 / 2;' . "\n" . '  echo $resultado;' . "\n" . '} catch (Exception $e) {' . "\n" . '  echo \'Error: \' . $e->getMessage();' . "\n" . '}',
                'expected'     => 'try {' . "\n" . '  $resultado = 10 / 2;' . "\n" . '  echo $resultado;' . "\n" . '} catch (exception $e) {' . "\n" . '  echo \'error: \' . $e->getmessage();' . "\n" . '}',
            ],
            [
                'title' => 'Proyecto final — Calculadora de promedio',
                'order' => 15,
                'xp'    => 50,
                'content' => '<div class="lesson-content">
<div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3>
<p>En este proyecto final combinarás todo lo aprendido: arrays para guardar datos, foreach para recorrer, variables para acumular resultados, y funciones para organizar el código. Construirás una función que calcula el promedio de un conjunto de notas.</p></div>
<div class="analogy-block"><h3>💡 Piénsalo así</h3>
<p>Un profesor que calcula el promedio de sus estudiantes: recorre todas las notas sumándolas, luego divide entre la cantidad de notas. Tu función hace exactamente eso — es como ser el profesor que calcula promedios automáticamente.</p></div>
<div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3>
<p>La función ya está casi completa. Suma todas las notas en $suma usando foreach. Para calcular el promedio divide $suma entre la cantidad de elementos del array $notas. La función PHP que cuenta cuántos elementos tiene un array recibe el array entre paréntesis.</p></div></div>',
                'instructions' => 'Completa la división del promedio. El numerador es $suma. Para el denominador usa la función PHP que cuenta los elementos de $notas. El resultado es $suma dividido entre esa función aplicada a $notas.',
                'starter'      => 'function calcular_promedio($notas){' . "\n" . '  $suma = 0;' . "\n" . '  foreach($notas as $nota){' . "\n" . '    $suma = $suma + $nota;' . "\n" . '  }' . "\n" . '  return $suma / ___(notas);' . "\n" . '}' . "\n" . '$mis_notas = [80, 90, 75, 95, 85];' . "\n" . 'echo calcular_promedio($mis_notas);',
                'solution'     => 'function calcular_promedio($notas){' . "\n" . '  $suma = 0;' . "\n" . '  foreach($notas as $nota){' . "\n" . '    $suma = $suma + $nota;' . "\n" . '  }' . "\n" . '  return $suma / count($notas);' . "\n" . '}' . "\n" . '$mis_notas = [80, 90, 75, 95, 85];' . "\n" . 'echo calcular_promedio($mis_notas);',
                'expected'     => 'function calcular_promedio($notas){' . "\n" . '  $suma = 0;' . "\n" . '  foreach($notas as $nota){' . "\n" . '    $suma = $suma + $nota;' . "\n" . '  }' . "\n" . '  return $suma / count($notas);' . "\n" . '}' . "\n" . '$mis_notas = [80, 90, 75, 95, 85];' . "\n" . 'echo calcular_promedio($mis_notas);',
            ],
        ];

        foreach ($lessons1 as $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $c1->id, 'slug' => Str::slug($data['title']) . '-c1'],
                [
                    'title'     => $data['title'],
                    'content'   => $data['content'],
                    'order'     => $data['order'],
                    'xp_reward' => $data['xp'],
                    'type'      => 'exercise',
                ]
            );
            Exercise::updateOrCreate(
                ['lesson_id' => $lesson->id],
                [
                    'instructions'    => $data['instructions'],
                    'starter_code'    => $data['starter'],
                    'solution_code'   => $data['solution'],
                    'expected_output' => $data['expected'],
                    'xp_reward'       => $data['xp'],
                ]
            );
        }

        // ============================================================
        // COURSE 2: HTML desde cero
        // ============================================================
        $c2 = Course::updateOrCreate(
            ['slug' => 'html-desde-cero'],
            [
                'title'       => 'HTML desde cero',
                'description' => 'Aprende a estructurar páginas web con HTML desde los conceptos más básicos.',
                'icon'        => '🌐',
                'order'       => 2,
                'level_id'    => $principiante->id,
                'is_premium'  => false,
            ]
        );

        $lessons2 = [
            [
                'title' => '¿Qué es HTML?',
                'order' => 1, 'xp' => 15,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>HTML es el lenguaje que da estructura a las páginas web. No es un lenguaje de programación sino de marcado — usa etiquetas para decirle al navegador cómo mostrar el contenido. Cada etiqueta tiene una apertura y un cierre, y el contenido va entre ellas.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>HTML es como el esqueleto de una persona. Define la estructura: hay una cabeza, un cuerpo, brazos, piernas. Sin el esqueleto no hay forma. El CSS sería la ropa (diseño) y JavaScript el movimiento.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Los títulos en HTML usan etiquetas h seguidas de un número del 1 al 6. El título más importante es h1. Una etiqueta de apertura es el nombre entre signos menor y mayor. La etiqueta de cierre es igual pero con una barra diagonal antes del nombre.</p></div></div>',
                'instructions' => 'Escribe la etiqueta de apertura y cierre de título principal (h1) con el texto "Mi primer título" entre ellas. La etiqueta de apertura no lleva barra, la de cierre sí.',
                'starter'  => '<___>Mi primer título</___>',
                'solution' => '<h1>Mi primer título</h1>',
                'expected' => '<h1>mi primer título</h1>',
            ],
            [
                'title' => 'Párrafos y texto',
                'order' => 2, 'xp' => 15,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La etiqueta p crea párrafos de texto. Es una de las etiquetas más usadas en HTML. Al igual que h1, tiene apertura p y cierre /p, y el texto va entre ellas. El navegador agrega automáticamente espacio antes y después de cada párrafo.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>En un documento de Word cada vez que presionas Enter creas un nuevo párrafo. En HTML haces lo mismo pero con la etiqueta p. Es como decirle al navegador "esto es un bloque de texto independiente".</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Necesitas completar el texto dentro de las etiquetas de párrafo. El texto debe decir "Estoy aprendiendo" seguido del nombre del lenguaje de marcado que estás estudiando en este curso, con punto al final.</p></div></div>',
                'instructions' => 'Completa el párrafo escribiendo dentro de las etiquetas p el texto que indica que estás aprendiendo el lenguaje de marcado de este curso. El nombre del lenguaje son tres letras mayúsculas.',
                'starter'  => '<p>Estoy aprendiendo ___.</p>',
                'solution' => '<p>Estoy aprendiendo HTML.</p>',
                'expected' => '<p>estoy aprendiendo html.</p>',
            ],
            [
                'title' => 'Títulos H1 a H6',
                'order' => 3, 'xp' => 15,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>HTML tiene seis niveles de títulos: h1 es el más grande e importante (título principal de la página), h2 es el siguiente nivel (sección), h3 es subsección, y así hasta h6. Usar el nivel correcto ayuda tanto al diseño como al posicionamiento en buscadores.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como el índice de un libro: el título del libro sería h1, los capítulos serían h2, las secciones dentro de cada capítulo serían h3, y así. Cada nivel es más específico que el anterior.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes tres títulos: el principal ya usa h1, y el tercero ya usa h3. El que falta es el nivel intermedio entre h1 y h3. Ese nivel existe y su número es el que sigue después del 1.</p></div></div>',
                'instructions' => 'Completa con la etiqueta de título de segundo nivel para el subtítulo. Va entre h1 y h3 en jerarquía. El número de esa etiqueta es el que sigue después del 1.',
                'starter'  => "<h1>Título principal</h1>\n<___>Subtítulo</___>\n<h3>Sección</h3>",
                'solution' => "<h1>Título principal</h1>\n<h2>Subtítulo</h2>\n<h3>Sección</h3>",
                'expected' => "<h1>título principal</h1>\n<h2>subtítulo</h2>\n<h3>sección</h3>",
            ],
            [
                'title' => 'Enlaces e hipervínculos',
                'order' => 4, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La etiqueta a (anchor) crea enlaces a otras páginas. Necesita el atributo href (Hypertext REFerence) que indica la URL de destino. El texto entre las etiquetas es lo que el usuario ve y puede hacer clic. Sin href el enlace no navega a ningún lado.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Un enlace es como un letrero en una autopista: el texto del letrero es lo que lees (Ir a Google) y la flecha que apunta en una dirección es el href (la URL real a donde te llevará).</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes una etiqueta a que necesita su atributo de destino. El atributo que le indica al enlace a dónde llevar al usuario es una abreviatura de Hypertext REFerence. Va dentro de la etiqueta de apertura seguido del signo igual y la URL entre comillas.</p></div></div>',
                'instructions' => 'Escribe el nombre del atributo que le dice al enlace su destino. Es una abreviatura de Hypertext REFerence. Va antes del signo = y la URL entre comillas.',
                'starter'  => "<a ___='https://google.com'>Ir a Google</a>",
                'solution' => "<a href='https://google.com'>Ir a Google</a>",
                'expected' => "<a href='https://google.com'>ir a google</a>",
            ],
            [
                'title' => 'Imágenes',
                'order' => 5, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>La etiqueta img muestra imágenes en la página. Es una etiqueta que se cierra sola (no tiene etiqueta de cierre separada). Necesita el atributo src con la ruta de la imagen, y el atributo alt con una descripción de texto alternativo para accesibilidad.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como colgar un cuadro en la pared. src es la dirección del almacén donde está el cuadro. alt es la descripción que le pondrías a alguien con problemas de visión: "esto es una foto de un perro en el parque".</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>La etiqueta img ya tiene el atributo alt. Falta el atributo que indica la ubicación o ruta de la imagen. Su nombre viene de las palabras en inglés source (fuente/origen). Va antes de las comillas con la ruta del archivo.</p></div></div>',
                'instructions' => 'Escribe el nombre del atributo que indica la ruta o ubicación de la imagen. Viene de la palabra en inglés source (fuente). Va antes del signo = y la ruta entre comillas.',
                'starter'  => "<img ___='foto.jpg' alt='Mi fotografía'>",
                'solution' => "<img src='foto.jpg' alt='Mi fotografía'>",
                'expected' => "<img src='foto.jpg' alt='mi fotografía'>",
            ],
            [
                'title' => 'Listas ordenadas y desordenadas',
                'order' => 6, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>HTML tiene dos tipos de listas: ul (unordered list) muestra puntos, ol (ordered list) muestra números. Dentro de cualquier lista cada elemento va en una etiqueta li (list item). Siempre se anidan: la lista contiene los li, nunca al revés.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>ul es como una lista de mercado (no importa el orden): leche, huevos, pan. ol es como una receta (el orden importa): 1. Hervir agua, 2. Agregar pasta, 3. Escurrir. Los items (li) son cada cosa de la lista.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes una lista con la etiqueta ul ya escrita y el primer li completo. El segundo elemento necesita su etiqueta li de apertura y cierre. li significa list item en inglés.</p></div></div>',
                'instructions' => 'Completa las etiquetas del segundo elemento de la lista. Cada elemento de una lista va dentro de una etiqueta cuyas dos letras significan list item en inglés.',
                'starter'  => "<ul>\n  <li>Manzana</li>\n  <___>Pera</___>\n  <li>Uva</li>\n</ul>",
                'solution' => "<ul>\n  <li>Manzana</li>\n  <li>Pera</li>\n  <li>Uva</li>\n</ul>",
                'expected' => "<ul>\n  <li>manzana</li>\n  <li>pera</li>\n  <li>uva</li>\n</ul>",
            ],
            [
                'title' => 'Tablas',
                'order' => 7, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las tablas en HTML organizan datos en filas y columnas. Usan cuatro etiquetas: table (la tabla completa), tr (table row - fila), th (table header - celda de encabezado en negrita), td (table data - celda de datos normal). Se anidan de afuera hacia adentro.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como una hoja de Excel: la hoja completa es table, cada fila horizontal es tr, el encabezado de columna (Nombre, Edad) es th, y cada celda con datos es td. La diferencia es que en Excel haces clic, en HTML escribes etiquetas.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>La fila de encabezados ya está completa con sus th. La segunda fila tiene las etiquetas tr pero las celdas de datos están vacías. Las celdas de datos (no encabezados) usan una etiqueta de dos letras: t seguida de d.</p></div></div>',
                'instructions' => 'Completa las cuatro etiquetas que faltan en la segunda fila. Son celdas de datos normales (no encabezados). Usan la etiqueta de dos letras donde la segunda letra es d de data.',
                'starter'  => "<table>\n  <tr>\n    <th>Nombre</th>\n    <th>Edad</th>\n  </tr>\n  <tr>\n    <___>Ana</___>\n    <___>25</___>\n  </tr>\n</table>",
                'solution' => "<table>\n  <tr>\n    <th>Nombre</th>\n    <th>Edad</th>\n  </tr>\n  <tr>\n    <td>Ana</td>\n    <td>25</td>\n  </tr>\n</table>",
                'expected' => "<table>\n  <tr>\n    <th>nombre</th>\n    <th>edad</th>\n  </tr>\n  <tr>\n    <td>ana</td>\n    <td>25</td>\n  </tr>\n</table>",
            ],
            [
                'title' => 'Formularios',
                'order' => 8, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los formularios permiten al usuario ingresar y enviar información. La etiqueta form los contiene. Dentro van campos input con el atributo type que define qué tipo de dato acepta: text (texto libre), email (correo), password (contraseña oculta), number (número).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como los formularios de papel que llenas en un banco o consultorio. El form es la hoja de papel, cada input es un campo en blanco para escribir. El type define qué tipo de información va en ese campo.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El formulario necesita un input para ingresar un correo electrónico. El atributo type del input define qué tipo de dato acepta. Para correos electrónicos existe un valor específico que hace que el navegador valide automáticamente que sea un email válido.</p></div></div>',
                'instructions' => 'Escribe el valor del atributo type para un campo de correo electrónico. Es la palabra en inglés para correo electrónico. El navegador validará automáticamente que contenga @ y un dominio.',
                'starter'  => "<form>\n  <input type='___' name='email' placeholder='Tu email'>\n  <button type='submit'>Enviar</button>\n</form>",
                'solution' => "<form>\n  <input type='email' name='email' placeholder='Tu email'>\n  <button type='submit'>Enviar</button>\n</form>",
                'expected' => "<form>\n  <input type='email' name='email' placeholder='tu email'>\n  <button type='submit'>enviar</button>\n</form>",
            ],
            [
                'title' => 'Divs — Contenedores',
                'order' => 9, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El div es una etiqueta contenedora genérica. Por sí solo no hace nada visible, pero sirve para agrupar otros elementos y aplicarles estilos o comportamiento. Es el bloque de construcción más usado en el diseño web moderno.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como cajas de cartón transparentes. Metes elementos relacionados en una caja (div), la etiquetas (class o id), y luego le aplicas estilos a toda la caja. Una caja puede contener otras cajas, creando jerarquías de contenido.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Necesitas crear un contenedor que agrupe un título h2 y un párrafo p. La etiqueta para este contenedor genérico tiene tres letras y es una abreviación de division en inglés.</p></div></div>',
                'instructions' => 'Escribe la etiqueta de apertura y cierre del contenedor genérico en HTML. Su nombre es la abreviación de la palabra division en inglés, de tres letras.',
                'starter'  => "<___>\n  <h2>Mi tarjeta</h2>\n  <p>Contenido de la tarjeta</p>\n</___>",
                'solution' => "<div>\n  <h2>Mi tarjeta</h2>\n  <p>Contenido de la tarjeta</p>\n</div>",
                'expected' => "<div>\n  <h2>mi tarjeta</h2>\n  <p>contenido de la tarjeta</p>\n</div>",
            ],
            [
                'title' => 'Atributos class e id',
                'order' => 10, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>class e id son atributos para identificar elementos HTML. class se usa para grupos de elementos que comparten estilos (puede repetirse). id identifica UN elemento único en toda la página (no puede repetirse). Son la base para aplicar CSS y manipular elementos con JavaScript.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>class es como el uniforme de un equipo deportivo — muchos jugadores llevan el mismo uniforme. id es como el número de cédula — cada persona tiene uno único e irrepetible. En HTML, class agrupa, id distingue.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes un div que necesita el atributo para grupos (puede repetirse en varios elementos) y un párrafo que necesita el atributo identificador único. El primero es la palabra en inglés para clase, el segundo es la abreviación de identificador.</p></div></div>',
                'instructions' => 'El div necesita el atributo para grupos reutilizables y el párrafo necesita el identificador único. Escribe class en el primero e id en el segundo.',
                'starter'  => "<div ___='contenedor-principal'>\n  <p ___='parrafo-intro'>Hola mundo</p>\n</div>",
                'solution' => "<div class='contenedor-principal'>\n  <p id='parrafo-intro'>Hola mundo</p>\n</div>",
                'expected' => "<div class='contenedor-principal'>\n  <p id='parrafo-intro'>hola mundo</p>\n</div>",
            ],
            [
                'title' => 'HTML Semántico',
                'order' => 11, 'xp' => 30,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>HTML5 introdujo etiquetas semánticas que describen el propósito del contenido: header (encabezado de página), nav (menú de navegación), main (contenido principal), article (artículo independiente), section (sección temática), footer (pie de página). Mejoran la accesibilidad y el SEO.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>En vez de usar cajas sin etiqueta (div), usas cajas con etiqueta descriptiva. En lugar de una caja anónima para el encabezado, usas una caja que dice "SOY EL ENCABEZADO". Los buscadores y los lectores de pantalla entienden mejor tu página.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes la estructura de una página. El primer contenedor es el encabezado de la página (donde van el logo y el menú). El segundo es donde va el contenido principal del sitio. Sus nombres en inglés describen exactamente eso.</p></div></div>',
                'instructions' => 'Completa con la etiqueta semántica de encabezado de página en los primeros espacios y la etiqueta de contenido principal en los segundos. Sus nombres en inglés son header y main respectivamente.',
                'starter'  => "<___>\n  <h1>Mi Blog</h1>\n  <nav>Menú</nav>\n</___>\n<___>\n  <article>Contenido</article>\n</___>",
                'solution' => "<header>\n  <h1>Mi Blog</h1>\n  <nav>Menú</nav>\n</header>\n<main>\n  <article>Contenido</article>\n</main>",
                'expected' => "<header>\n  <h1>mi blog</h1>\n  <nav>menú</nav>\n</header>\n<main>\n  <article>contenido</article>\n</main>",
            ],
            [
                'title' => 'CSS inline',
                'order' => 12, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>CSS controla el diseño y apariencia de los elementos HTML. La forma más directa es aplicarlo inline usando el atributo style dentro de la etiqueta. Las propiedades CSS se escriben como propiedad: valor; y se separan con punto y coma.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como darle instrucciones de vestimenta directamente a una persona: "tú, específicamente, usa camisa azul y pantalón negro". El atributo style es esa instrucción directa al elemento.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El párrafo necesita el atributo que permite aplicar estilos CSS directamente en el elemento HTML. El nombre de este atributo en inglés significa estilo o modo. Va antes del signo igual y las propiedades entre comillas.</p></div></div>',
                'instructions' => 'Escribe el nombre del atributo HTML que permite aplicar estilos CSS directamente en el elemento. La palabra en inglés significa estilo. Va seguido de = y las propiedades CSS entre comillas.',
                'starter'  => "<p ___='color: blue; font-size: 20px;'>Texto azul grande</p>",
                'solution' => "<p style='color: blue; font-size: 20px;'>Texto azul grande</p>",
                'expected' => "<p style='color: blue; font-size: 20px;'>texto azul grande</p>",
            ],
            [
                'title' => 'Vincular CSS externo',
                'order' => 13, 'xp' => 30,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Lo mejor es tener el CSS en un archivo separado (.css) y vincularlo al HTML con la etiqueta link en el head. Esto permite que todos los estilos estén en un solo lugar y se apliquen a múltiples páginas. El atributo rel indica la relación (stylesheet) y href la ruta del archivo.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>En vez de llevar el manual de estilo pegado en cada página, tienes un manual central. Todas las páginas lo consultan. Si cambias el color del título en el manual, cambia en todas las páginas automáticamente.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>En el head de la página necesitas agregar la etiqueta que vincula archivos externos. No es div ni p ni a — es una etiqueta específica para crear enlaces a recursos externos. Su nombre en inglés significa enlace o vínculo.</p></div></div>',
                'instructions' => 'Escribe la etiqueta HTML que vincula recursos externos como hojas de estilo CSS. Su nombre en inglés significa enlace. Va en el head con los atributos rel y href.',
                'starter'  => "<!DOCTYPE html>\n<html>\n<head>\n  <___ rel='stylesheet' href='estilos.css'>\n</head>\n<body>\n  <h1>Mi página</h1>\n</body>\n</html>",
                'solution' => "<!DOCTYPE html>\n<html>\n<head>\n  <link rel='stylesheet' href='estilos.css'>\n</head>\n<body>\n  <h1>Mi página</h1>\n</body>\n</html>",
                'expected' => "<!doctype html>\n<html>\n<head>\n  <link rel='stylesheet' href='estilos.css'>\n</head>\n<body>\n  <h1>mi página</h1>\n</body>\n</html>",
            ],
            [
                'title' => 'Metaetiquetas',
                'order' => 14, 'xp' => 30,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las metaetiquetas van dentro del head y proveen información sobre la página al navegador y a los buscadores. Las más importantes son: meta charset (define la codificación de caracteres para que las tildes funcionen) y meta viewport (hace la página responsive en móviles).</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Son como la ficha técnica de un libro: autor, editorial, ISBN, idioma. El lector no las ve directamente pero ayudan a catalogar y entender el libro. Los buscadores las usan para indexar tu página.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Necesitas agregar dos metaetiquetas en el head. La etiqueta para información de página tiene cuatro letras y empieza con m. Va en el head junto al title y al link. Se usa para charset, viewport, description, y otros atributos.</p></div></div>',
                'instructions' => 'Escribe la etiqueta de cuatro letras que va en el head para proporcionar metadatos de la página. Se repite dos veces en el código. Su nombre empieza con m y describe datos sobre datos.',
                'starter'  => "<head>\n  <___ charset='UTF-8'>\n  <___ name='viewport' content='width=device-width, initial-scale=1.0'>\n  <title>Mi sitio</title>\n</head>",
                'solution' => "<head>\n  <meta charset='UTF-8'>\n  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n  <title>Mi sitio</title>\n</head>",
                'expected' => "<head>\n  <meta charset='utf-8'>\n  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n  <title>mi sitio</title>\n</head>",
            ],
            [
                'title' => 'Página HTML completa',
                'order' => 15, 'xp' => 50,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Una página HTML bien estructurada siempre empieza con DOCTYPE que le dice al navegador la versión de HTML que usa. Luego viene html, head (información de la página), y body (contenido visible). Esta es la estructura mínima obligatoria de cualquier página web.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como un sobre de carta: tiene el remitente y destinatario en la parte externa (head), la carta adentro (body), y el tipo de correo en la esquina (DOCTYPE). Sin esa estructura el correo podría no llegar bien.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El DOCTYPE está incompleto. Necesita la palabra que indica qué versión de HTML estás usando. La versión actual y más moderna no lleva número — solo su nombre de tres letras.</p></div></div>',
                'instructions' => 'Completa el DOCTYPE con la palabra que identifica el lenguaje de marcado. Es el nombre de tres letras del lenguaje que estás aprendiendo en este curso. Va después de DOCTYPE con un espacio.',
                'starter'  => "<!DOCTYPE ___>\n<html lang='es'>\n<head>\n  <meta charset='UTF-8'>\n  <title>Mi Primera Página</title>\n</head>\n<body>\n  <header><h1>Bienvenido</h1></header>\n  <main><p>Mi primera página web.</p></main>\n  <footer><p>© 2025</p></footer>\n</body>\n</html>",
                'solution' => "<!DOCTYPE html>\n<html lang='es'>\n<head>\n  <meta charset='UTF-8'>\n  <title>Mi Primera Página</title>\n</head>\n<body>\n  <header><h1>Bienvenido</h1></header>\n  <main><p>Mi primera página web.</p></main>\n  <footer><p>© 2025</p></footer>\n</body>\n</html>",
                'expected' => "<!doctype html>\n<html lang='es'>\n<head>\n  <meta charset='utf-8'>\n  <title>mi primera página</title>\n</head>\n<body>\n  <header><h1>bienvenido</h1></header>\n  <main><p>mi primera página web.</p></main>\n  <footer><p>© 2025</p></footer>\n</body>\n</html>",
            ],
        ];

        foreach ($lessons2 as $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $c2->id, 'slug' => Str::slug($data['title']) . '-c2'],
                ['title' => $data['title'], 'content' => $data['content'],
                 'order' => $data['order'], 'xp_reward' => $data['xp'], 'type' => 'exercise']
            );
            Exercise::updateOrCreate(['lesson_id' => $lesson->id], [
                'instructions' => $data['instructions'], 'starter_code' => $data['starter'],
                'solution_code' => $data['solution'], 'expected_output' => $data['expected'],
                'xp_reward' => $data['xp'],
            ]);
        }

        // ============================================================
        // COURSE 3: JavaScript Básico
        // ============================================================
        $c3 = Course::updateOrCreate(
            ['slug' => 'javascript-basico'],
            ['title' => 'JavaScript Básico', 'description' => 'Aprende JavaScript, el lenguaje que da vida e interactividad a las páginas web.',
             'icon' => '⚙️', 'order' => 3, 'level_id' => $aprendiz->id, 'is_premium' => false]
        );

        $lessons3 = [
            [
                'title' => '¿Qué es JavaScript?', 'order' => 1, 'xp' => 15,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>JavaScript es el lenguaje de programación que hace que las páginas web sean interactivas. Mientras HTML estructura el contenido y CSS lo estiliza, JavaScript lo hace dinámico: responde a clicks, valida formularios, actualiza contenido sin recargar la página.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Si el HTML es el esqueleto y el CSS la apariencia, JavaScript es el sistema nervioso. Es lo que hace que cuando haces click en un botón pase algo, que aparezcan notificaciones, que los datos se actualicen en tiempo real.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>console.log() es la forma más básica de mostrar información en JavaScript. Es el equivalente de echo en PHP. Dentro de los paréntesis va el texto entre comillas. Debes mostrar el mensaje Hola JavaScript.</p></div></div>',
                'instructions' => 'Completa el texto dentro de console.log() para que muestre el mensaje de bienvenida a JavaScript. El texto va entre comillas y debe decir Hola seguido de un espacio y el nombre del lenguaje.',
                'starter'  => "console.log('___ JavaScript');",
                'solution' => "console.log('Hola JavaScript');",
                'expected' => "console.log('hola javascript');",
            ],
            [
                'title' => 'Variables con let y const', 'order' => 2, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>JavaScript moderno tiene dos formas de declarar variables: let para variables que pueden cambiar su valor después, y const para constantes que una vez asignadas no deben cambiar. Ambas reemplazaron a la antigua var. Siempre debes declarar la variable antes de usarla.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>let es como un cuaderno de notas donde puedes borrar y reescribir. const es como grabar algo en piedra — una vez escrito no cambia. Usa const por defecto y let solo cuando necesites que el valor cambie.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes dos declaraciones. La primera variable puede cambiar su valor (es el nombre de alguien). La segunda es una constante matemática que nunca cambia (PI). La keyword para variables que cambian es let, la que no cambia es const.</p></div></div>',
                'instructions' => 'Completa la primera línea con la keyword para variables que pueden cambiar, y la segunda con la keyword para valores constantes que no cambian. Una es let y la otra const.',
                'starter'  => "___ nombre = 'María';\n___ PI = 3.14159;\nconsole.log(nombre, PI);",
                'solution' => "let nombre = 'María';\nconst PI = 3.14159;\nconsole.log(nombre, PI);",
                'expected' => "let nombre = 'maría';\nconst pi = 3.14159;\nconsole.log(nombre, pi);",
            ],
            [
                'title' => 'Condicionales en JS', 'order' => 3, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los condicionales en JavaScript funcionan exactamente igual que en PHP: if evalúa una condición, si es verdadera ejecuta el bloque, si es falsa ejecuta el else. La diferencia es que en JS las variables se declaran con let/const y no llevan el signo $.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es el mismo concepto que PHP pero con diferente sintaxis. SI la temperatura es mayor a 25 grados, muestra Hace calor. SI NO, muestra Temperatura normal. El programa siempre toma uno de los dos caminos.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El if necesita un operador de comparación. La temperatura es 30 y queremos saber si es mayor que 25. El operador que verifica si algo es mayor es el símbolo matemático de mayor que.</p></div></div>',
                'instructions' => 'Completa con el operador de comparación que verifica si temperatura es mayor que 25. Es el símbolo matemático de mayor que — una sola tecla en tu teclado.',
                'starter'  => "let temperatura = 30;\nif(temperatura ___ 25){\n  console.log('Hace calor');\n} else {\n  console.log('Temperatura normal');\n}",
                'solution' => "let temperatura = 30;\nif(temperatura > 25){\n  console.log('Hace calor');\n} else {\n  console.log('Temperatura normal');\n}",
                'expected' => "let temperatura = 30;\nif(temperatura > 25){\n  console.log('hace calor');\n} else {\n  console.log('temperatura normal');\n}",
            ],
            [
                'title' => 'Arrays en JS', 'order' => 4, 'xp' => 20,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los arrays en JavaScript funcionan igual que en PHP pero sin el $. Se crean con corchetes y los valores separados por comas. La propiedad length devuelve cuántos elementos tiene. Se accede a los elementos con el índice entre corchetes, empezando desde 0.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Exactamente como el array de PHP pero sin el símbolo dólar. Si tienes [\'manzana\', \'pera\', \'uva\'], la manzana está en [0], la pera en [1], la uva en [2]. .length te diría que hay 3 elementos.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes un array de frutas y necesitas acceder a la propiedad que indica cuántos elementos tiene. En JavaScript los arrays tienen una propiedad incorporada para esto. Su nombre en inglés significa longitud o largo.</p></div></div>',
                'instructions' => 'Escribe el nombre de la propiedad de los arrays en JavaScript que devuelve cuántos elementos contiene. Su nombre en inglés significa longitud. Va después del punto que sigue al nombre del array.',
                'starter'  => "let frutas = ['manzana', 'pera', 'uva', 'mango'];\nconsole.log('Total:', frutas.___);\nconsole.log('Primera:', frutas[0]);",
                'solution' => "let frutas = ['manzana', 'pera', 'uva', 'mango'];\nconsole.log('Total:', frutas.length);\nconsole.log('Primera:', frutas[0]);",
                'expected' => "let frutas = ['manzana', 'pera', 'uva', 'mango'];\nconsole.log('total:', frutas.length);\nconsole.log('primera:', frutas[0]);",
            ],
            [
                'title' => 'Métodos de arrays', 'order' => 5, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los arrays en JavaScript tienen métodos (funciones incorporadas) muy útiles: push() agrega un elemento al final, pop() elimina el último, unshift() agrega al inicio, shift() elimina el primero. Se usan escribiendo el nombre del array, punto, y el nombre del método con paréntesis.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como una pila de platos: push es apilar un plato encima, pop es sacar el plato de arriba. O como una cola en el banco: unshift es colarse al inicio, shift es atender al primero en la fila.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes un array de números y necesitas agregar el número 9 al final. El método para agregar al final del array viene de la idea de empujar algo. En inglés push significa empujar.</p></div></div>',
                'instructions' => 'Escribe el método que agrega el número 9 al final del array. Su nombre en inglés significa empujar. Va después del punto y antes del paréntesis con el valor a agregar.',
                'starter'  => "let numeros = [3, 1, 4, 1, 5];\nnumeros.___(9);\nconsole.log(numeros);\nconsole.log('Total:', numeros.length);",
                'solution' => "let numeros = [3, 1, 4, 1, 5];\nnumeros.push(9);\nconsole.log(numeros);\nconsole.log('Total:', numeros.length);",
                'expected' => "let numeros = [3, 1, 4, 1, 5];\nnumeros.push(9);\nconsole.log(numeros);\nconsole.log('total:', numeros.length);",
            ],
            [
                'title' => 'Bucle for en JS', 'order' => 6, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El bucle for en JavaScript es idéntico al de PHP pero sin el signo $ en las variables. Tiene tres partes separadas por punto y coma: inicialización (let i = 0), condición (i menor que algo), e incremento (i++). El índice típicamente empieza en 0 en JavaScript.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como una cuenta regresiva o progresiva programada. Le dices: empieza aquí, termina allá, aumenta de esta manera. El bucle hace el resto automáticamente.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El bucle va del 0 al 4 (5 repeticiones). En cada vuelta muestra un texto con el número de vuelta. La variable i ya está declarada en el inicio. En el código dentro del bucle, falta escribir el nombre de esa variable para mostrar su valor.</p></div></div>',
                'instructions' => 'Completa con el nombre de la variable contadora del bucle for. Es la variable declarada en la inicialización. Sin el símbolo dólar porque esto es JavaScript, no PHP.',
                'starter'  => "for(let i = 0; i < 5; i++){\n  console.log('Número: ' + ___);\n}",
                'solution' => "for(let i = 0; i < 5; i++){\n  console.log('Número: ' + i);\n}",
                'expected' => "for(let i = 0; i < 5; i++){\n  console.log('número: ' + i);\n}",
            ],
            [
                'title' => 'Funciones en JS', 'order' => 7, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las funciones en JavaScript se definen con la palabra function, seguida del nombre, parámetros entre paréntesis, y el código entre llaves. Para que devuelva un valor se usa return. Para ejecutarla escribes su nombre con paréntesis y los argumentos.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como una máquina expendedora: defines qué hace (la función), le metes monedas (los argumentos al llamarla), y saca el producto (el return). La máquina puede usarse muchas veces con diferentes monedas.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>La función saludar ya está definida y recibe el parámetro nombre. Para usarla debes llamarla escribiendo su nombre con paréntesis. Dentro del console.log ya está la llamada pero falta el argumento — el texto Ana entre comillas.</p></div></div>',
                'instructions' => 'Completa la llamada a la función dentro de console.log. La función se llama saludar y debe recibir el nombre Ana entre comillas simples como argumento.',
                'starter'  => "function saludar(nombre){\n  return '¡Hola, ' + nombre + '!';\n}\nconsole.log(___('Ana'));",
                'solution' => "function saludar(nombre){\n  return '¡Hola, ' + nombre + '!';\n}\nconsole.log(saludar('Ana'));",
                'expected' => "function saludar(nombre){\n  return '¡hola, ' + nombre + '!';\n}\nconsole.log(saludar('ana'));",
            ],
            [
                'title' => 'Arrow functions', 'order' => 8, 'xp' => 30,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Las arrow functions son una forma más corta de escribir funciones en JavaScript moderno. En lugar de escribir function multiplicar(a, b){ return a * b; } puedes escribir (a, b) => a * b. El símbolo => (flecha) reemplaza la palabra function y el return implícito.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como una abreviación en escritura. En vez de escribir "porque" escribes "pq". Las arrow functions son la versión abreviada de las funciones normales. Hacen lo mismo, solo de forma más compacta.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>La función necesita el símbolo que separa los parámetros del cuerpo de la función en una arrow function. Es un símbolo de dos caracteres que parece una flecha apuntando hacia la derecha, formado por el signo igual y el signo mayor que.</p></div></div>',
                'instructions' => 'Escribe el símbolo de dos caracteres que define una arrow function. Está formado por el signo igual seguido del signo mayor que. Parece una flecha apuntando a la derecha.',
                'starter'  => "const multiplicar = (a, b) ___ a * b;\nconsole.log(multiplicar(4, 5));\nconsole.log(multiplicar(3, 3));",
                'solution' => "const multiplicar = (a, b) => a * b;\nconsole.log(multiplicar(4, 5));\nconsole.log(multiplicar(3, 3));",
                'expected' => "const multiplicar = (a, b) => a * b;\nconsole.log(multiplicar(4, 5));\nconsole.log(multiplicar(3, 3));",
            ],
            [
                'title' => 'Objetos en JS', 'order' => 9, 'xp' => 25,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Un objeto en JavaScript agrupa propiedades relacionadas. Se crea con llaves {} y cada propiedad tiene un nombre (clave) y un valor separados por dos puntos. Para acceder a una propiedad usas el nombre del objeto, un punto, y el nombre de la propiedad.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como el carné de estudiante: tiene nombre, código, programa, semestre. Todos esos datos describen al mismo estudiante. En un objeto JavaScript guardarías: {nombre: Luis, codigo: 12345, programa: Sistemas}.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Tienes un objeto estudiante con tres propiedades. Para acceder a la primera propiedad (nombre) escribes el nombre del objeto, luego punto, luego el nombre de la propiedad. Es el campo que contiene el nombre de la persona.</p></div></div>',
                'instructions' => 'Completa el acceso con punto para obtener la propiedad que contiene el nombre del estudiante. El objeto se llama estudiante y la propiedad que quieres es la que guarda su nombre.',
                'starter'  => "const estudiante = {\n  nombre: 'Luis',\n  edad: 20,\n  carrera: 'Sistemas'\n};\nconsole.log(estudiante.___);\nconsole.log(estudiante.edad);",
                'solution' => "const estudiante = {\n  nombre: 'Luis',\n  edad: 20,\n  carrera: 'Sistemas'\n};\nconsole.log(estudiante.nombre);\nconsole.log(estudiante.edad);",
                'expected' => "const estudiante = {\n  nombre: 'luis',\n  edad: 20,\n  carrera: 'sistemas'\n};\nconsole.log(estudiante.nombre);\nconsole.log(estudiante.edad);",
            ],
            [
                'title' => 'Manipulación del DOM', 'order' => 10, 'xp' => 35,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>El DOM (Document Object Model) es la representación del HTML como objetos JavaScript. Con document.getElementById() puedes seleccionar cualquier elemento HTML por su id y luego modificarlo. Es la base de toda interactividad en páginas web.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>El DOM es como el plano eléctrico de tu casa. Cada interruptor (elemento HTML) tiene un nombre (id). JavaScript es el electricista que puede encontrar cualquier interruptor por nombre y encenderlo, apagarlo o cambiarlo.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Para seleccionar un elemento HTML por su id usas document seguido de punto y luego un método. El nombre de ese método viene de las palabras get (obtener), Element (elemento), By (por), Id (identificador). Es una sola palabra en camelCase.</p></div></div>',
                'instructions' => 'Escribe el método de document que selecciona un elemento por su id. Es una sola palabra en camelCase formada por get, Element, By e Id. Va después del punto de document.',
                'starter'  => "const titulo = document.___('miTitulo');\ntitulo.textContent = 'JavaScript es genial';\ntitulo.style.color = 'blue';",
                'solution' => "const titulo = document.getElementById('miTitulo');\ntitulo.textContent = 'JavaScript es genial';\ntitulo.style.color = 'blue';",
                'expected' => "const titulo = document.getelementbyid('mitulo');\ntitulo.textcontent = 'javascript es genial';\ntitulo.style.color = 'blue';",
            ],
            [
                'title' => 'Eventos', 'order' => 11, 'xp' => 35,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Los eventos permiten que tu código reaccione a acciones del usuario. El método addEventListener() escucha un evento específico en un elemento. Recibe dos argumentos: el nombre del evento (como click, keypress, mouseover) y la función que se ejecuta cuando ocurre.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como instalar una alarma en una puerta. Le dices: escucha el evento de que alguien abra la puerta, y cuando eso pase ejecuta esta acción (suena la alarma). addEventListener hace exactamente eso: escucha y reacciona.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El botón necesita que le agregues un escuchador de eventos. El método para esto se llama en inglés "add event listener" (agregar escuchador de eventos). Es una sola palabra en camelCase.</p></div></div>',
                'instructions' => 'Escribe el método de JavaScript que agrega un escuchador de eventos a un elemento. Su nombre en camelCase viene de las palabras add (agregar), Event (evento), y Listener (escuchador).',
                'starter'  => "const boton = document.getElementById('miBoton');\nboton.___('click', function(){\n  alert('¡Botón presionado!');\n});",
                'solution' => "const boton = document.getElementById('miBoton');\nboton.addEventListener('click', function(){\n  alert('¡Botón presionado!');\n});",
                'expected' => "const boton = document.getelementbyid('miboton');\nboton.addeventlistener('click', function(){\n  alert('¡botón presionado!');\n});",
            ],
            [
                'title' => 'LocalStorage', 'order' => 12, 'xp' => 35,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>localStorage es una mini base de datos en el navegador. Guarda datos que persisten incluso cuando cierras la pestaña. Tiene tres métodos principales: setItem(clave, valor) para guardar, getItem(clave) para leer, y removeItem(clave) para eliminar.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como un cajón en tu escritorio del navegador. Puedes guardar cosas ahí (setItem) y cuando vuelvas al escritorio después de un tiempo (reabrir el navegador), todavía estarán ahí (getItem). Pero si usas el modo incógnito, el cajón se vacía al cerrar.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Necesitas usar el método de localStorage que guarda un dato. Los métodos de localStorage siguen el patrón set/get/remove + Item. Para guardar, el verbo es set. El método completo es setItem.</p></div></div>',
                'instructions' => 'Escribe el método de localStorage que guarda un dato con una clave. El verbo para guardar/establecer en inglés es set. El método completo es ese verbo más la palabra Item, en camelCase.',
                'starter'  => "localStorage.___('usuario', 'Ana');\nconst nombre = localStorage.getItem('usuario');\nconsole.log('Usuario:', nombre);\nlocalStorage.removeItem('usuario');",
                'solution' => "localStorage.setItem('usuario', 'Ana');\nconst nombre = localStorage.getItem('usuario');\nconsole.log('Usuario:', nombre);\nlocalStorage.removeItem('usuario');",
                'expected' => "localstorage.setitem('usuario', 'ana');\nconst nombre = localstorage.getitem('usuario');\nconsole.log('usuario:', nombre);\nlocalstorage.removeitem('usuario');",
            ],
            [
                'title' => 'Fetch — Peticiones a servidores', 'order' => 13, 'xp' => 40,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>fetch() permite hacer peticiones HTTP a servidores para obtener datos sin recargar la página. Devuelve una Promesa. Con .then() procesas la respuesta: primero la conviertes a JSON con .json(), luego accedes a los datos. Con .catch() manejas posibles errores.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como ordenar comida por delivery. Haces el pedido (fetch), esperas que llegue (.then), lo recibes y lo comes (.json() y usar los datos). Si hay problema con la entrega (.catch), haces otra cosa.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>Para hacer una petición HTTP a un servidor en JavaScript existe una función global. Su nombre en inglés viene de la idea de ir a buscar o recuperar algo. Es una sola palabra de cinco letras que empieza con f.</p></div></div>',
                'instructions' => 'Escribe el nombre de la función JavaScript que hace peticiones HTTP. Su nombre en inglés significa ir a buscar o recuperar. Es una sola palabra de cinco letras, empieza con f.',
                'starter'  => "___(\"https://jsonplaceholder.typicode.com/posts/1\")\n  .then(response => response.json())\n  .then(data => console.log(data.title))\n  .catch(error => console.log('Error:', error));",
                'solution' => "fetch(\"https://jsonplaceholder.typicode.com/posts/1\")\n  .then(response => response.json())\n  .then(data => console.log(data.title))\n  .catch(error => console.log('Error:', error));",
                'expected' => "fetch(\"https://jsonplaceholder.typicode.com/posts/1\")\n  .then(response => response.json())\n  .then(data => console.log(data.title))\n  .catch(error => console.log('error:', error));",
            ],
            [
                'title' => 'Async/Await', 'order' => 14, 'xp' => 40,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>async/await es una forma más limpia de trabajar con operaciones que toman tiempo (como fetch). async declara que una función contiene operaciones asíncronas. await pausa la ejecución de esa función hasta que la operación termine, pero sin bloquear el resto del programa.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Como pedir un café en una cafetería. Async es decir "voy a hacer algo que puede tardar". Await es decir "espera aquí hasta que el café esté listo antes de seguir". Mientras tanto, el barista (el navegador) puede atender a otros clientes.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>La función necesita la palabra clave que la declara como asíncrona. Sin esta palabra clave no puedes usar await dentro de ella. La palabra es async, que viene de asynchronous (asíncrono en inglés).</p></div></div>',
                'instructions' => 'Escribe la palabra clave que declara la función como asíncrona. Sin ella no se puede usar await. La palabra es el prefijo común de asíncrono en inglés.',
                'starter'  => "___ function obtenerDatos(){\n  try {\n    const response = await fetch('https://api.example.com/data');\n    const data = await response.json();\n    console.log(data);\n  } catch(error) {\n    console.log('Error:', error);\n  }\n}\nobtenerDatos();",
                'solution' => "async function obtenerDatos(){\n  try {\n    const response = await fetch('https://api.example.com/data');\n    const data = await response.json();\n    console.log(data);\n  } catch(error) {\n    console.log('Error:', error);\n  }\n}\nobtenerDatos();",
                'expected' => "async function obtenerDatos(){\n  try {\n    const response = await fetch('https://api.example.com/data');\n    const data = await response.json();\n    console.log(data);\n  } catch(error) {\n    console.log('error:', error);\n  }\n}\nobtenerdatos();",
            ],
            [
                'title' => 'Proyecto final JS — Calculadora IMC', 'order' => 15, 'xp' => 50,
                'content' => '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>Combinarás funciones, condicionales y operaciones matemáticas para crear una calculadora de Índice de Masa Corporal (IMC). La fórmula es: peso dividido entre la altura al cuadrado. El resultado determina la categoría: bajo peso, normal, sobrepeso u obesidad.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>Es como la calculadora que usa un médico para evaluar el peso de un paciente. Recibe el peso y la altura, hace el cálculo, y clasifica el resultado. Tu función hará exactamente lo mismo — es código que tiene un uso real en salud.</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>El IMC se calcula dividiendo el peso entre la altura elevada al cuadrado. Elevar al cuadrado significa multiplicar el número por sí mismo. En la fórmula ya está la multiplicación: altura multiplicado por algo. Ese algo es la misma variable altura.</p></div></div>',
                'instructions' => 'Completa la fórmula del IMC. La altura debe elevarse al cuadrado (multiplicarse por sí misma). Después del operador * que ya está escrito, escribe la variable que representa la altura.',
                'starter'  => "function calcularIMC(peso, altura){\n  const imc = peso / (altura * ___);\n  if(imc < 18.5) return 'Bajo peso';\n  if(imc < 25) return 'Normal';\n  if(imc < 30) return 'Sobrepeso';\n  return 'Obesidad';\n}\nconsole.log(calcularIMC(70, 1.75));",
                'solution' => "function calcularIMC(peso, altura){\n  const imc = peso / (altura * altura);\n  if(imc < 18.5) return 'Bajo peso';\n  if(imc < 25) return 'Normal';\n  if(imc < 30) return 'Sobrepeso';\n  return 'Obesidad';\n}\nconsole.log(calcularIMC(70, 1.75));",
                'expected' => "function calcularimc(peso, altura){\n  const imc = peso / (altura * altura);\n  if(imc < 18.5) return 'bajo peso';\n  if(imc < 25) return 'normal';\n  if(imc < 30) return 'sobrepeso';\n  return 'obesidad';\n}\nconsole.log(calcularimc(70, 1.75));",
            ],
        ];

        foreach ($lessons3 as $data) {
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $c3->id, 'slug' => Str::slug($data['title']) . '-c3'],
                ['title' => $data['title'], 'content' => $data['content'],
                 'order' => $data['order'], 'xp_reward' => $data['xp'], 'type' => 'exercise']
            );
            Exercise::updateOrCreate(['lesson_id' => $lesson->id], [
                'instructions' => $data['instructions'], 'starter_code' => $data['starter'],
                'solution_code' => $data['solution'], 'expected_output' => $data['expected'],
                'xp_reward' => $data['xp'],
            ]);
        }

        // ============================================================
        // COURSE 4: CSS desde cero
        // ============================================================
        $c4 = Course::updateOrCreate(
            ['slug' => 'css-desde-cero'],
            ['title' => 'CSS desde cero', 'description' => 'Aprende a dar estilo y diseño a tus páginas web con CSS.',
             'icon' => '🎨', 'order' => 4, 'level_id' => $principiante->id, 'is_premium' => false]
        );

        $cssLessons = [
            [1, '¿Qué es CSS?', 15,
             'CSS controla la apariencia visual de los elementos HTML. La propiedad que cambia el color del texto se llama color. Va dentro del selector seguida de dos puntos y el valor.',
             'Completa con el nombre de la propiedad CSS que cambia el color del texto. Esa propiedad tiene el mismo nombre que lo que hace: cambiar el color.',
             "p {\n  ___: red;\n}", "p {\n  color: red;\n}", "p {\n  color: red;\n}"],
            [2, 'Selectores CSS', 15,
             'Los selectores determinan a qué elementos HTML se aplican los estilos. Para aplicar estilos a todos los h1 de la página usas h1 como selector. El selector va antes de las llaves.',
             'Escribe el selector que aplica estilos a todos los títulos principales h1. Es exactamente el nombre de la etiqueta HTML.',
             "___ {\n  font-size: 24px;\n  color: navy;\n}", "h1 {\n  font-size: 24px;\n  color: navy;\n}", "h1 {\n  font-size: 24px;\n  color: navy;\n}"],
            [3, 'Colores y fondos', 15,
             'La propiedad background-color cambia el color de fondo de un elemento. Es diferente a color (que cambia el texto). La propiedad completa es background seguida de guion y la palabra color.',
             'Completa el nombre de la propiedad que cambia el color de fondo. Empieza con background, luego un guion, luego la palabra color.',
             "body {\n  background-___: #1a1a2e;\n  color: white;\n}", "body {\n  background-color: #1a1a2e;\n  color: white;\n}", "body {\n  background-color: #1a1a2e;\n  color: white;\n}"],
            [4, 'El Box Model', 20,
             'El box model define el espacio de un elemento. Padding es el espacio INTERNO entre el contenido y el borde. Margin es el espacio EXTERNO entre el borde y otros elementos. Son propiedades diferentes.',
             'Escribe la propiedad que agrega espacio interno entre el contenido y el borde del elemento. En inglés, la palabra que describe el relleno o almohadilla interior de algo.',
             ".tarjeta {\n  width: 300px;\n  ___: 20px;\n  margin: 10px auto;\n  border: 1px solid gray;\n}", ".tarjeta {\n  width: 300px;\n  padding: 20px;\n  margin: 10px auto;\n  border: 1px solid gray;\n}", ".tarjeta {\n  width: 300px;\n  padding: 20px;\n  margin: 10px auto;\n  border: 1px solid gray;\n}"],
            [5, 'Tipografía', 20,
             'font-family define la fuente del texto. La propiedad completa es font seguida de guion y family. Se pueden listar varias fuentes separadas por coma — si la primera no está disponible, usa la segunda.',
             'Completa el nombre de la propiedad de fuente. Empieza con font, luego guion, luego la palabra que en inglés significa familia o tipo.',
             "p {\n  font-___: Arial, sans-serif;\n  font-size: 16px;\n}", "p {\n  font-family: Arial, sans-serif;\n  font-size: 16px;\n}", "p {\n  font-family: arial, sans-serif;\n  font-size: 16px;\n}"],
            [6, 'Display', 20,
             'La propiedad display controla cómo se muestra un elemento. block hace que ocupe toda la línea. inline solo ocupa el espacio necesario. flex activa el sistema Flexbox. grid activa CSS Grid.',
             'Escribe el valor de display que hace que el elemento se comporte como un bloque que ocupa toda la línea disponible. Es la palabra en inglés para bloque.',
             ".elemento {\n  display: ___;\n  width: 200px;\n  height: 100px;\n}", ".elemento {\n  display: block;\n  width: 200px;\n  height: 100px;\n}", ".elemento {\n  display: block;\n  width: 200px;\n  height: 100px;\n}"],
            [7, 'Flexbox', 30,
             'Flexbox es el sistema moderno para organizar elementos en fila o columna. Se activa poniendo display: flex en el contenedor. justify-content alinea horizontalmente, align-items verticalmente.',
             'Activa Flexbox en el contenedor escribiendo el valor correcto para la propiedad display. El nombre del sistema de diseño flexible en inglés es una palabra de cuatro letras.',
             ".contenedor {\n  display: ___;\n  justify-content: center;\n  align-items: center;\n  gap: 20px;\n}", ".contenedor {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  gap: 20px;\n}", ".contenedor {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  gap: 20px;\n}"],
            [8, 'Posicionamiento', 30,
             'La propiedad position controla cómo se posiciona un elemento. fixed hace que quede fijo en la pantalla sin importar el scroll. relative es relativo a su posición normal. absolute es relativo a su contenedor padre.',
             'Escribe el nombre de la propiedad CSS que controla cómo se posiciona un elemento. Su nombre en inglés es la misma palabra que posición.',
             ".popup {\n  ___: fixed;\n  top: 50%;\n  left: 50%;\n  background: white;\n  padding: 20px;\n}", ".popup {\n  position: fixed;\n  top: 50%;\n  left: 50%;\n  background: white;\n  padding: 20px;\n}", ".popup {\n  position: fixed;\n  top: 50%;\n  left: 50%;\n  background: white;\n  padding: 20px;\n}"],
            [9, 'Bordes y sombras', 25,
             'border-radius redondea las esquinas de un elemento. Con 50% se hace completamente circular. Con valores en px se redondea parcialmente. Va después de border y un guion.',
             'Completa la propiedad que redondea las esquinas. Empieza con border, luego guion, luego la palabra en inglés que describe el radio de una circunferencia.',
             ".boton {\n  padding: 10px 20px;\n  background: blue;\n  color: white;\n  border-___: 25px;\n}", ".boton {\n  padding: 10px 20px;\n  background: blue;\n  color: white;\n  border-radius: 25px;\n}", ".boton {\n  padding: 10px 20px;\n  background: blue;\n  color: white;\n  border-radius: 25px;\n}"],
            [10, 'Variables CSS', 30,
             'Las variables CSS se definen en :root con dos guiones antes del nombre. Para usarlas escribes var() con el nombre de la variable dentro. Centralizar valores permite cambiar el tema completo desde un solo lugar.',
             'Completa el uso de la variable CSS dentro de var(). La variable está definida en :root como --color-principal. Debes escribir exactamente el nombre de esa variable incluyendo los dos guiones iniciales.',
             ":root {\n  --color-principal: #4F8EF7;\n}\nh1 {\n  color: var(___);\n}", ":root {\n  --color-principal: #4F8EF7;\n}\nh1 {\n  color: var(--color-principal);\n}", ":root {\n  --color-principal: #4f8ef7;\n}\nh1 {\n  color: var(--color-principal);\n}"],
            [11, 'Media queries', 35,
             'Las media queries aplican estilos según el tamaño de pantalla. Se escriben con @media seguido de la condición entre paréntesis. max-width: 768px significa "cuando la pantalla sea de máximo 768 píxeles de ancho" (tablets y móviles).',
             'Completa el valor de max-width para que los estilos se apliquen en pantallas de hasta 768 píxeles. Escribe exactamente 768px en el espacio.',
             "@media (max-width: ___){\n  body { font-size: 14px; }\n  .contenedor { flex-direction: column; }\n}", "@media (max-width: 768px){\n  body { font-size: 14px; }\n  .contenedor { flex-direction: column; }\n}", "@media (max-width: 768px){\n  body { font-size: 14px; }\n  .contenedor { flex-direction: column; }\n}"],
            [12, 'CSS Grid', 35,
             'CSS Grid crea layouts de dos dimensiones (filas Y columnas). Se activa con display: grid. grid-template-columns define cuántas columnas hay y su tamaño. 1fr significa 1 fracción del espacio disponible.',
             'Activa CSS Grid en el contenedor escribiendo el valor correcto para display. Es la palabra en inglés para cuadrícula o rejilla, de cuatro letras.',
             ".galeria {\n  display: ___;\n  grid-template-columns: repeat(3, 1fr);\n  gap: 20px;\n}", ".galeria {\n  display: grid;\n  grid-template-columns: repeat(3, 1fr);\n  gap: 20px;\n}", ".galeria {\n  display: grid;\n  grid-template-columns: repeat(3, 1fr);\n  gap: 20px;\n}"],
            [13, 'Animaciones', 35,
             'Las animaciones en CSS se definen con @keyframes y se aplican con la propiedad animation. @keyframes define cómo cambia el elemento de un estado (from) a otro (to). La propiedad animation aplica la animación con: nombre duración tipo.',
             'Escribe el nombre de la propiedad CSS que aplica una animación a un elemento. Es la misma palabra que describe el movimiento o animación en inglés.',
             "@keyframes aparecer {\n  from { opacity: 0; }\n  to { opacity: 1; }\n}\n.elemento {\n  ___: aparecer 0.5s ease;\n}", "@keyframes aparecer {\n  from { opacity: 0; }\n  to { opacity: 1; }\n}\n.elemento {\n  animation: aparecer 0.5s ease;\n}", "@keyframes aparecer {\n  from { opacity: 0; }\n  to { opacity: 1; }\n}\n.elemento {\n  animation: aparecer 0.5s ease;\n}"],
            [14, 'Transiciones', 30,
             'Las transiciones suavizan los cambios de estilo. Se aplican con la propiedad transition. Los valores son: qué propiedad animar (all para todas), duración (0.3s), y tipo de movimiento (ease, linear, ease-in-out).',
             'Escribe la propiedad CSS que hace que los cambios de estilo ocurran de forma gradual y suavizada. Su nombre en inglés es la misma palabra que transición.',
             ".boton {\n  background: blue;\n  color: white;\n  ___: all 0.3s ease;\n}\n.boton:hover {\n  background: darkblue;\n}", ".boton {\n  background: blue;\n  color: white;\n  transition: all 0.3s ease;\n}\n.boton:hover {\n  background: darkblue;\n}", ".boton {\n  background: blue;\n  color: white;\n  transition: all 0.3s ease;\n}\n.boton:hover {\n  background: darkblue;\n}"],
            [15, 'Proyecto final CSS', 50,
             'Combinarás Flexbox, border-radius, box-shadow y transition para crear una tarjeta de perfil profesional que suba al pasar el cursor. flex-direction column apila los elementos verticalmente.',
             'Completa el valor de flex-direction que apila los elementos verticalmente uno sobre otro. En inglés, la dirección que va de arriba hacia abajo en una columna.',
             ".tarjeta {\n  display: flex;\n  flex-direction: ___;\n  align-items: center;\n  padding: 30px;\n  border-radius: 16px;\n  box-shadow: 0 8px 30px rgba(0,0,0,0.1);\n  transition: transform 0.3s ease;\n}\n.tarjeta:hover {\n  transform: translateY(-5px);\n}", ".tarjeta {\n  display: flex;\n  flex-direction: column;\n  align-items: center;\n  padding: 30px;\n  border-radius: 16px;\n  box-shadow: 0 8px 30px rgba(0,0,0,0.1);\n  transition: transform 0.3s ease;\n}\n.tarjeta:hover {\n  transform: translateY(-5px);\n}", ".tarjeta {\n  display: flex;\n  flex-direction: column;\n  align-items: center;\n  padding: 30px;\n  border-radius: 16px;\n  box-shadow: 0 8px 30px rgba(0,0,0,0.1);\n  transition: transform 0.3s ease;\n}\n.tarjeta:hover {\n  transform: translatey(-5px);\n}"],
        ];

        foreach ($cssLessons as [$order, $title, $xp, $content, $instructions, $starter, $solution, $expected]) {
            $fullContent = '<div class="lesson-content"><div class="explanation-block"><h3>📖 ¿Qué vas a aprender?</h3><p>' . explode('. ', $content)[0] . '.</p></div><div class="analogy-block"><h3>💡 Piénsalo así</h3><p>' . (isset(explode('. ', $content)[1]) ? implode('. ', array_slice(explode('. ', $content), 1)) : 'CSS es el lenguaje de diseño de la web.') . '</p></div><div class="example-block"><h3>✍️ ¿Qué debo escribir?</h3><p>' . $instructions . '</p></div></div>';
            $lesson = Lesson::updateOrCreate(
                ['course_id' => $c4->id, 'slug' => Str::slug($title) . '-c4'],
                ['title' => $title, 'content' => $fullContent, 'order' => $order, 'xp_reward' => $xp, 'type' => 'exercise']
            );
            Exercise::updateOrCreate(['lesson_id' => $lesson->id], [
                'instructions' => $instructions, 'starter_code' => $starter,
                'solution_code' => $solution, 'expected_output' => $expected, 'xp_reward' => $xp,
            ]);
        }

        // ============================================================
        // COURSE 5 — COURSE 13: Keep existing, just update expected_output
        // to ensure minimum length of 15 chars
        // ============================================================

        // Fix all existing exercises with expected_output < 15 chars
        \App\Models\Exercise::all()->each(function($exercise) {
            if (strlen($exercise->expected_output) < 15) {
                $normalized = strtolower(trim($exercise->solution_code));
                $normalized = preg_replace('/[ \t]+/', ' ', $normalized);
                $exercise->update(['expected_output' => $normalized]);
            }
        });

    }
}
