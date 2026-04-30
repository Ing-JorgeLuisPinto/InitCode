                <div class="p-6 bg-surface-container-high border-t border-outline-variant flex items-center justify-between">
                    <div id="status-message" class="text-sm font-medium"></div>
                    <button 
                        id="btn-verificar" 
                        type="button"
                        data-route="{{ route('exercises.submit', $exercise->id ?? 0) }}"
                        data-next="{{ isset($nextLesson) ? route('lessons.show', [$nextLesson->course->slug, $nextLesson->slug]) : route('courses.index') }}"
                        class="inline-flex items-center gap-3 px-8 py-3 bg-primary-container text-on-primary-container font-bold rounded-full shadow-lg hover:shadow-primary/20 transition-all disabled:opacity-50">
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

    {{-- CodeMirror CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/dracula.min.css">

    {{-- CodeMirror JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/closebrackets.min.js"></script>

    <style>
    .CodeMirror {
        min-height: 220px;
        height: auto;
        font-size: 14px;
        border-radius: 8px;
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
    }
    .CodeMirror-scroll {
        min-height: 220px;
    }

    @keyframes bounce-in {
        0% { transform: translateX(-100%) scale(0.7); opacity: 0; }
        70% { transform: translateX(10%) scale(1.05); }
        100% { transform: translateX(0) scale(1); opacity: 1; }
    }
    @keyframes fade-out {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(0.9); opacity: 0; }
    }
    .animate-bounce-in { animation: bounce-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    .animate-fade-out { animation: fade-out 0.4s ease forwards; }
    </style>

    <script>
    (function() {
        // Wait for full DOM load
        document.addEventListener('DOMContentLoaded', function() {

            // Find the textarea
            var textarea = document.getElementById('code-editor');
            if (!textarea) {
                console.error('CodePath: #code-editor textarea not found');
                return;
            }

            // Initialize CodeMirror ONCE
            if (window.editor) {
                console.warn('CodePath: editor already initialized, skipping');
                return;
            }

            window.editor = CodeMirror.fromTextArea(textarea, {
                mode: 'text/x-php',
                theme: 'dracula',
                lineNumbers: true,
                autoCloseBrackets: true,
                indentUnit: 2,
                tabSize: 2,
                lineWrapping: true,
                autofocus: true,
                readOnly: false,
                extraKeys: {
                    'Tab': function(cm) {
                        cm.replaceSelection('  ');
                    }
                }
            });

            // Start empty
            window.editor.setValue('');

            // Fix sizing after render
            setTimeout(function() {
                window.editor.refresh();
                window.editor.focus();
            }, 200);

            // Submit button handler
            var btn = document.getElementById('btn-verificar');
            if (!btn) {
                console.error('CodePath: #btn-verificar button not found');
                return;
            }

            btn.addEventListener('click', function(e) {
                e.preventDefault();

                var code = window.editor.getValue();

                // Validate not empty
                if (!code || code.trim() === '') {
                    var panel = document.getElementById('result-panel');
                    if (panel) {
                        panel.innerHTML =
                            '<div class="p-4 bg-yellow-500/20 border border-yellow-500/30 ' +
                            'rounded-lg mt-3">' +
                            '<p class="text-yellow-400 font-medium">' +
                            '⚠️ Escribe tu respuesta antes de verificar. ' +
                            'Mira la estructura de referencia de arriba. 💡</p>' +
                            '</div>';
                    }
                    return;
                }

                // Get revealed state from Alpine if available
                var revealed = false;
                try {
                    var alpineEl = document.querySelector('[x-data]');
                    if (alpineEl) {
                        if (alpineEl.__x) revealed = alpineEl.__x.$data.revealed || false;
                        else if (alpineEl._x_dataStack) revealed = alpineEl._x_dataStack[0].revealed || false;
                    }
                } catch(err) { revealed = false; }

                // Disable button while loading
                btn.disabled = true;
                var oldHtml = btn.innerHTML;
                btn.textContent = 'Verificando...';

                fetch(btn.dataset.route, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        code: code,
                        revealed: revealed
                    })
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    btn.disabled = false;
                    btn.innerHTML = oldHtml;

                    var panel = document.getElementById('result-panel');

                    if (data.correct) {
                        if (panel) {
                            panel.innerHTML =
                                '<div class="p-4 bg-green-500/20 border border-green-500/30 ' +
                                'rounded-lg mt-3">' +
                                '<p class="text-green-400 font-bold text-lg">' +
                                '✅ ¡Correcto! +' + data.xp_earned + ' XP 🎉</p>' +
                                '<p class="text-green-300 text-sm mt-1">' +
                                'Pasando a la siguiente lección...</p>' +
                                '</div>';
                        }

                        // Achievement toasts
                        if (data.new_achievements && data.new_achievements.length > 0) {
                            data.new_achievements.forEach(function(achievement) {
                                showAchievementToast(achievement);
                            });
                        }

                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = btn.dataset.next;
                        }, 2000);

                    } else {
                        if (panel) {
                            panel.innerHTML =
                                '<div class="p-4 bg-red-500/20 border border-red-500/30 ' +
                                'rounded-lg mt-3">' +
                                '<p class="text-red-400 font-medium">❌ ' +
                                (data.message || '¡Casi! Inténtalo de nuevo 💪') +
                                '</p></div>';
                        }

                        // Increment Alpine attempts counter
                        try {
                            var el = document.querySelector('[x-data]');
                            if (el && el.__x) el.__x.$data.attempts++;
                            else if (el && el._x_dataStack) el._x_dataStack[0].attempts++;
                        } catch(err) {}
                    }
                })
                .catch(function(err) {
                    btn.disabled = false;
                    btn.innerHTML = oldHtml;
                    console.error('Submit error:', err);
                    var panel = document.getElementById('result-panel');
                    if (panel) {
                        panel.innerHTML =
                            '<div class="p-4 bg-red-500/20 border border-red-500/30 ' +
                            'rounded-lg mt-3">' +
                            '<p class="text-red-400">❌ Error de conexión. ' +
                            'Recarga la página e intenta de nuevo.</p>' +
                            '</div>';
                    }
                });
            });

        }); // end DOMContentLoaded
    })();

    function showAchievementToast(achievement) {
        const container = document.getElementById('achievement-toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = 'flex items-center gap-3 bg-[#1e1e2e] border-2 border-[#6366f1] p-4 rounded-xl shadow-2xl animate-bounce-in min-w-[300px] pointer-events-auto';
        toast.innerHTML = `
            <div class="flex-shrink-0 w-12 h-12 bg-[#6366f1]/20 rounded-full flex items-center justify-center text-2xl border border-[#6366f1]/30">
                ${achievement.icon || '🏆'}
            </div>
            <div>
                <p class="text-xs font-bold text-[#6366f1] tracking-widest uppercase mb-1">¡Logro Desbloqueado!</p>
                <h4 class="text-white font-bold">${achievement.title}</h4>
                <p class="text-white/60 text-xs">${achievement.description}</p>
            </div>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            toast.classList.replace('animate-bounce-in', 'animate-fade-out');
            setTimeout(() => toast.remove(), 500);
        }, 5000);
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'achievement-toast-container';
        container.className = 'fixed bottom-8 left-8 flex flex-col gap-3 z-[100] pointer-events-none';
        document.body.appendChild(container);
        return container;
    }
    </script>
</x-app-layout>
