<x-app-layout>
    <!-- CodeMirror Assets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/material-ocean.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>

    <div class="h-[calc(100vh-104px-2rem)] flex flex-col gap-6" x-data="exerciseHandler()">
        <!-- Header -->
        <header class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('courses.show', $lesson->course->slug) }}" class="p-2 rounded-full bg-surface-container border border-outline-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
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
                
                <div class="flex-1 relative min-h-0">
                    <textarea id="code-editor">{{ $exercise->template_code ?? '// Escribe tu código aquí' }}</textarea>
                </div>

                <div class="p-6 bg-surface-container-high border-t border-outline-variant flex items-center justify-between">
                    <div id="status-message" class="text-sm font-medium"></div>
                    <button @click="submitCode()" :disabled="loading" class="inline-flex items-center gap-3 px-8 py-3 bg-primary-container text-on-primary-container font-bold rounded-full shadow-lg hover:shadow-primary/20 transition-all disabled:opacity-50">
                        <span x-show="!loading" class="flex items-center gap-2">
                            Verificar Código
                            <span class="material-symbols-outlined">play_arrow</span>
                        </span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verificando...
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
                        <span class="text-2xl font-bold text-primary">+{{ $exercise->xp_reward ?? 0 }} XP</span>
                    </div>
                    <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center gap-3 py-4 bg-secondary text-on-secondary font-bold rounded-xl hover:scale-105 transition-transform">
                        Continuar
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </template>
    </div>

    <style>
        .CodeMirror {
            height: 100%;
            font-family: 'JetBrains Mono', monospace;
            font-size: 16px;
            padding: 1rem;
            background: #0A0F1E !important;
        }
        .CodeMirror-gutters {
            background: #0A0F1E !important;
            border-right: 1px solid #2f3445;
        }
    </style>

    <script>
        function exerciseHandler() {
            return {
                editor: null,
                loading: false,
                showSuccess: false,
                
                init() {
                    this.editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
                        lineNumbers: true,
                        theme: 'material-ocean',
                        mode: '{{ $lesson->course->slug === "html-desde-cero" ? "xml" : "javascript" }}',
                        tabSize: 4,
                        indentUnit: 4,
                        lineWrapping: true,
                        autoCloseBrackets: true
                    });
                },

                async submitCode() {
                    this.loading = true;
                    const code = this.editor.getValue();
                    const statusEl = document.getElementById('status-message');
                    
                    try {
                        const response = await fetch('{{ route("exercises.submit", $exercise->id ?? 0) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ code: code })
                        });
                        
                        const data = await response.json();
                        
                        if (data.correct) {
                            statusEl.className = 'text-sm font-medium text-secondary flex items-center gap-2';
                            statusEl.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> ' + data.message;
                            this.showSuccess = true;
                        } else {
                            statusEl.className = 'text-sm font-medium text-error flex items-center gap-2';
                            statusEl.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> ' + data.message;
                        }
                    } catch (error) {
                        statusEl.className = 'text-sm font-medium text-error';
                        statusEl.innerText = 'Error al verificar. Revisa tu conexión.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
