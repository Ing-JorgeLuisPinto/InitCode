<x-app-layout>
    <!-- CodeMirror Assets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/dracula.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/closebrackets.min.js"></script>

    <div class="h-[calc(100vh-104px-2rem)] flex flex-col gap-6" x-data="exerciseHandler()">
        <!-- Header -->
        <header class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('courses.show', $lesson->course->slug) }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition group">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Volver al curso
                </a>
                <div>
                    <p class="text-xs font-bold text-primary uppercase tracking-widest">{{ $lesson->course->title }}</p>
                    <h1 class="text-2xl font-bold">{{ $lesson->title }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-surface-container px-4 py-2 rounded-full border border-outline-variant flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">stars</span>
                    <span class="font-bold">+{{ $lesson->xp_reward }} XP</span>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 gap-6 min-h-0">
            <!-- Instructions Panel -->
            <div class="bg-surface-container border border-outline-variant rounded-2xl p-8 flex flex-col gap-6 overflow-y-auto">
                <!-- Rich Lesson Content -->
                <div class="lesson-rich-content">
                    {!! $lesson->content !!}
                </div>

                @if($exercise)
                <div class="mt-4 p-6 bg-surface-container-low border border-primary/30 rounded-xl space-y-4">
                    <h4 class="font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">task_alt</span>
                        Tu Desafío
                    </h4>
                    <p class="text-sm text-on-surface-variant">{{ $exercise->instructions }}</p>
                    
                    @if($exercise->hints)
                    <div x-data="{ showHints: false }">
                        <button @click="showHints = !showHints" class="text-xs font-bold text-slate-500 hover:text-on-surface flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">lightbulb</span>
                            <span x-text="showHints ? 'Ocultar pistas' : 'Ver pistas'"></span>
                        </button>
                        <div x-show="showHints" x-transition class="mt-2 space-y-1">
                            @foreach($exercise->hints as $hint)
                            <p class="text-xs text-slate-400 p-2 bg-background/50 rounded">• {{ $hint }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Code Editor Panel -->
            <div class="flex flex-col bg-surface-container border border-outline-variant rounded-2xl overflow-hidden min-h-0">
                <div class="bg-surface-container-high px-6 py-3 border-b border-outline-variant flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">editor.{{ $lesson->course->slug === 'html-desde-cero' ? 'html' : 'js' }}</span>
                    </div>
                    <div class="flex gap-1">
                        <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                    </div>
                </div>
                
                <div class="flex-1 flex flex-col p-4 relative min-h-0">
                    @if($exercise->starter_code)
                    <div class="mb-3 p-3 rounded-lg border border-blue-500/30 bg-blue-500/5">
                        <p class="text-xs text-blue-400 mb-2 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">info</span>
                            Estructura de referencia:
                        </p>
                        <pre class="text-sm text-gray-300 font-mono overflow-x-auto">{{ $exercise->starter_code }}</pre>
                    </div>
                    @endif

                    <div class="flex-1 relative min-h-0 border border-outline-variant rounded-xl overflow-hidden">
                        <textarea id="code-editor" style="display:none;"></textarea>
                    </div>

                    <div id="result-panel" class="mt-4"></div>

                    <!-- Show Correct Answer Logic -->
                    <div x-show="attempts > 0 && !revealed" class="mt-4" x-transition>
                        <div x-show="!confirmReveal">
                            <button @click="confirmReveal = true" class="text-sm text-yellow-500 hover:text-yellow-400 underline transition flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                ¿No puedes resolverlo? Mostrar respuesta correcta
                            </button>
                        </div>

                        <div x-show="confirmReveal" class="p-4 rounded-xl border border-yellow-500/30 bg-yellow-500/10 space-y-3">
                            <p class="text-yellow-200 text-sm">
                                ⚠️ Ver la respuesta reducirá el XP que ganas a 5 XP. 
                                ¿Seguro que quieres verla?
                            </p>
                            <div class="flex gap-3">
                                <button @click="revealSolution()" class="px-4 py-2 bg-yellow-500 text-black rounded-lg text-sm font-bold hover:bg-yellow-400 transition">
                                    Sí, mostrar respuesta
                                </button>
                                <button @click="confirmReveal = false" class="px-4 py-2 border border-outline text-on-surface-variant rounded-lg text-sm hover:border-outline-variant transition">
                                    Cancelar, lo intento yo
                                </button>
                            </div>
                        </div>
                    </div>

                    <div x-show="revealed" class="mt-4 p-3 rounded-lg border border-yellow-500/30 bg-yellow-500/5" x-transition>
                        <p class="text-yellow-500 text-xs flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">lightbulb</span>
                            La respuesta fue cargada en el editor. Estúdiala bien. Ganarás 5 XP en este ejercicio.
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-surface-container-high border-t border-outline-variant flex items-center justify-between">
                    <div id="status-message" class="text-sm font-medium"></div>
                    <button id="btn-verificar" type="button" class="inline-flex items-center gap-3 px-8 py-3 bg-primary-container text-on-primary-container font-bold rounded-full shadow-lg hover:shadow-primary/20 transition-all disabled:opacity-50">
                        <span class="flex items-center gap-2">
                            Verificar Código
                            <span class="material-symbols-outlined">play_arrow</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <template x-if="showSuccess">
            <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
                <div class="bg-surface-container border border-secondary/30 p-12 rounded-3xl max-w-md w-full text-center space-y-6 shadow-2xl scale-110">
                    <div class="w-24 h-24 bg-secondary/20 text-secondary rounded-full flex items-center justify-center text-6xl mx-auto animate-bounce">
                        🎉
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-4xl font-black text-on-surface">¡Increíble!</h2>
                        <p class="text-on-surface-variant">Has completado este ejercicio perfectamente.</p>
                    </div>
                    <div class="bg-surface-container-high p-4 rounded-2xl flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-primary">stars</span>
                        <span class="text-2xl font-bold text-primary" x-text="'+' + earnedXp + ' XP'"></span>
                    </div>
                    @if($nextLesson)
                        <a href="{{ route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) }}" class="w-full inline-flex items-center justify-center gap-3 py-4 bg-secondary text-on-secondary font-bold rounded-xl hover:scale-105 transition-transform">
                            Siguiente lección
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('courses.index') }}" class="w-full inline-flex items-center justify-center gap-3 py-4 bg-secondary text-on-secondary font-bold rounded-xl hover:scale-105 transition-transform">
                            ✅ Curso completado
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    @endif
                </div>
            </div>
        </template>
    </div>

    <style>
        .CodeMirror {
            min-height: 200px;
            height: auto;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            padding: 1rem;
            background: #282a36 !important;
            border-radius: 8px;
        }
        .CodeMirror-scroll {
            min-height: 200px;
        }
        .CodeMirror-gutters {
            background: #282a36 !important;
            border-right: 1px solid #44475a;
        }
    </style>

    <script>
        function exerciseHandler() {
            return {
                loading: false,
                showSuccess: false,
                attempts: 0,
                revealed: false,
                confirmReveal: false,
                earnedXp: 0,
                
                revealSolution() {
                    if (window.editor) {
                        window.editor.setValue(`{!! addslashes($exercise->solution_code) !!}`);
                        this.revealed = true;
                        this.confirmReveal = false;
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CodeMirror
            window.editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
                lineNumbers: true,
                theme: 'dracula',
                mode: '{{ $lesson->course->slug === "html-desde-cero" ? "text/html" : "text/x-php" }}',
                tabSize: 2,
                indentUnit: 2,
                lineWrapping: true,
                autoCloseBrackets: true,
                autofocus: true
            });
            
            window.editor.setValue('');
            setTimeout(() => window.editor.refresh(), 100);

            // Submit Handler
            document.getElementById('btn-verificar').addEventListener('click', function() {
                const currentCode = (window.editor && typeof window.editor.getValue === 'function')
                    ? window.editor.getValue().trim()
                    : '';

                const resultPanel = document.getElementById('result-panel');

                // Don't submit if empty
                if (!currentCode || currentCode.length === 0) {
                    resultPanel.innerHTML =
                        '<div class="p-4 bg-yellow-500/20 border border-yellow-500/30 rounded-lg mt-3">' +
                        '<p class="text-yellow-400 font-medium">⚠️ Escribe tu respuesta antes de verificar. ' +
                        '¡Mira la estructura de referencia de arriba! 💡</p>' +
                        '</div>';
                    return; // stop here, don't call the API
                }

                const alpineEl = document.querySelector('[x-data]');
                const alpineData = (() => {
                    try {
                        if (alpineEl && alpineEl.__x) return alpineEl.__x.$data;
                        if (alpineEl && alpineEl._x_dataStack) return alpineEl._x_dataStack[0];
                    } catch(e) {}
                    return {};
                })();

                if (alpineData.loading) return;

                alpineData.loading = true;
                this.disabled = true;
                const statusEl = document.getElementById('status-message');
                if (statusEl) statusEl.innerText = 'Verificando...';
                resultPanel.innerHTML = '';
                
                fetch("{{ route('exercises.submit', $exercise->id ?? 0) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: currentCode,
                        revealed: alpineData.revealed ?? false
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.correct) {
                        if (statusEl) {
                            statusEl.className = 'text-sm font-medium text-secondary flex items-center gap-2';
                            statusEl.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> Correcto';
                        }
                        
                        resultPanel.innerHTML =
                            '<div class="p-4 bg-green-500/20 border border-green-500/30 rounded-lg mt-3">' +
                            '<p class="text-green-400 font-bold text-lg">✅ ¡Correcto! +' + data.xp_earned + ' XP 🎉</p>' +
                            '<p class="text-green-300 text-sm mt-1">¡Excelente trabajo! Pasando a la siguiente lección...</p>' +
                            '</div>';

                        alpineData.earnedXp = data.xp_earned;
                        alpineData.showSuccess = true;
                        
                        setTimeout(() => {
                            @if(isset($nextLesson))
                                window.location.href = "{{ route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) }}";
                            @else
                                window.location.href = "{{ route('courses.index') }}";
                            @endif
                        }, 2000);
                    } else {
                        alpineData.attempts = (alpineData.attempts || 0) + 1;
                        if (statusEl) {
                            statusEl.className = 'text-sm font-medium text-error flex items-center gap-2';
                            statusEl.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Error';
                        }
                        
                        resultPanel.innerHTML =
                            '<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg mt-3">' +
                            '<p class="text-red-400 font-medium">❌ ' + (data.message || '¡Casi! Inténtalo de nuevo 💪') + '</p>' +
                            '</div>';
                    }
                })
                .catch(err => {
                    console.error('Submit fetch error', err);
                    resultPanel.innerHTML =
                        '<div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg mt-3">' +
                        '<p class="text-red-400 font-medium">❌ Error de conexión. Recarga la página e intenta de nuevo.</p>' +
                        '</div>';
                })
                .finally(() => {
                    alpineData.loading = false;
                    this.disabled = false;
                });
            });
        });
    </script>
    {{-- Floating CodeBot button --}}
    <div x-data="{
            open: false,
            messages: [
                { 
                    role: 'bot', 
                    text: '¡Hola! Soy CodeBot 🤖 Estoy aquí para ayudarte con esta lección. Puedo explicarte conceptos y darte pistas, pero no te daré la respuesta directa. ¡Así aprendes más! 💪 ¿En qué te puedo ayudar?'
                }
            ],
            input: '',
            loading: false,
            async send() {
                if (!this.input.trim() || this.loading) return;
                const msg = this.input.trim();
                this.messages.push({ role: 'user', text: msg });
                this.input = '';
                this.loading = true;
                
                try {
                    const res = await fetch('{{ route('lesson.chat') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: msg,
                            lesson_title: '{{ addslashes($lesson->title) }}',
                            lesson_content: '{{ addslashes(strip_tags($lesson->content ?? '')) }}',
                            exercise_instructions: '{{ isset($exercise) ? addslashes($exercise->instructions ?? '') : '' }}'
                        })
                    });
                    const data = await res.json();
                    this.messages.push({ role: 'bot', text: data.message });
                } catch(e) {
                    this.messages.push({ 
                        role: 'bot', 
                        text: 'Hubo un error de conexión. Intenta de nuevo. 😅' 
                    });
                }
                
                this.loading = false;
                this.$nextTick(() => {
                    const chat = document.getElementById('lesson-chat-messages');
                    if (chat) chat.scrollTop = chat.scrollHeight;
                });
            }
         }"
         class="fixed bottom-6 left-6 z-40">

        {{-- Backdrop/Overlay --}}
        <div x-show="open" 
             @click="open = false"
             class="fixed inset-0 z-30"
             style="display:none;">
        </div>

        {{-- Chat panel --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="mb-4 bg-gray-900 border border-gray-700 rounded-2xl 
                    shadow-2xl flex flex-col overflow-hidden z-40"
             style="width: 320px; height: 400px; display:none;">
            
            {{-- Header --}}
            <div class="flex items-center justify-between px-4 py-3 
                        bg-blue-600 text-white">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🤖</span>
                    <div>
                        <p class="font-semibold text-sm">CodeBot</p>
                        <p class="text-xs text-blue-200">
                            Te ayuda sin darte las respuestas
                        </p>
                    </div>
                </div>
                <button @click.stop="open = false" 
                        type="button"
                        class="text-blue-200 hover:text-white transition text-lg leading-none">
                    ✕
                </button>
            </div>
            
            {{-- Messages --}}
            <div id="lesson-chat-messages" 
                 class="flex-1 overflow-y-auto p-3 space-y-3">
                <template x-for="(msg, i) in messages" :key="i">
                    <div :class="msg.role === 'user' 
                        ? 'flex justify-end' 
                        : 'flex justify-start'">
                        <div :class="msg.role === 'user'
                            ? 'bg-blue-600 text-white rounded-2xl rounded-tr-sm px-3 py-2 max-w-[85%] text-sm'
                            : 'bg-gray-800 text-gray-200 rounded-2xl rounded-tl-sm px-3 py-2 max-w-[85%] text-sm'"
                             x-text="msg.text">
                        </div>
                    </div>
                </template>
                
                {{-- Loading dots --}}
                <div x-show="loading" class="flex justify-start">
                    <div class="bg-gray-800 rounded-2xl rounded-tl-sm 
                                px-4 py-3">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-gray-500 rounded-full 
                                        animate-bounce" 
                                 style="animation-delay: 0ms"></div>
                            <div class="w-2 h-2 bg-gray-500 rounded-full 
                                        animate-bounce" 
                                 style="animation-delay: 150ms"></div>
                            <div class="w-2 h-2 bg-gray-500 rounded-full 
                                        animate-bounce" 
                                 style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Suggested questions --}}
            <div class="px-3 pb-2 flex gap-2 overflow-x-auto">
                <button @click="input = '¿Me das una pista?'; send()"
                        class="text-xs bg-gray-800 text-blue-400 border 
                               border-blue-500/30 rounded-full px-3 py-1 
                               whitespace-nowrap hover:bg-gray-700 transition">
                    💡 Dame una pista
                </button>
                <button @click="input = 'No entiendo el concepto, explícamelo de otra forma'; send()"
                        class="text-xs bg-gray-800 text-blue-400 border 
                               border-blue-500/30 rounded-full px-3 py-1 
                               whitespace-nowrap hover:bg-gray-700 transition">
                    🤔 No entiendo
                </button>
            </div>
            
            {{-- Input --}}
            <div class="px-3 pb-3 flex gap-2">
                <input x-model="input"
                       @keydown.enter="send()"
                       type="text"
                       placeholder="Escribe tu pregunta..."
                       class="flex-1 bg-gray-800 border border-gray-600 
                              rounded-xl px-3 py-2 text-sm text-white 
                              placeholder-gray-500 focus:outline-none 
                              focus:border-blue-500 transition">
                <button @click="send()"
                        :disabled="loading"
                        class="bg-blue-600 hover:bg-blue-500 disabled:opacity-50 
                               text-white rounded-xl px-3 py-2 transition">
                    ➤
                </button>
            </div>
        </div>

        {{-- Floating button --}}
        <button @click.stop="open = !open"
                type="button"
                class="w-14 h-14 bg-blue-600 hover:bg-blue-500 text-white 
                       rounded-full shadow-lg flex items-center justify-center 
                       text-2xl transition hover:scale-110 active:scale-95">
            <span x-show="!open">🤖</span>
            <span x-show="open" style="display:none">✕</span>
        </button>
    </div>

</x-app-layout>
