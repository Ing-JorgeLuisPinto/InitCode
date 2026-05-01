@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Gestionar Ejercicio</h2>
    <p class="text-slate-400">Lección: {{ $lesson->title }}</p>
</div>

<div class="max-w-4xl bg-surface rounded-2xl border border-slate-800 p-8">
    <form action="{{ route('admin.exercises.update', $lesson) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-bold mb-2">Instrucciones</label>
                <textarea name="instructions" required rows="3" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">{{ $exercise->instructions }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold mb-2">Código Inicial (Opcional)</label>
                    <textarea name="starter_code" rows="8" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 font-mono text-xs focus:outline-none focus:border-primary">{{ $exercise->starter_code }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Código Solución</label>
                    <textarea name="solution_code" required rows="8" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 font-mono text-xs focus:outline-none focus:border-primary">{{ $exercise->solution_code }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold mb-2">Resultado Esperado</label>
                    <textarea name="expected_output" required rows="4" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 font-mono text-xs focus:outline-none focus:border-primary">{{ $exercise->expected_output }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Pistas (Separadas por comas)</label>
                    <textarea name="hints" rows="4" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">{{ $exercise->hints }}</textarea>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-secondary text-on-secondary font-bold py-3 rounded-xl hover:opacity-90 transition-opacity">
                    Guardar Cambios del Ejercicio
                </button>
                <a href="{{ route('admin.lessons', $lesson->course_id) }}" class="px-6 py-3 border border-slate-800 rounded-xl font-bold hover:bg-slate-800 transition-colors">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
