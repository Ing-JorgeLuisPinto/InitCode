# ⚡ InitCode

**Plataforma gamificada de aprendizaje de programación para principiantes absolutos**

InitCode es una aplicación web construida con Laravel que enseña programación desde cero mediante lecciones cortas, ejercicios interactivos, un sistema de XP y rachas diarias inspirado en Duolingo, y un tutor con IA integrado.

---

## 🎯 ¿Qué es InitCode?

InitCode elimina la barrera de entrada a la programación. Cualquier persona sin conocimientos previos puede aprender a programar a través de:

- Explicaciones claras con analogías de la vida cotidiana
- Ejercicios prácticos con retroalimentación inmediata
- Sistema de gamificación con XP, niveles y logros
- Rachas diarias para mantener el hábito de aprendizaje
- Tutor IA que responde dudas sin dar la respuesta directa
- Certificados al completar cursos

---

## 🛠️ Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| Backend | Laravel 12 (PHP 8.2) |
| Frontend | Blade + Tailwind CSS (CDN) + Alpine.js (CDN) |
| Base de datos local | MySQL (XAMPP) |
| Base de datos producción | PostgreSQL (Render.com) |
| Editor de código | CodeMirror 5 |
| IA Tutor | Gemini 2.0 Flash API |
| Diseño UI | Stitch (proyecto "InitCode") |
| Control de versiones | Git + GitHub |
| Despliegue | Render.com |

---

## 📚 Cursos disponibles

| # | Curso | Nivel | Lecciones |
|---|-------|-------|-----------|
| 1 | 💡 Introducción a la Programación | Principiante | 15 |
| 2 | 🌐 HTML desde cero | Principiante | 15 |
| 3 | ⚙️ JavaScript Básico | Aprendiz | 15 |
| 4 | 🎨 CSS desde cero | Principiante | 15 |
| 5 | 🧠 Lógica de Programación | Principiante | 15 |
| 6 | 🐍 Python para Principiantes | Aprendiz | 15 |
| 7 | 🗂️ Git y GitHub Básico | Aprendiz | 15 |
| 8 | 🗃️ Bases de Datos con SQL | Aprendiz | 15 |
| 9 | ⚛️ React para Principiantes | Intermedio | 15 |
| 10 | 🔐 Seguridad Web Básica | Intermedio | 15 |
| 11 | 🔷 TypeScript Básico | Intermedio | 15 |
| 12 | 🟢 Node.js Básico | Intermedio | 15 |
| 13 | 🏗️ Principios SOLID | Avanzado | 15 |

---

## 🎮 Sistema de gamificación

**Niveles de usuario:**

| Nivel | Nombre | XP requerido |
|-------|--------|-------------|
| 1 | 🌱 Principiante | 0 – 200 XP |
| 2 | 📚 Aprendiz | 201 – 500 XP |
| 3 | ⚡ Intermedio | 501 – 1000 XP |
| 4 | 🚀 Avanzado | 1001+ XP |

**XP por actividad:**

- Completar lección de lectura: +10 XP
- Completar ejercicio (primera vez): +15 a +50 XP según dificultad
- Completar ejercicio con respuesta revelada: +5 XP (penalización)
- Completar reto diario: +50 XP

**Logros desbloqueables:**

| Logro | Condición |
|-------|-----------|
| ⭐ Primera línea | Completar el primer ejercicio |
| 🔥 En racha | 3 días consecutivos de práctica |
| 🏆 Semana perfecta | 7 días seguidos |
| ⚡ Velocista | Resolver un ejercicio al primer intento |
| 🗺️ Explorador | Iniciar 3 cursos diferentes |

---

## 🗄️ Estructura de la base de datos

```
users               — Usuarios con XP, racha y nivel
levels              — Niveles de usuario (Principiante → Avanzado)
courses             — Cursos disponibles
lessons             — Lecciones de cada curso
exercises           — Ejercicios con starter_code y expected_output
user_progress       — Progreso del usuario por lección
user_exercise_attempts — Intentos de ejercicios
achievements        — Logros disponibles
user_achievements   — Logros ganados por cada usuario
chat_messages       — Historial del tutor IA por usuario
```

---

## 🚀 Instalación local (XAMPP)

### Requisitos

- PHP 8.2+
- XAMPP (Apache + MySQL)
- Composer
- Git
- Node.js (opcional, para compilar assets)

### Pasos

**1. Clonar el repositorio:**

```bash
git clone https://github.com/Ing-JorgeLuisPinto/Proyecto_B.git
cd Proyecto_B
```

**2. Instalar dependencias:**

```bash
composer install
```

**3. Crear la base de datos en phpMyAdmin:**

- Abre `http://localhost/phpmyadmin`
- Crea una nueva base de datos llamada `initcode`
- Cotejamiento: `utf8mb4_unicode_ci`

**4. Configurar el `.env`:**

