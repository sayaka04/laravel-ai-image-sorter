<?php

namespace App\Http\Controllers;

use App\Jobs\RunLLMTextJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class LLMController extends Controller
{
    public function handleTextOriginal(Request $request): JsonResponse
    {

        $validatedData = $request->validate([
            'model' => 'required|string',
            'prompt' => 'required|string',
        ]);

        ini_set('max_execution_time', 1000); // 5 minutes



        $response = Http::timeout(1000)->post('http://127.0.0.1:11434/api/generate', [
            'model'  => $validatedData['model'],
            'prompt' => $validatedData['prompt'],
            'stream' => false,
        ]);



        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function handleText(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'model' => 'required|string',
            'prompt' => 'required|string',
        ]);

        $cacheKey = 'llm:' . Str::uuid();

        RunLLMTextJob::dispatch(
            $validated['model'],
            $validated['prompt'],
            $cacheKey
        );

        return response()->json([
            'status' => 'queued',
            'job_id' => $cacheKey,
        ]);
    }




    public function handleVision(Request $request): JsonResponse
    {

        $validatedData = $request->validate([
            'model' => 'required|string',
            'prompt' => 'required|string',
            'imageBase64'  => 'required|string',
        ]);

        // return response()->json($validatedData);



        ini_set('max_execution_time', 1000); // 16 minutes

        $prompt = $validatedData['prompt'];
        $base64Image = $validatedData['imageBase64'];

        $response = Http::timeout(1000)
            ->post('http://localhost:11434/api/chat', [
                'model'  => $validatedData['model'], //llava:7b , qwen3-vl:8b
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                        'images' => [
                            $base64Image
                        ]

                    ]
                ],
                'stream' => false,
            ]);


        return response()->json(
            $response->json(),
            $response->status()
        );
    }
}
