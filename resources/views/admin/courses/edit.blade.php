@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Editar Curso</h2>
    <p class="text-slate-400">Modificando: {{ $course->title }}</p>
</div>

<div class="max-w-2xl bg-surface rounded-2xl border border-slate-800 p-8">
    <form action="{{ route('admin.courses.update', $course) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-bold mb-2">Título del Curso</label>
                <input type="text" name="title" value="{{ $course->title }}" required class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Descripción</label>
                <textarea name="description" required rows="4" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">{{ $course->description }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold mb-2">Categoría</label>
                    <input type="text" name="category" value="{{ $course->category }}" required class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Dificultad</label>
                    <select name="difficulty" required class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">
                        <option value="Básico" {{ $course->difficulty == 'Básico' ? 'selected' : '' }}>Básico</option>
                        <option value="Intermedio" {{ $course->difficulty == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="Avanzado" {{ $course->difficulty == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">URL de la Imagen (Opcional)</label>
                <input type="text" name="image_url" value="{{ $course->image_url }}" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-primary text-on-primary-container font-bold py-3 rounded-xl hover:opacity-90 transition-opacity">
                    Actualizar Curso
                </button>
                <a href="{{ route('admin.courses') }}" class="px-6 py-3 border border-slate-800 rounded-xl font-bold hover:bg-slate-800 transition-colors">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