```env
APP_NAME=InitCode
APP_ENV=local
APP_KEY=          # se genera en el paso 5
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=initcode
DB_USERNAME=root
DB_PASSWORD=

GEMINI_API_KEY=tu_api_key_de_gemini_aquí
```

**5. Generar clave y ejecutar migraciones:**

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

**6. Instalar Laravel Breeze (si no está):**

```bash
php artisan breeze:install blade
```

**7. Iniciar el servidor:**

```bash
php artisan serve
```

Abre `http://127.0.0.1:8000` en tu navegador.

---

## ☁️ Despliegue en Render.com

### Variables de entorno requeridas en Render

```env
APP_NAME=InitCode
APP_ENV=production
APP_DEBUG=false
APP_URL=https://initcode.onrender.com
APP_KEY=base64:...   # generado con php artisan key:generate --show

DB_CONNECTION=pgsql
DB_HOST=<host-de-render>
DB_PORT=5432
DB_DATABASE=initcode_db
DB_USERNAME=initcode_db_user
DB_PASSWORD=<contraseña-de-render>
DB_SSLMODE=require

GEMINI_API_KEY=tu_api_key
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
```

### Build command

```bash
composer install --no-dev && php artisan migrate --force && php artisan db:seed --force && php artisan storage:link && php artisan config:clear && php artisan view:clear
```

### Start command

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

---

## 🔑 Rutas principales

```
GET  /                        — Landing page pública
GET  /register                — Registro
GET  /login                   — Inicio de sesión
GET  /select-level            — Selección de nivel (post-registro)
GET  /dashboard               — Dashboard principal
GET  /courses                 — Lista de cursos
GET  /courses/{slug}          — Detalle de curso
GET  /courses/{course}/lessons/{lesson} — Lección con ejercicio
POST /exercises/{exercise}/submit       — Verificar código
GET  /tutor                   — Chat con IA
POST /tutor/message           — Enviar mensaje al tutor
GET  /profile                 — Perfil del usuario
GET  /profile/edit            — Editar perfil
GET  /leaderboard             — Clasificación
GET  /admin                   — Panel de administración
```

---

## 🤖 Tutor IA (CodeBot)

InitCode integra la API de Google Gemini (modelo `gemini-2.0-flash`) para ofrecer un tutor que:

- Explica conceptos con analogías simples
- Responde preguntas sobre las lecciones actuales
- Da pistas sin revelar la respuesta directa
- Mantiene historial de conversación por usuario (últimos 20 mensajes)
- Responde siempre en español

Para obtener una API key gratuita: [Google AI Studio](https://aistudio.google.com)

---

## 📁 Estructura del proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── CourseController.php
│   │   ├── LessonController.php
│   │   ├── ExerciseController.php
│   │   ├── TutorController.php
│   │   ├── ProfileController.php
│   │   ├── LeaderboardController.php
│   │   ├── CertificateController.php
│   │   └── AdminController.php
│   └── Middleware/
│       └── UpdateStreakMiddleware.php
├── Models/
│   ├── User.php            (addXP, updateStreak, checkLevelUp, checkAchievements)
│   ├── Course.php
│   ├── Lesson.php
│   ├── Exercise.php
│   ├── Level.php
│   ├── Achievement.php
│   └── ...
database/
├── migrations/             (10 tablas)
└── seeders/
    ├── LevelSeeder.php
    ├── CourseSeeder.php    (13 cursos, 15 lecciones cada uno)
    └── AchievementSeeder.php
resources/views/
├── layouts/
│   ├── app.blade.php       (sidebar + topbar + modo oscuro/claro)
│   └── auth.blade.php
├── dashboard.blade.php
├── courses/
├── lessons/
├── tutor/
├── profile/
├── leaderboard.blade.php
├── admin/
├── certificates/
└── errors/404.blade.php
```

---

## ✨ Características adicionales

- **Modo oscuro/claro** — Toggle persistente con localStorage
- **Perfil editable** — Nombre, foto de perfil, bio y contraseña
- **Certificados en PDF** — Al completar un curso al 100%
- **Panel de administración** — Gestión de cursos, lecciones y usuarios
- **Chatbot flotante** — Disponible en cada lección para pedir pistas
- **Página 404 personalizada** — Con estilo InitCode
- **Racha semanal visual** — Muestra L M M J V S D con días activos resaltados
- **Avatar de usuario** — Visible en perfil, topbar y clasificación
- **Notificaciones de logros** — Toast animado al desbloquear un logro

---

## 👤 Autor

**Jorge Luis Pinto Velandia**
Estudiante de Ingeniería de Sistemas — UNAB (Universidad Autónoma de Bucaramanga)
GitHub: [@Ing-JorgeLuisPinto](https://github.com/Ing-JorgeLuisPinto)
ID Estudiante: U00179255

---

## 📄 Licencia

Proyecto académico — UNAB 2025. Todos los derechos reservados.
