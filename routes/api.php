<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LLMController;



Route::post('/llm/vision', [LLMController::class, 'handleVision']);
Route::post('/llm/text', [LLMController::class, 'handleText']);
