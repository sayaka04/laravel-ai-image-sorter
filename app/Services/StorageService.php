<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

use function Laravel\Prompts\info;

class StorageService
{
    /**
     * Get folder info: size and total files
     *
     * @param string $directory Folder path relative to disk
     * @param string $disk Disk name ('public' by default)
     * @return array ['size' => '1.23 MB', 'total_files' => 10]
     */
    public function getFolderInfo(string $directory, string $disk = 'local'): array
    {
        $sizeBytes = 0;
        $files = Storage::disk($disk)->allFiles($directory);
        $totalFiles = count($files);

        foreach ($files as $file) {
            $sizeBytes += Storage::disk($disk)->size($file);
        }

        // All folders (recursive)
        $folders = Storage::disk($disk)->allDirectories($directory);
        $totalFolders = count($folders);


        Log::info("testing: " . $totalFolders);

        return [
            'size_bytes' => $sizeBytes,                   // integer, raw bytes
            'size_kb'    => $sizeBytes / 1024,           // float, KB
            'size_mb'    => $sizeBytes / 1024 / 1024,    // float, MB
            'size_gb'    => $sizeBytes / 1024 / 1024 / 1024, // float, GB
            'size_human' => $this->formatBytes($sizeBytes),  // string for display
            'total_files' => $totalFiles,
            'total_folders' => $totalFolders,
        ];
    }

    /**
     * Format bytes into human-readable string
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }











    /**
     * Create a ZIP file of a folder (future-proof, memory-efficient)
     *
     * @param string $folderPath Folder to zip (relative to storage/app)
     * @return string Full path to the temporary ZIP file
     * @throws \RuntimeException
     */
    public function zipFolder(string $folderPath, string $disk = 'local'): string
    {
        $basePath = storage_path('app/' . $disk . DIRECTORY_SEPARATOR . $folderPath);

        if (!is_dir($basePath)) {
            throw new \RuntimeException("Folder does not exist: $folderPath");
        }

        $files = $this->getAllFiles($basePath);

        if (empty($files)) {
            Log::info("No files found in '$folderPath' to zip");
            abort(404);
        }

        // Create temp folder if missing
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipName = Str::random(40) . '.zip';
        $zipPath = $tempDir . DIRECTORY_SEPARATOR . $zipName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException("Could not create ZIP file at $zipPath");
        }

        // Add files
        foreach ($files as $file) {
            // Keep relative folder structure in ZIP
            $relativePath = ltrim(str_replace($basePath, '', $file), '/\\');
            $zip->addFile($file, $relativePath);
        }

        $zip->close();

        clearstatcache(true, $zipPath);

        if (!file_exists($zipPath) || filesize($zipPath) === 0) {
            throw new \RuntimeException('ZIP file was not created correctly');
        }

        return $zipPath;
    }

    /**
     * Recursively get all files in a folder (memory-efficient)
     *
     * @param string $dir Absolute path
     * @param array $files Reference to array to collect files
     * @return array
     */
    private function getAllFiles(string $dir, array &$files = []): array
    {
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->getAllFiles($path, $files); // recursion by reference
            } elseif (is_file($path)) {
                $files[] = $path;
            }
        }

        return $files;
    }















    public function showFile($filepath)
    {

        $finalFilePath = 'users' . '/' . Auth::user()->id . '/' .  $filepath;

        Log::info("Filename: " . $finalFilePath);

        if (!Auth::user()) {
            abort(403, 'Unauthorized access');
        }

        Log::info("Attempting to access file: " . $finalFilePath);

        // Use the 'public' disk that maps to storage/app/public
        $disk = Storage::disk('local');

        Log::info("Checking disk: " . $finalFilePath);

        if (!$disk->exists($finalFilePath)) {
            abort(404, 'File not found: ' . $finalFilePath);
        } else {
            // Log file existence for debugging
            Log::info("File found: " . $finalFilePath);
        }

        $file = $disk->get($finalFilePath);
        $type = $disk->mimeType($finalFilePath);

        return response($file, 200)->header("Content-Type", $type);
    }


    public function renameFolder($oldPath, $newPath)
    {

        Log::info('storage disk: ' . Storage::disk('local')->path(''));
        Log::info($oldPath);
        Log::info($newPath);

        // Returns true on success, false on failure
        return Storage::disk('local')->move($oldPath, $newPath);
    }
}
