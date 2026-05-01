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

        ChatMessage::create([
            'user_id' => auth()->id(),
            'role' => 'user',
            'content' => $request->message
        ]);

        $history = ChatMessage::where('user_id', auth()->id())
            ->latest()->take(18)->get()->reverse()->values();

        $contents = [];

        // System context as first exchange
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => 'Eres CodeBot, tutor amigable de CodePath. Enseñas programación a principiantes. Explica con analogías simples, sin jerga técnica. No des soluciones directas, guía al usuario.']]
        ];
        $contents[] = [
            'role' => 'model',
            'parts' => [['text' => '¡Hola! Entendido, soy CodeBot. Estoy listo para ayudar a los estudiantes de CodePath a aprender de forma divertida y clara. ¿En qué puedo ayudarte hoy?']]
        ];

        foreach ($history as $msg) {
            $contents[] = [
                'role' => $msg->role === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $msg->content]]
            ];
        }

        $reply = $this->callGemini($contents);

        ChatMessage::create([
            'user_id' => auth()->id(),
            'role' => 'assistant',
            'content' => $reply
        ]);

        return response()->json(['message' => $reply]);
    }

    public function lessonChat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $prompt = "Contexto: Estás en la lección '{$request->lesson_title}'.
Contenido: {$request->lesson_content}
Ejercicio: {$request->exercise_instructions}

Usuario pregunta: {$request->message}

REGLAS:
1. Sé breve y motivador.
2. NUNCA des el código de la solución.
3. Da pistas conceptuales.
4. Si preguntan algo fuera de programación, vuelve al tema.";

        $reply = $this->callGemini([
            [
                'role' => 'user',
                'parts' => [['text' => $prompt]]
            ]
        ]);

        return response()->json(['message' => $reply]);
    }

    private function callGemini(array $contents): string
    {
        $key = env('GEMINI_API_KEY');
        if (!$key) return 'Error: falta la API key. 😅';

        $models = [
            'gemini-2.0-flash-lite',
            'gemini-2.0-flash-001',
            'gemini-2.5-flash',
        ];

        foreach ($models as $model) {
            try {
                $response = Http::timeout(30)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post(
                        'https://generativelanguage.googleapis.com/v1beta/models/'
                        . $model . ':generateContent?key=' . $key,
                        [
                            'contents' => $contents,
                            'generationConfig' => [
                                'temperature' => 0.7,
                                'maxOutputTokens' => 500,
                            ]
                        ]
                    );

                \Log::info('Gemini model: ' . $model . ' | status: ' . $response->status());

                if ($response->status() === 429) {
                    \Log::warning('Quota exceeded for: ' . $model . ', trying next...');
                    continue;
                }

                if ($response->status() === 404) {
                    \Log::warning('Model not found: ' . $model . ', trying next...');
                    continue;
                }

                if ($response->successful()) {
                    $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if ($text) return trim($text);
                }

                \Log::error('Gemini error ' . $response->status() . ': ' . $response->body());

            } catch (\Exception $e) {
                \Log::error('Gemini exception (' . $model . '): ' . $e->getMessage());
                continue;
            }
        }

        return 'No pude conectarme al servidor de IA. Intenta de nuevo. 😅';
    }
}
