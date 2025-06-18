<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Services\OpenAIService;



class ChatController extends Controller
{
    public function chat()
    {
        return view('chat');
    }

    public function chat_accept(Request $request)
    {
        // это нужно передать ollama
        //$r->input('message');


        $response = Http::post('http://localhost:11434/api/generate', [
            'model' => 'deepseek-r1:1.5b',  // Название модели
            'prompt' => $request->input('message'),  // Ваш запрос
            'language' => 'ru',
            'stream' => false,     // Отключить потоковый ответ
            'options' => [
                'temperature' => 0.2,
                'num_predict' => 1000
            ]
        ]);

        $message = $response->json()['response']; // Получаем сообщение от бота
        $message = str_replace('<think>', '', $message); // Убираем <think>
        $message = str_replace('</think>', '', $message); // Убираем </think>
            
        if ($response->successful()) {
            //return $response->json()['response'];
            //printf($response->json()['response']);
            return view('chat', ['data' => $message]);
        }

        //return response()->json(['error' => 'Ошибка запроса'], 500);
        //printf(response()->json(['error' => 'Ошибка запроса'], 500));
        return view('chat', compact(['data' => response()->json(['error' => 'Ошибка запроса'], 500)]) );
    }
}
