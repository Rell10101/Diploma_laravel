<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function getResponse(Request $request)
    {
    set_time_limit(120);

    try {
        $prompt = $request->input('prompt');
        if (!$prompt) {
            return response()->json(['error' => 'Prompt is required'], 400);
        }

        $response = $this->openAIService->getCompletion($prompt);
        
        return response()->json(['response' => $response]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
    }
}
}
