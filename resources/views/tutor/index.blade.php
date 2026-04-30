<x-app-layout>
    <div class="h-[calc(100vh-104px-2rem)] flex flex-col max-w-5xl mx-auto" x-data="chatHandler()">
        <!-- Header -->
        <header class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-3xl shadow-lg">
                    🤖
                </div>
                <div>
                    <h1 class="text-2xl font-bold">CodeBot</h1>
                    <p class="text-sm text-slate-400">Tu tutor de IA amigable</p>
                </div>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-surface-container border border-indigo-500/30 rounded-full">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">En línea</span>
            </div>
        </header>

        <!-- Chat Window -->
        <div class="flex-1 bg-surface-container border border-outline-variant rounded-2xl flex flex-col min-h-0">
            <!-- Messages Area -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-8 space-y-6 scroll-smooth scrollbar-hide">
                <div class="flex gap-4 max-w-2xl">
                    <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex-shrink-0 flex items-center justify-center text-xl">🤖</div>
                    <div class="bg-surface-container-high border border-outline-variant p-4 rounded-2xl rounded-tl-none">
                        <p class="text-on-surface">¡Hola! Soy CodeBot. Estoy aquí para ayudarte a entender la programación de forma fácil y divertida. ¿Tienes alguna duda o quieres que te explique algo?</p>
                    </div>
                </div>

                @foreach($messages as $msg)
                <div class="flex gap-4 {{ $msg->role === 'user' ? 'flex-row-reverse' : '' }} max-w-2xl {{ $msg->role === 'user' ? 'ml-auto' : '' }}">
                    <div class="w-10 h-10 rounded-full {{ $msg->role === 'user' ? 'bg-primary/20 text-primary' : 'bg-indigo-500/20 text-indigo-400' }} flex-shrink-0 flex items-center justify-center text-xl">
                        {{ $msg->role === 'user' ? '👤' : '🤖' }}
                    </div>
                    <div class="{{ $msg->role === 'user' ? 'bg-primary-container text-on-primary-container rounded-tr-none' : 'bg-surface-container-high border border-outline-variant text-on-surface rounded-tl-none' }} p-4 rounded-2xl">
                        <p class="whitespace-pre-wrap">{{ $msg->content }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Input Area -->
            <div class="p-6 bg-surface-container-high border-t border-outline-variant">
                <form @submit.prevent="sendMessage()" class="flex gap-4">
                    <div class="flex-1 relative">
                        <input x-model="newMessage" type="text" placeholder="Escribe tu pregunta aquí..." class="w-full bg-surface-container-low border border-outline-variant rounded-xl py-4 pl-6 pr-4 text-on-surface focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <button type="submit" :disabled="!newMessage.trim() || loading" class="w-14 h-14 bg-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 hover:scale-105 active:scale-95 transition-all disabled:opacity-50">
                        <span x-show="!loading" class="material-symbols-outlined">send</span>
                        <svg x-show="loading" class="animate-spin h-6 w-6" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function chatHandler() {
            return {
                newMessage: '',
                loading: false,
                
                init() {
                    this.scrollToBottom();
                },

                scrollToBottom() {
                    setTimeout(() => {
                        const el = document.getElementById('chat-messages');
                        el.scrollTop = el.scrollHeight;
                    }, 100);
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || this.loading) return;
                    
                    const userMsg = this.newMessage;
                    this.appendMessage('user', userMsg);
                    this.newMessage = '';
                    this.loading = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch('{{ route("tutor.message") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ message: userMsg })
                        });
                        
                        const data = await response.json();
                        this.appendMessage('assistant', data.message);
                    } catch (error) {
                        this.appendMessage('assistant', 'Lo siento, tuve un problema. ¿Puedes intentar de nuevo?');
                    } finally {
                        this.loading = false;
                        this.scrollToBottom();
                    }
                },

                appendMessage(role, content) {
                    const messagesEl = document.getElementById('chat-messages');
                    const div = document.createElement('div');
                    div.className = `flex gap-4 ${role === 'user' ? 'flex-row-reverse ml-auto' : ''} max-w-2xl`;
                    div.innerHTML = `
                        <div class="w-10 h-10 rounded-full ${role === 'user' ? 'bg-primary/20 text-primary' : 'bg-indigo-500/20 text-indigo-400'} flex-shrink-0 flex items-center justify-center text-xl">
                            ${role === 'user' ? '👤' : '🤖'}
                        </div>
                        <div class="${role === 'user' ? 'bg-primary-container text-on-primary-container rounded-tr-none' : 'bg-surface-container-high border border-outline-variant text-on-surface rounded-tl-none'} p-4 rounded-2xl">
                            <p class="whitespace-pre-wrap">${content}</p>
                        </div>
                    `;
                    messagesEl.appendChild(div);
                }
            }
        }
    </script>
</x-app-layout>
