<?php

namespace App\Http\Controllers;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
{
    public function getFile(StorageService $storageService, $filePath = "")
    {
        $filePath = $filePath;
        return $storageService->showFile($filePath);
    }


    public function downloadFolder(StorageService $storageService, $path = '')
    {
        if ($path == '') {
            $folderPath = 'users/' . Auth::id(); // relative to storage/app
        } else {
            $folderPath = 'users/' . Auth::id() . '/' . $path;
        }
        $zipPath = $storageService->zipFolder($folderPath, 'private');

        return response()->download($zipPath, 'SortAI_' . now()->format('Y-m-d_H-i-s') . '.zip')->deleteFileAfterSend(true);
    }
}
