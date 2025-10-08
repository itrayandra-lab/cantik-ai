<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
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
            $apiUrl = env('API_URL_CHATBOT') . '/chat?api_key='. env('API_KEY_CHATBOT');

            $response = Http::timeout(15)->post($apiUrl, [
                'query' => $query,
                'top_k' => 5,
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'answer' => 'Gagal mendapatkan respon dari server eksternal.'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'answer' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    
}
