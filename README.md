# 🚀 CodePath

**Plataforma interactiva para aprender programación desde cero**

CodePath es una aplicación web gamificada inspirada en Duolingo, diseñada para enseñar programación a personas sin experiencia previa. Combina lecciones cortas, ejercicios interactivos, un sistema de XP y rachas, y un tutor con Inteligencia Artificial.

---

## 📋 Tabla de contenidos

- [Características](#-características)
- [Tecnologías](#-tecnologías)
- [Requisitos previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Base de datos](#-base-de-datos)
- [Estructura del proyecto](#-estructura-del-proyecto)
- [Módulos principales](#-módulos-principales)
- [Sistema de gamificación](#-sistema-de-gamificación)
- [Tutor IA (CodeBot)](#-tutor-ia-codebot)
- [Autor](#-autor)

---

## ✨ Características

- Rutas de aprendizaje progresivas (Principiante → Avanzado)
- Lecciones cortas con ejemplos visuales y lenguaje accesible
- Editor de código interactivo con feedback inmediato
- Sistema de XP, niveles y rachas diarias
- Logros y clasificación entre usuarios
- Tutor IA (CodeBot) que responde dudas como un profesor para principiantes
- Dashboard personalizado con progreso y recomendaciones
- Diseño responsive con tema oscuro

---

## 🛠 Tecnologías

| Capa | Tecnología |
|------|-----------|
| Backend | PHP 8+ con Laravel (última versión estable) |
| Frontend | Blade Templates + Tailwind CSS + Alpine.js |
| Base de datos | MySQL (via XAMPP) |
| Autenticación | Laravel Breeze |
| IA | OpenAI API (gpt-4o-mini) |
| Editor de código | CodeMirror 5 (CDN) |
| Servidor local | XAMPP (Apache + MySQL) |

---

## ✅ Requisitos previos

Antes de instalar el proyecto asegúrate de tener:

- [XAMPP](https://www.apachefriends.org/) instalado y corriendo (Apache + MySQL)
- [PHP 8+](https://www.php.net/) instalado
- [Composer](https://getcomposer.org/) instalado
- [Node.js](https://nodejs.org/) instalado (para compilar assets si es necesario)
- [Git](https://git-scm.com/) instalado
- Una cuenta en [OpenAI](https://platform.openai.com/) con API Key generada

---

## 📦 Instalación

**1. Clonar el repositorio**

```bash
git clone https://github.com/Ing-JorgeLuisPinto/Proyecto_B.git
cd Proyecto_B
```

**2. Instalar dependencias de PHP**

```bash
composer install
```

**3. Copiar el archivo de entorno**

```bash
cp .env.example .env
```

**4. Generar la clave de la aplicación**

```bash
php artisan key:generate
```

---

## ⚙️ Configuración

Abre el archivo `.env` y configura las siguientes variables:

```env
APP_NAME=CodePath

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codepath
DB_USERNAME=root
DB_PASSWORD=

OPENAI_API_KEY=tu_api_key_de_openai_aquí
```

> La contraseña de MySQL en XAMPP está vacía por defecto.

---

## 🗄 Base de datos

**1. Crear la base de datos en phpMyAdmin**

- Abre `http://localhost/phpmyadmin`
- Clic en **Nueva**
- Nombre: `codepath`
- Cotejamiento: `utf8mb4_unicode_ci`
- Clic en **Crear**

**2. Ejecutar migraciones y seeders**

```bash
php artisan migrate
php artisan db:seed
```

Esto creará todas las tablas y cargará los datos iniciales:
- 4 niveles (Principiante, Aprendiz, Intermedio, Avanzado)
- 3 cursos con 5 lecciones cada uno y sus ejercicios
- 5 logros desbloqueables

---

## 📁 Estructura del proyecto

```
codepath/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── CourseController.php
│   │   │   ├── LessonController.php
│   │   │   ├── ExerciseController.php
│   │   │   ├── TutorController.php
│   │   │   ├── ProfileController.php
│   │   │   └── LeaderboardController.php
│   │   └── Middleware/
│   │       └── UpdateStreakMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Level.php
│       ├── Course.php
│       ├── Lesson.php
│       ├── Exercise.php
│       ├── UserProgress.php
│       ├── UserExerciseAttempt.php
│       ├── Achievement.php
│       ├── UserAchievement.php
│       └── ChatMessage.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── auth.blade.php
│       ├── auth/
│       │   └── select-level.blade.php
│       ├── dashboard.blade.php
│       ├── courses/
│       ├── lessons/
│       ├── exercises/
│       ├── tutor/
│       ├── profile/
│       └── leaderboard.blade.php
└── routes/
    └── web.php
```

---

## 📚 Módulos principales

### Cursos disponibles

| # | Curso | Nivel | Lecciones |
|---|-------|-------|-----------|
| 1 | 💡 Introducción a la Programación | Principiante | 5 |
| 2 | 🌐 HTML desde cero | Principiante | 5 |
| 3 | ⚙️ JavaScript Básico | Aprendiz | 5 |

### Rutas principales

| Ruta | Descripción |
|------|-------------|
| `/` | Landing page pública |
| `/register` | Registro de usuario |
| `/login` | Inicio de sesión |
| `/select-level` | Selección de nivel inicial |
| `/dashboard` | Panel principal del usuario |
| `/courses` | Lista de cursos |
| `/courses/{slug}` | Detalle de un curso |
| `/courses/{course}/lessons/{lesson}` | Vista de lección |
| `/exercises/{id}` | Ejercicio interactivo |
| `/tutor` | Chat con CodeBot (IA) |
| `/profile` | Perfil del usuario |
| `/leaderboard` | Clasificación global |

---

## 🎮 Sistema de gamificación

### XP (Puntos de experiencia)

| Acción | XP ganado |
|--------|-----------|
| Completar lección de lectura | +10 XP |
| Resolver ejercicio correctamente | +25 XP |
| Resolver al primer intento | +25 XP |
| Completar reto diario | +50 XP |

### Niveles

| Nivel | Nombre | XP requerido |
|-------|--------|-------------|
| 1 | 🌱 Principiante | 0 – 200 XP |
| 2 | 📚 Aprendiz | 201 – 500 XP |
| 3 | ⚡ Intermedio | 501 – 1000 XP |
| 4 | 🚀 Avanzado | 1001+ XP |

### Rachas

El sistema detecta actividad diaria automáticamente:
- Actividad consecutiva día a día → racha incrementa
- Gap de más de 1 día → racha se reinicia a 1

### Logros

| Logro | Condición |
|-------|-----------|
| ⭐ Primera línea | Completa tu primer ejercicio |
| 🔥 En racha | Mantén 3 días consecutivos |
| 🏆 Semana perfecta | Mantén 7 días consecutivos |
| ⚡ Velocista | Resuelve un ejercicio al primer intento |
| 🗺️ Explorador | Inicia 3 cursos diferentes |

---

## 🤖 Tutor IA (CodeBot)

CodeBot es el asistente de IA integrado en la plataforma. Utiliza el modelo `gpt-4o-mini` de OpenAI y está configurado para:

- Explicar conceptos con analogías simples de la vida cotidiana
- Responder siempre en español
- Usar un tono paciente, positivo y alentador
- Adaptar las respuestas a principiantes absolutos
- Mantener historial de conversación por usuario (últimos 20 mensajes)

Para usarlo necesitas una API Key de OpenAI configurada en el `.env`.

> Si quieres usar una alternativa gratuita, puedes reemplazar el endpoint por la API de **Gemini de Google**, que tiene un tier gratuito generoso.

---

## 👤 Autor

**Jorge Luis Pinto**
Estudiante de Ingeniería — UNAB (Universidad Autónoma de Bucaramanga)
GitHub: [@Ing-JorgeLuisPinto](https://github.com/Ing-JorgeLuisPinto)
Email: pintojorgeluis16@gmail.com

---

> CodePath — *Tu camino hacia la programación* 🚀
