<?php

namespace App\Http\Controllers;

use App\Enums\UploadStatus;
use App\Models\Category;
use App\Models\UploadQueue;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $max_storage_mb = 200;
        $storageService = new StorageService();
        $folderSize = $storageService->getFolderInfo('users/1', 'local');
        Log::info("Folder size: " . json_encode($folderSize));

        $albums_count = auth()->user()->albums()->count();
        $categories_count = Category::whereHas('album', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();
        $files_count = \App\Models\File::whereHas('category.album', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();
        $queues_count = UploadQueue::whereHas('album', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->where('status', UploadStatus::PENDING)
            ->count();

        $queues = UploadQueue::whereHas('album', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->where('status', UploadStatus::IMAGE_PROCESSING)
            ->orWhere('status', UploadStatus::FINAL_PROCESSING)
            ->get();

        $percent_used = round($folderSize['size_mb'] / $max_storage_mb * 100, 2);
        return view('dashboard.index', [
            'percent_used' => $percent_used,
            'max_storage_mb' => $max_storage_mb,
            'categories_count' => $categories_count,
            'albums_count' => $albums_count,
            'files_count' => $files_count,
            'queues_count' => $queues_count,
            'queues' => $queues,
            'folderSize' => $folderSize,
        ]);
    }
}
