<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TutorController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->latest('id')
            ->take(20)
            ->get()
            ->reverse();

        return view('tutor.index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $user = Auth::user();
        ChatMessage::create([
            'user_id' => $user->id,
            'role' => 'user',
            'content' => $request->message
        ]);

        $history = ChatMessage::where('user_id', $user->id)
            ->latest('id')
            ->take(20)
            ->get()
            ->reverse();

        $messages = [[
            'role' => 'system',
            'content' => 'Eres CodeBot, el tutor amigable de CodePath. Enseñas programación a principiantes absolutos. Explica siempre con analogías simples de la vida cotidiana, sin jerga técnica. Eres paciente, positivo y muy alentador. Usa emojis ocasionalmente. Responde siempre en español. Cuando alguien no entienda algo, da un ejemplo concreto y sencillo.'
        ]];

        foreach ($history as $msg) {
            $messages[] = ['role' => $msg->role, 'content' => $msg->content];
        }

        $apiKey = env('OPENAI_API_KEY');
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'max_tokens' => 500,
            'temperature' => 0.7
        ]);

        if ($response->successful()) {
            $aiMessage = $response->json()['choices'][0]['message']['content'];
            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'assistant',
                'content' => $aiMessage
            ]);
            return response()->json(['message' => $aiMessage]);
        }

        return response()->json(['message' => 'Lo siento, tuve un problema conectando con mi cerebro de IA. ¿Puedes intentar de nuevo?'], 500);
    }
}
