<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\StorageService;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function downloadFolder(StorageService $storageService, $path = '')
    {
        if ($path == '') {
            $folderPath = 'users/' . Auth::id(); // relative to storage/app
        } else {
            $folderPath = 'users/' . Auth::id() . '/' . $path;
        }
        $zipPath = $storageService->zipFolder($folderPath, 'public');

        return response()->download($zipPath, 'SortAI_' . now()->format('Y-m-d_H-i-s') . '.zip')->deleteFileAfterSend(true);
    }
}
