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

        if (!$key) {
            \Log::error('Gemini: GEMINI_API_KEY not set');
            return 'Error: falta la API key. 😅';
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $key;

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 600,
                    ],
                    'safetySettings' => [
                        [
                            'category' => 'HARM_CATEGORY_HARASSMENT',
                            'threshold' => 'BLOCK_NONE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_HATE_SPEECH', 
                            'threshold' => 'BLOCK_NONE'
                        ]
                    ]
                ]);

            \Log::info('Gemini HTTP status: ' . $response->status());
            \Log::info('Gemini response: ' . substr($response->body(), 0, 300));

            if ($response->successful()) {
                $json = $response->json();
                $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) return trim($text);
            }

            \Log::error('Gemini failed: ' . $response->body());

        } catch (\Exception $e) {
            \Log::error('Gemini exception: ' . $e->getMessage());
        }

        return 'No pude responder en este momento. Intenta de nuevo. 😅';
    }
}
