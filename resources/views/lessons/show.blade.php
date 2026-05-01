<x-app-layout>
    <div class="flex h-screen overflow-hidden">

        {{-- LEFT PANEL: Lesson content --}}
        <div class="w-3/5 overflow-y-auto p-6 border-r border-gray-800">

            {{-- Breadcrumb + back button --}}
            <a href="{{ route('courses.show', $lesson->course->slug) }}"
               class="inline-flex items-center gap-2 text-gray-400 
                      hover:text-white transition mb-4 text-sm">
                ← Volver al curso
            </a>

            {{-- Course label --}}
            <p class="text-xs uppercase tracking-widest text-blue-400 font-semibold mb-1">
                {{ $lesson->course->title }}
            </p>

            {{-- Lesson title --}}
            <h1 class="text-2xl font-bold text-white mb-2">
                {{ $lesson->title }}
            </h1>

            {{-- XP badge --}}
            <span class="inline-block bg-blue-600/20 text-blue-400 border 
                         border-blue-500/30 rounded-full px-3 py-1 text-xs 
                         font-medium mb-6">
                ⭐ +{{ $exercise ? $exercise->xp_reward : $lesson->xp_reward }} XP al completar
            </span>

            {{-- Lesson content --}}
            <div class="prose prose-invert max-w-none text-gray-300 
                        leading-relaxed mb-8">
                {!! $lesson->content !!}
            </div>

            @if($exercise)
            <div class="mb-6 p-4 rounded-xl border border-blue-500/20 bg-blue-500/5">
                <h3 class="text-blue-400 font-semibold mb-3">✍️ ¿Qué debo escribir?</h3>
                <p class="text-gray-300 text-sm leading-relaxed">
                    {{ $exercise->instructions }}
                </p>
                <p class="text-gray-500 text-xs mt-3">
                    💡 Escribe tu solución en el editor de la derecha. 
                    Si necesitas ayuda usa el CodeBot 🤖 o las pistas.
                </p>
            </div>
            @endif


        </div>

        {{-- RIGHT PANEL: Exercise --}}
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
            {{-- Reference structure --}}
            @if($exercise)
            <div class="px-6 pt-6">
                <div class="p-4 rounded-xl border border-blue-500/20 bg-blue-500/5 backdrop-blur-sm shadow-inner">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-blue-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-blue-200 font-semibold">Desafío de Código</h4>
                            <p class="text-xs text-blue-400/80">Completa el ejercicio en el editor para continuar</p>
                        </div>
                    </div>

                    <div class="bg-slate-900/80 rounded-lg p-4 border border-blue-500/10 font-mono text-sm shadow-2xl">
                        @if(str_contains($exercise->starter_code, '___'))
                            <div class="flex items-center gap-2 mb-3 text-xs text-blue-400/60 uppercase tracking-widest font-bold">
                                <span>Estructura a completar</span>
                                <div class="h-px flex-1 bg-blue-500/10"></div>
                            </div>
                            <pre class="text-blue-100 leading-relaxed">{{ $exercise->starter_code }}</pre>
                        @else
                            <div class="flex flex-col items-center justify-center py-4 text-center">
                                <div class="w-12 h-12 bg-blue-500/10 rounded-full flex items-center justify-center mb-3">
                                    <span class="text-xl">✨</span>
                                </div>
                                <p class="text-blue-200 font-medium italic">¡Escribe tu solución desde cero!</p>
                                <p class="text-xs text-blue-400/60 mt-1">Usa lo aprendido en la explicación superior</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endif

            {{-- Code editor area --}}
            <div class="px-4 pb-2">
                <textarea id="code-editor" style="display:none;"></textarea>
            </div>

            @if($exercise)


            {{-- Show answer section (Alpine.js) --}}
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
                                        if(window.editor) {
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
                        💡 Respuesta cargada. Ganarás menos XP en este ejercicio.
                    </p>
                </div>

            </div>

            {{-- Verify button --}}
            <div class="px-4 pb-4">
                <button
                    id="btn-verificar"
                    type="button"
                    data-route="{{ route('exercises.submit', $exercise) }}"
                    data-next="{{ $nextLesson ? route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) : route('courses.index') }}"
                    class="w-full py-3 bg-green-500 hover:bg-green-400 
                           text-black font-bold rounded-xl transition text-base">
                    ▶ Verificar código
                </button>

                {{-- Result panel --}}
                <div id="result-panel" class="mt-3"></div>
            </div>
            @else
            {{-- No exercise: just continue button --}}
            <div class="px-4 pb-4">
                <a href="{{ $nextLesson ? route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) : route('courses.index') }}"
                   class="block w-full py-3 bg-blue-600 hover:bg-blue-500 
                          text-white font-bold rounded-xl transition text-center">
                    Continuar →
                </a>
            </div>
            @endif

        </div>{{-- end right panel --}}

    </div>{{-- end flex --}}



    {{-- CodeMirror --}}
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
        min-height: 160px; 
        height: auto;
        font-size: 14px; 
        border-radius: 8px; 
    }
    .CodeMirror-scroll { 
        min-height: 160px; 
    }
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
                    document.getElementById('result-panel').innerHTML =
                        '<div class="p-4 bg-yellow-500/20 border border-yellow-500/30 rounded-lg mt-3">' +
                        '<p class="text-yellow-400 font-medium">⚠️ Escribe tu respuesta antes de verificar. 💡</p>' +
                        '</div>';
                    return;
                }

                var revealed = false;
                try {
                    var el = document.querySelector('[x-data]');
                    if (el && el.__x) revealed = el.__x.$data.revealed || false;
                    else if (el && el._x_dataStack) revealed = el._x_dataStack[0].revealed || false;
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
                        // Set correct flag immediately
                        try {
                            var el = document.querySelector('[x-data]');
                            if (el && el.__x) el.__x.$data.correct = true;
                            else if (el && el._x_dataStack) el._x_dataStack[0].correct = true;
                        } catch(err) {}

                        // Show XP toast with REAL xp_earned from server
                        var xpToast = document.createElement('div');
                        xpToast.className = 'fixed top-6 right-6 z-50 bg-blue-600 text-white ' +
                            'px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 ' +
                            'transition-all duration-500';
                        xpToast.innerHTML = 
                            '<span class="text-2xl">⭐</span>' +
                            '<div>' +
                            '<p class="font-bold text-lg">+' + data.xp_earned + ' XP ganados</p>' +
                            '<p class="text-blue-200 text-sm">¡Ejercicio completado!</p>' +
                            '</div>';
                        document.body.appendChild(xpToast);
                        setTimeout(function() { xpToast.remove(); }, 3000);

                        // Show result panel
                        var panel = document.getElementById('result-panel');
                        if (panel) {
                            panel.innerHTML =
                                '<div class="p-4 bg-green-500/20 border border-green-500/30 rounded-lg mt-3">' +
                                '<p class="text-green-400 font-bold">✅ ¡Correcto! 🎉</p>' +
                                '<p class="text-green-300 text-sm mt-1">Pasando a la siguiente lección...</p>' +
                                '</div>';
                        }

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

                        // Redirect after 2.5 seconds
                        setTimeout(function() {
                            window.location.href = btn.dataset.next;
                        }, 2500);

                    } else {
                        panel.innerHTML =
                            '<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg mt-3">' +
                            '<p class="text-red-400 font-medium">❌ ' +
                            (data.message || '¡Casi! Inténtalo de nuevo 💪') + '</p></div>';
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
                    document.getElementById('result-panel').innerHTML =
                        '<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg mt-3">' +
                        '<p class="text-red-400">❌ Error de conexión. Recarga la página.</p></div>';
                });
            });

        });
    })();
    </script>

    {{-- XP earned toast on first visit --}}
    @if(!$alreadyCompleted && !$exercise)
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var xpToast = document.createElement('div');
        xpToast.className = 'fixed top-6 right-6 z-50 bg-blue-600 text-white ' +
            'px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 ' +
            'transition-all duration-500';
        xpToast.innerHTML = 
            '<span class="text-2xl">⭐</span>' +
            '<div>' +
            '<p class="font-bold text-lg">+{{ $lesson->xp_reward }} XP ganados</p>' +
            '<p class="text-blue-200 text-sm">¡Lección completada!</p>' +
            '</div>';
        document.body.appendChild(xpToast);
        setTimeout(function() { xpToast.remove(); }, 3000);
    });
    </script>
    @endif

    {{-- Floating CodeBot for lessons --}}
