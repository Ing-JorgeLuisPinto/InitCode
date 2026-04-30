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
            document.getElementById('btn-verificar').addEventListener('click', async function() {
                const btn = this;
                const statusEl = document.getElementById('status-message');
                const resultPanel = document.getElementById('result-panel');
                const alpineEl = document.querySelector('[x-data]');
                const alpineData = alpineEl.__x ? alpineEl.__x.$data : alpineEl._x_dataStack[0];

                if (alpineData.loading) return;

                alpineData.loading = true;
                btn.disabled = true;
                statusEl.innerText = 'Verificando...';
                resultPanel.innerHTML = '';
                
                const currentCode = window.editor.getValue();
                
                try {
                    const response = await fetch('{{ route("exercises.submit", $exercise->id ?? 0) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            code: currentCode,
                            revealed: alpineData.revealed
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.correct) {
                        statusEl.className = 'text-sm font-medium text-secondary flex items-center gap-2';
                        statusEl.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> Correcto';
                        
                        resultPanel.innerHTML = `
                            <div class="p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
                                <p class="text-green-400 font-medium">✅ ¡Correcto! +${data.xp_earned} XP 🎉</p>
                            </div>
                        `;

                        alpineData.earnedXp = data.xp_earned;
                        alpineData.showSuccess = true;
                        
                        setTimeout(() => {
                            window.location.href = "{{ $nextLesson ? route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) : route('courses.index') }}";
                        }, 2000);
                    } else {
                        alpineData.attempts++;
                        statusEl.className = 'text-sm font-medium text-error flex items-center gap-2';
                        statusEl.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Error';
                        
                        resultPanel.innerHTML = `
                            <div class="p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                                <p class="text-red-400 font-medium">❌ ${data.message}</p>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    statusEl.className = 'text-sm font-medium text-error';
                    statusEl.innerText = 'Error al verificar. Revisa tu conexión.';
                } finally {
                    alpineData.loading = false;
                    btn.disabled = false;
                }
            });
        });
    </script>
</x-app-layout>
