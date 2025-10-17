<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GuestController extends Controller
{
    /**
     * Display the home page with a list of products.
     */
    public function home(Request $request)
    {
        return view('guest.home');
    }

    public function comingsoon()
    {
        return view('guest.coming-soon');
    }

    public function chat()
    {
        return view('guest.chat');
    }

    public function chatbot(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['answer' => 'Pertanyaan tidak boleh kosong.'], 400);
        }

        try {
            $sessionId = session('chatbot_session_id');
            $userId = session('chatbot_user_id');
            $createdAt = session('chatbot_session_created_at');

            $now = now();
            $expired = false;

            if ($createdAt) {
                $expired = $now->diffInMinutes($createdAt) >= 60;
            }

            if (!$sessionId || !$userId || $expired) {
                $sessionId = (string) Str::uuid();
                $userId = (string) Str::uuid();

                session([
                    'chatbot_session_id' => $sessionId,
                    'chatbot_user_id' => $userId,
                    'chatbot_session_created_at' => $now,
                ]);
            }

            $apiUrl = 'https://n8n-gczfssttvtzs.nasgor.sumopod.my.id/webhook/cantik-ai-chat';

            $payload = [
                'sessionId' => $sessionId,
                'user' => $userId,
                'chatInput' => $query,
                'source' => 'cantik.ai-webchat',
                'timestamp' => $now->toIso8601String(),
                'type' => 'text',
                'useTestUrl' => false,
            ];
            $response = Http::timeout(15)->post($apiUrl, $payload);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'answer' => 'Gagal mendapatkan respon dari webhook n8n.',
                'status' => $response->status(),
                'error' => $response->body(),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'answer' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function resetChatbotSession(Request $request)
    {
        try {
            session()->forget([
                'chatbot_session_id',
                'chatbot_user_id',
                'chatbot_session_created_at'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session chatbot berhasil direset. Percakapan baru siap dimulai! 🌸'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mereset session chatbot 😢'
            ], 500);
        }
    }



    // public function chatbot(Request $request)
    // {
    //     $query = $request->input('query');

    //     if (!$query) {
    //         return response()->json(['answer' => 'Pertanyaan tidak boleh kosong.'], 400);
    //     }

    //     try {
    //         $apiUrl = env('API_URL_CHATBOT') . '/chat?api_key='. env('API_KEY_CHATBOT');

    //         $response = Http::timeout(15)->post($apiUrl, [
    //             'query' => $query,
    //             'top_k' => 5,
    //         ]);

    //         if ($response->successful()) {
    //             return response()->json($response->json());
    //         }

    //         return response()->json([
    //             'answer' => 'Gagal mendapatkan respon dari server eksternal.'
    //         ], $response->status());

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'answer' => 'Terjadi kesalahan: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    
}