<div x-data="{
        open: false,
        messages: [{ 
            role: 'bot', 
            text: '¡Hola! Soy CodeBot 🤖 Estoy aquí para ayudarte con esta lección. Puedo explicarte conceptos y darte pistas, pero NO te daré la respuesta directa. ¡Así aprendes más! 💪 ¿En qué te puedo ayudar?'
        }],
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
                this.messages.push({ role: 'bot', text: 'Error de conexión. Intenta de nuevo. 😅' });
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
         class="mb-4 w-80 bg-gray-900 border border-gray-700 rounded-2xl 
                shadow-2xl flex flex-col overflow-hidden"
         style="height: 440px; display: none;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-blue-600">
            <div class="flex items-center gap-2 text-white">
                <span class="text-xl">🤖</span>
                <div>
                    <p class="font-bold text-sm">CodeBot</p>
                    <p class="text-xs text-blue-200">
                        Lección: {{ Str::limit($lesson->title, 25) }}
                    </p>
                </div>
            </div>
            <button @click="open = false" type="button"
                    class="text-blue-200 hover:text-white text-lg leading-none transition">
                ✕
            </button>
        </div>

        {{-- Warning bar --}}
        <div class="px-3 py-2 bg-yellow-500/10 border-b border-yellow-500/20">
            <p class="text-yellow-400 text-xs text-center">
                ⚠️ CodeBot da pistas pero nunca la respuesta directa
            </p>
        </div>

        {{-- Messages --}}
        <div id="lesson-chat-msgs"
             class="flex-1 overflow-y-auto p-3 space-y-3">
            <template x-for="(msg, i) in messages" :key="i">
                <div :class="msg.role === 'user' 
                    ? 'flex justify-end' 
                    : 'flex justify-start gap-2'">

                    {{-- Bot avatar --}}
                    <div x-show="msg.role === 'bot'"
                         class="w-6 h-6 rounded-full bg-blue-600 flex items-center 
                                justify-center text-xs flex-shrink-0 mt-1">
                        🤖
                    </div>

                    <div :class="msg.role === 'user'
                            ? 'bg-blue-600 text-white rounded-2xl rounded-tr-sm px-3 py-2 max-w-[85%] text-sm leading-relaxed'
                            : 'bg-gray-800 text-gray-200 rounded-2xl rounded-tl-sm px-3 py-2 max-w-[85%] text-sm leading-relaxed'"
                         x-text="msg.text">
                    </div>
                </div>
            </template>

            {{-- Loading dots --}}
            <div x-show="loading" class="flex justify-start gap-2">
                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center 
                            justify-center text-xs flex-shrink-0">
                    🤖
                </div>
                <div class="bg-gray-800 rounded-2xl rounded-tl-sm px-4 py-3">
                    <div class="flex gap-1 items-center">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                             style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                             style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                             style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Suggested questions --}}
        <div class="px-3 pb-2 flex gap-2 overflow-x-auto scrollbar-hide">
            <button type="button"
                    @click="input = 'Dame una pista para este ejercicio'; send()"
                    class="text-xs bg-gray-800 text-blue-400 border border-blue-500/30 
                           rounded-full px-3 py-1.5 whitespace-nowrap 
                           hover:bg-gray-700 transition flex-shrink-0">
                💡 Dame una pista
            </button>
            <button type="button"
                    @click="input = 'No entiendo el concepto de esta lección, explícamelo de otra forma'; send()"
                    class="text-xs bg-gray-800 text-blue-400 border border-blue-500/30 
                           rounded-full px-3 py-1.5 whitespace-nowrap 
                           hover:bg-gray-700 transition flex-shrink-0">
                🤔 No entiendo
            </button>
            <button type="button"
                    @click="input = 'Dame un ejemplo similar pero diferente al del ejercicio'; send()"
                    class="text-xs bg-gray-800 text-blue-400 border border-blue-500/30 
                           rounded-full px-3 py-1.5 whitespace-nowrap 
                           hover:bg-gray-700 transition flex-shrink-0">
                📝 Otro ejemplo
            </button>
        </div>

        {{-- Input area --}}
        <div class="px-3 pb-3 flex gap-2">
            <input x-model="input"
                   @keydown.enter.prevent="send()"
                   type="text"
                   placeholder="Escribe tu pregunta..."
                   class="flex-1 bg-gray-800 border border-gray-600 rounded-xl 
                          px-3 py-2 text-sm text-white placeholder-gray-500 
                          focus:outline-none focus:border-blue-500 transition">
            <button @click="send()"
                    type="button"
                    :disabled="loading || !input.trim()"
                    class="bg-blue-600 hover:bg-blue-500 disabled:opacity-40 
                           disabled:cursor-not-allowed text-white rounded-xl 
                           px-3 py-2 transition">
                ➤
            </button>
        </div>
    </div>

    {{-- Toggle button --}}
    <button @click="open = !open"
            type="button"
            class="w-14 h-14 bg-blue-600 hover:bg-blue-500 text-white 
                   rounded-full shadow-lg flex items-center justify-center 
                   text-2xl transition-all duration-200 hover:scale-110 
                   active:scale-95">
        <span x-show="!open">🤖</span>
        <span x-show="open" style="display:none">✕</span>
    </button>

</div>
</x-app-layout>
