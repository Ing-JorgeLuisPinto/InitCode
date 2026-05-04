<x-app-layout>

<style>
.lesson-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.explanation-block {
    background: linear-gradient(135deg, 
        rgba(79, 142, 247, 0.12) 0%, 
        rgba(79, 142, 247, 0.06) 100%);
    border: 1px solid rgba(79, 142, 247, 0.25);
    border-left: 4px solid #4F8EF7;
    border-radius: 0 16px 16px 0;
    padding: 18px 22px;
    position: relative;
}

.analogy-block {
    background: linear-gradient(135deg,
        rgba(234, 179, 8, 0.10) 0%,
        rgba(234, 179, 8, 0.04) 100%);
    border: 1px solid rgba(234, 179, 8, 0.20);
    border-left: 4px solid #EAB308;
    border-radius: 0 16px 16px 0;
    padding: 18px 22px;
    position: relative;
}

.example-block {
    background: linear-gradient(135deg,
        rgba(57, 255, 138, 0.08) 0%,
        rgba(57, 255, 138, 0.03) 100%);
    border: 1px solid rgba(57, 255, 138, 0.18);
    border-left: 4px solid #39FF8A;
    border-radius: 0 16px 16px 0;
    padding: 18px 22px;
    position: relative;
}

.lesson-content h3 {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.explanation-block h3 { 
    color: #93C5FD; 
}

.analogy-block h3 { 
    color: #FCD34D; 
}

.example-block h3 { 
    color: #6EE7B7; 
}

.lesson-content p {
    font-size: 15px;
    line-height: 1.75;
    color: #D1D5DB;
    margin: 0;
}

.lesson-content strong {
    color: #F9FAFB;
    font-weight: 700;
    background: rgba(255,255,255,0.08);
    padding: 1px 5px;
    border-radius: 4px;
}

.lesson-content em {
    color: #93C5FD;
    font-style: normal;
    font-weight: 500;
}

.lesson-content code {
    background: rgba(0,0,0,0.35);
    border: 1px solid #374151;
    border-radius: 5px;
    padding: 2px 7px;
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: 13px;
    color: #34D399;
}

/* Hide solution code blocks - never show answer */
.example-block pre { display: none !important; }
.resultado-esperado { display: none !important; }
[class*="resultado"] { display: none !important; }
[class*="expected-output"] { display: none !important; }

/* CodeMirror styles */
.CodeMirror {
    min-height: 180px;
    height: auto;
    font-size: 14px;
    border-radius: 8px;
}
.CodeMirror-scroll { min-height: 180px; }
</style>

<div class="flex h-screen overflow-hidden">

    {{-- ==================== LEFT PANEL ==================== --}}
    <div class="w-3/5 overflow-y-auto p-6 border-r border-gray-800">

        {{-- Back button --}}
        <a href="{{ route('courses.show', $lesson->course->slug) }}"
           class="inline-flex items-center gap-2 text-gray-400 
                  hover:text-white transition mb-4 text-sm">
            ← Volver al curso
        </a>

        {{-- Course label --}}
        <p class="text-xs uppercase tracking-widest text-blue-400 
                  font-semibold mb-1">
            {{ $lesson->course->title }}
        </p>

        {{-- Lesson title --}}
        <h1 class="text-2xl font-bold text-white mb-2">
            {{ $lesson->title }}
        </h1>

        {{-- XP badge --}}
        <span class="inline-block border rounded-full px-3 py-1 
                     text-xs font-medium mb-6
                     bg-blue-600/20 text-blue-400 border-blue-500/30">
            ⭐ +{{ $exercise ? $exercise->xp_reward : $lesson->xp_reward }} XP al completar
        </span>

        {{-- Lesson content --}}
        <div class="lesson-content mb-6">
            {!! $lesson->content !!}
        </div>

        {{-- Exercise instructions — text only, NO code, NO answers --}}
        @if($exercise)
        <div class="p-4 rounded-xl border border-blue-500/20 bg-blue-500/5 mb-6">
            <h3 class="text-blue-400 font-semibold mb-2 text-sm uppercase tracking-wide">
                ✅ Tu Desafío
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed">
                {{ $exercise->instructions }}
            </p>
            <p class="text-gray-500 text-xs mt-2">
                💡 Escribe tu solución en el editor de la derecha.
            </p>
        </div>
        @endif

        {{-- Bottom navigation --}}
        <div class="flex items-center justify-between pt-4 
                    border-t border-gray-800">
            @php
                $prevLesson = \App\Models\Lesson::where('course_id', $lesson->course_id)
                    ->where('order', '<', $lesson->order)
                    ->orderBy('order', 'desc')
                    ->first();
            @endphp

            @if($prevLesson)
            <a href="{{ route('lessons.show', [$lesson->course->slug, $prevLesson->slug]) }}"
               class="flex items-center gap-2 px-4 py-2 bg-gray-800 
                      hover:bg-gray-700 text-gray-300 rounded-xl text-sm transition">
                ← Anterior
            </a>
            @else
            <div></div>
            @endif

            <span class="text-gray-600 text-xs">
                Lección {{ \App\Models\Lesson::where('course_id', $lesson->course_id)->where('order', '<=', $lesson->order)->count() }}
                de {{ \App\Models\Lesson::where('course_id', $lesson->course_id)->count() }}
            </span>

            @if(isset($nextLesson) && $nextLesson)
            <a href="{{ route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) }}"
               class="flex items-center gap-2 px-4 py-2 bg-blue-600 
                      hover:bg-blue-500 text-white rounded-xl text-sm 
                      font-medium transition">
                Siguiente →
            </a>
            @else
            <a href="{{ route('courses.show', $lesson->course->slug) }}"
               class="flex items-center gap-2 px-4 py-2 bg-green-600 
                      hover:bg-green-500 text-white rounded-xl text-sm 
                      font-medium transition">
                ✅ Finalizar curso
            </a>
            @endif
        </div>

    </div>{{-- end left panel --}}

    {{-- ==================== RIGHT PANEL ==================== --}}
    <div class="w-2/5 flex flex-col bg-gray-900 overflow-y-auto">

        {{-- Editor header --}}
        <div class="flex items-center justify-between px-4 py-3 
                    bg-gray-800 border-b border-gray-700">
            <span class="text-xs font-mono text-gray-400 uppercase tracking-widest">
                EDITOR.JS
            </span>
            <div class="flex gap-1.5">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
            </div>
        </div>

        @if($exercise)

        {{-- Starter code reference --}}
        <div class="px-4 pt-4">
            @if(str_contains($exercise->starter_code ?? '', '___'))
            <div class="p-3 rounded-lg border border-blue-500/30 
                        bg-blue-500/5 mb-3">
                <p class="text-xs text-blue-400 mb-2 font-medium uppercase tracking-wide">
                    Estructura a completar
                </p>
                <pre class="text-sm text-gray-300 font-mono whitespace-pre-wrap leading-relaxed">{{ $exercise->starter_code }}</pre>
            </div>
            @endif
        </div>

        {{-- Code editor --}}
        <div class="px-4 pb-2">
            <textarea id="code-editor" style="display:none;"></textarea>
        </div>

        {{-- Show answer section --}}
        <div x-data="{ attempts: 0, revealed: false, confirmReveal: false, correct: false }"
             class="px-4 pb-3">

            <div x-show="attempts > 0 && !revealed && !correct">
                <div x-show="!confirmReveal">
                    <button @click.prevent="confirmReveal = true"
                            type="button"
                            class="text-sm text-yellow-400 hover:text-yellow-300 
                                   underline transition">
                        👁️ Mostrar respuesta correcta
                    </button>
                </div>
                <div x-show="confirmReveal"
                     class="p-3 rounded-lg border border-yellow-500/30 
                            bg-yellow-500/5 mt-2">
                    <p class="text-yellow-300 text-sm mb-3">
                        ⚠️ Ver la respuesta reduce el XP ganado. ¿Seguro?
                    </p>
                    <div class="flex gap-2">
                        <button type="button"
                                @click.prevent="
                                    revealed = true;
                                    confirmReveal = false;
                                    if(window.editor){
                                        window.editor.setValue('{{ addslashes($exercise->solution_code) }}');
                                    }
                                "
                                class="px-3 py-1.5 bg-yellow-500 text-black 
                                       rounded-lg text-sm font-medium">
                            Sí, mostrar
                        </button>
                        <button type="button"
                                @click.prevent="confirmReveal = false"
                                class="px-3 py-1.5 border border-gray-600 
                                       text-gray-300 rounded-lg text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="revealed"
                 class="mt-2 p-3 rounded-lg border border-yellow-500/30 
                        bg-yellow-500/5">
                <p class="text-yellow-400 text-sm">
                    💡 Respuesta cargada. Ganarás menos XP.
                </p>
            </div>

        </div>

        {{-- Verify button --}}
        <div class="px-4 pb-4">
            <button
                id="btn-verificar"
                type="button"
                data-route="{{ route('exercises.submit', $exercise) }}"
                data-next="{{ isset($nextLesson) && $nextLesson ? route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) : route('courses.show', $lesson->course->slug) }}"
                class="w-full py-3 bg-green-500 hover:bg-green-400 
                       text-black font-bold rounded-xl transition text-base">
                ▶ Verificar código
            </button>
            <div id="result-panel" class="mt-3"></div>
        </div>

        @else

        {{-- No exercise: continue button --}}
        <div class="flex-1 flex items-center justify-center p-6">
            <div class="text-center">
                <p class="text-gray-400 text-sm mb-4">
                    Esta lección es de lectura. Lee el contenido 
                    de la izquierda y continúa.
                </p>
                @if(isset($nextLesson) && $nextLesson)
                <a href="{{ route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) }}"
                   class="block px-6 py-3 bg-blue-600 hover:bg-blue-500 
                          text-white font-bold rounded-xl transition text-center">
                    Continuar →
                </a>
                @else
                <a href="{{ route('courses.show', $lesson->course->slug) }}"
                   class="block px-6 py-3 bg-green-600 hover:bg-green-500 
                          text-white font-bold rounded-xl transition text-center">
                    ✅ Finalizar curso
                </a>
                @endif
            </div>
        </div>

        @endif

    </div>{{-- end right panel --}}

</div>{{-- end flex --}}

{{-- ==================== CODEBOT FLOATING ==================== --}}
<div x-data="{
        open: false,
        messages: [{ role: 'bot', text: '¡Hola! Soy CodeBot 🤖 Puedo ayudarte con esta lección sin darte la respuesta directa. ¿En qué te puedo ayudar?' }],
        input: '',
        loading: false,
        async send() {
            if (!this.input.trim() || this.loading) return;
            const msg = this.input.trim();
            this.messages.push({ role: 'user', text: msg });
            this.input = '';
            this.loading = true;
            this.$nextTick(() => {
                const el = document.getElementById('lesson-chat-msgs');
                if (el) el.scrollTop = el.scrollHeight;
            });
            try {
                const res = await fetch('{{ route('lesson.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        message: msg,
                        lesson_title: @js($lesson->title),
                        exercise_instructions: @js($exercise?->instructions ?? '')
                    })
                });
                const data = await res.json();
                this.messages.push({ role: 'bot', text: data.message ?? 'Error al responder.' });
            } catch(e) {
                this.messages.push({ role: 'bot', text: 'Error de conexión. 😅' });
            }
            this.loading = false;
            this.$nextTick(() => {
                const el = document.getElementById('lesson-chat-msgs');
                if (el) el.scrollTop = el.scrollHeight;
            });
        }
     }"
     class="fixed bottom-6 right-6 z-50">

    {{-- Chat panel --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="mb-4 w-80 bg-gray-900 border border-gray-700 
                rounded-2xl shadow-2xl flex flex-col overflow-hidden"
         style="height: 440px; display: none;">

        <div class="flex items-center justify-between px-4 py-3 bg-blue-600">
            <div class="flex items-center gap-2 text-white">
                <span class="text-xl">🤖</span>
                <div>
                    <p class="font-bold text-sm">CodeBot</p>
                    <p class="text-xs text-blue-200">
                        {{ \Illuminate\Support\Str::limit($lesson->title, 25) }}
                    </p>
                </div>
            </div>
            <button @click="open = false" type="button"
                    class="text-blue-200 hover:text-white text-lg leading-none">
                ✕
            </button>
        </div>

        <div class="px-3 py-2 bg-yellow-500/10 border-b border-yellow-500/20">
            <p class="text-yellow-400 text-xs text-center">
                ⚠️ Da pistas pero nunca la respuesta directa
            </p>
        </div>

        <div id="lesson-chat-msgs"
             class="flex-1 overflow-y-auto p-3 space-y-3">
            <template x-for="(msg, i) in messages" :key="i">
                <div :class="msg.role === 'user' 
                    ? 'flex justify-end' 
                    : 'flex justify-start gap-2'">
                    <div x-show="msg.role === 'bot'"
                         class="w-6 h-6 rounded-full bg-blue-600 flex items-center 
                                justify-center text-xs flex-shrink-0 mt-1">
                        🤖
                    </div>
                    <div :class="msg.role === 'user'
                            ? 'bg-blue-600 text-white rounded-2xl rounded-tr-sm px-3 py-2 max-w-xs text-sm'
                            : 'bg-gray-800 text-gray-200 rounded-2xl rounded-tl-sm px-3 py-2 max-w-xs text-sm'"
                         x-text="msg.text">
                    </div>
                </div>
            </template>
            <div x-show="loading" class="flex justify-start gap-2">
                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-xs">
                    🤖
                </div>
                <div class="bg-gray-800 rounded-2xl px-4 py-3">
                    <div class="flex gap-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                             style="animation-delay:0ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                             style="animation-delay:150ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                             style="animation-delay:300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-3 pb-2 flex gap-2 overflow-x-auto">
            <button type="button"
                    @click="input = 'Dame una pista'; send()"
                    class="text-xs bg-gray-800 text-blue-400 border border-blue-500/30 
                           rounded-full px-3 py-1.5 whitespace-nowrap hover:bg-gray-700 transition">
                💡 Dame una pista
            </button>
            <button type="button"
                    @click="input = 'No entiendo el concepto'; send()"
                    class="text-xs bg-gray-800 text-blue-400 border border-blue-500/30 
                           rounded-full px-3 py-1.5 whitespace-nowrap hover:bg-gray-700 transition">
                🤔 No entiendo
            </button>
            <button type="button"
                    @click="input = 'Dame un ejemplo similar'; send()"
                    class="text-xs bg-gray-800 text-blue-400 border border-blue-500/30 
                           rounded-full px-3 py-1.5 whitespace-nowrap hover:bg-gray-700 transition">
                📝 Otro ejemplo
            </button>
        </div>

        <div class="px-3 pb-3 flex gap-2">
            <input x-model="input"
                   @keydown.enter.prevent="send()"
                   type="text"
                   placeholder="Escribe tu pregunta..."
                   class="flex-1 bg-gray-800 border border-gray-600 rounded-xl 
                          px-3 py-2 text-sm text-white placeholder-gray-500 
                          focus:outline-none focus:border-blue-500 transition">
            <button @click="send()" type="button"
                    :disabled="loading || !input.trim()"
                    class="bg-blue-600 hover:bg-blue-500 disabled:opacity-40 
                           text-white rounded-xl px-3 py-2 transition">
                ➤
            </button>
        </div>
    </div>

    {{-- Toggle button --}}
    <button @click="open = !open" type="button"
            class="w-14 h-14 bg-blue-600 hover:bg-blue-500 text-white 
                   rounded-full shadow-lg flex items-center justify-center 
                   text-2xl transition hover:scale-110">
        <span x-show="!open">🤖</span>
        <span x-show="open" style="display:none">✕</span>
    </button>

</div>{{-- end codebot --}}

{{-- ==================== CODEMIRROR ==================== --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/dracula.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/closebrackets.min.js"></script>

<style>
.CodeMirror {
    min-height: 180px;
    height: auto;
    font-size: 14px;
    border-radius: 8px;
}
.CodeMirror-scroll { min-height: 180px; }
</style>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {

        var textarea = document.getElementById('code-editor');
        if (!textarea || window.editor) return;

        window.editor = CodeMirror.fromTextArea(textarea, {
            mode: 'text/x-php',
            theme: 'dracula',
            lineNumbers: true,
            autoCloseBrackets: true,
            indentUnit: 2,
            tabSize: 2,
            lineWrapping: true,
            autofocus: true,
            readOnly: false
        });

        window.editor.setValue('');

        setTimeout(function() {
            window.editor.refresh();
            window.editor.focus();
        }, 200);

        var btn = document.getElementById('btn-verificar');
        if (!btn) return;

        btn.addEventListener('click', function(e) {
            e.preventDefault();

            var code = window.editor ? window.editor.getValue() : '';

            if (!code || code.trim() === '') {
                var panel = document.getElementById('result-panel');
                if (panel) {
                    panel.innerHTML =
                        '<div class="p-4 bg-yellow-500/20 border border-yellow-500/30 rounded-lg mt-3">' +
                        '<p class="text-yellow-400 font-medium">⚠️ Escribe tu respuesta antes de verificar. 💡</p>' +
                        '</div>';
                }
                return;
            }

            var revealed = false;
            try {
                var alpineEl = document.querySelector('[x-data]');
                if (alpineEl && alpineEl.__x) revealed = alpineEl.__x.$data.revealed || false;
                else if (alpineEl && alpineEl._x_dataStack) revealed = alpineEl._x_dataStack[0].revealed || false;
            } catch(err) {}

            btn.disabled = true;
            btn.textContent = 'Verificando...';

            fetch(btn.dataset.route, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ code: code, revealed: revealed })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                btn.disabled = false;
                btn.textContent = '▶ Verificar código';

                var panel = document.getElementById('result-panel');

                if (data.correct) {
                    // Set correct flag in Alpine
                    try {
                        var el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.correct = true;
                        else if (el && el._x_dataStack) el._x_dataStack[0].correct = true;
                    } catch(err) {}

                    // XP toast
                    var xpToast = document.createElement('div');
                    xpToast.className = 'fixed top-6 right-6 z-50 bg-blue-600 text-white ' +
                        'px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3';
                    xpToast.innerHTML =
                        '<span class="text-2xl">⭐</span>' +
                        '<div><p class="font-bold">+' + data.xp_earned + ' XP ganados</p>' +
                        '<p class="text-blue-200 text-sm">¡Ejercicio completado!</p></div>';
                    document.body.appendChild(xpToast);
                    setTimeout(function() { xpToast.remove(); }, 3000);

                    // Achievement toasts
                    if (data.new_achievements && data.new_achievements.length > 0) {
                        data.new_achievements.forEach(function(a) {
                            var t = document.createElement('div');
                            t.className = 'fixed top-4 right-4 z-50 bg-yellow-500 text-black ' +
                                'px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3';
                            t.innerHTML = '<span class="text-2xl">' + a.icon + '</span>' +
                                '<div><p class="font-bold text-sm">¡Logro desbloqueado!</p>' +
                                '<p class="font-black">' + a.name + '</p></div>';
                            document.body.appendChild(t);
                            setTimeout(function() { t.remove(); }, 4000);
                        });
                    }

                    if (panel) {
                        panel.innerHTML =
                            '<div class="p-4 bg-green-500/20 border border-green-500/30 rounded-lg mt-3">' +
                            '<p class="text-green-400 font-bold">✅ ¡Correcto! +' + data.xp_earned + ' XP 🎉</p>' +
                            '<p class="text-green-300 text-sm mt-1">Pasando a la siguiente lección...</p>' +
                            '</div>';
                    }

                    setTimeout(function() {
                        window.location.href = btn.dataset.next;
                    }, 2000);

                } else {
                    if (panel) {
                        panel.innerHTML =
                            '<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg mt-3">' +
                            '<p class="text-red-400 font-medium">❌ ' +
                            (data.message || '¡Casi! Inténtalo de nuevo 💪') + '</p></div>';
                    }
                    try {
                        var el = document.querySelector('[x-data]');
                        if (el && el.__x) el.__x.$data.attempts++;
                        else if (el && el._x_dataStack) el._x_dataStack[0].attempts++;
                    } catch(err) {}
                }
            })
            .catch(function(err) {
                btn.disabled = false;
                btn.textContent = '▶ Verificar código';
                var panel = document.getElementById('result-panel');
                if (panel) {
                    panel.innerHTML =
                        '<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg mt-3">' +
                        '<p class="text-red-400">❌ Error de conexión. Recarga la página.</p></div>';
                }
            });
        });

    });
})();
</script>

{{-- XP toast on first reading lesson visit --}}
@if(!$alreadyCompleted && !$exercise)
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var t = document.createElement('div');
        t.className = 'fixed top-6 right-6 z-50 bg-blue-600 text-white ' +
            'px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3';
        t.innerHTML = '<span class="text-2xl">⭐</span>' +
            '<div><p class="font-bold">+{{ $lesson->xp_reward }} XP</p>' +
            '<p class="text-blue-200 text-sm">{{ $lesson->title }}</p></div>';
        document.body.appendChild(t);
        setTimeout(function() { t.remove(); }, 3000);
    }, 800);
});
</script>
@endif

</x-app-layout>
