@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Nueva Lección</h2>
    <p class="text-slate-400">Curso: {{ $course->title }}</p>
</div>

<div class="max-w-4xl bg-surface rounded-2xl border border-slate-800 p-8">
    <form action="{{ route('admin.lessons.store', $course) }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div class="grid grid-cols-4 gap-6">
                <div class="col-span-3">
                    <label class="block text-sm font-bold mb-2">Título de la Lección</label>
                    <input type="text" name="title" required class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Orden</label>
                    <input type="number" name="order" value="{{ $course->lessons()->count() + 1 }}" required class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-primary">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Contenido (HTML permitido)</label>
                <textarea name="content" required rows="15" class="w-full bg-background border border-slate-800 rounded-xl px-4 py-3 font-mono text-sm focus:outline-none focus:border-primary" placeholder="<p>Bienvenido a esta lección...</p>"></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-primary text-on-primary-container font-bold py-3 rounded-xl hover:opacity-90 transition-opacity">
                    Guardar Lección
                </button>
                <a href="{{ route('admin.lessons', $course) }}" class="px-6 py-3 border border-slate-800 rounded-xl font-bold hover:bg-slate-800 transition-colors">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
