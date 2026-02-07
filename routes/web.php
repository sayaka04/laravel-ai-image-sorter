<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageController;

use App\Http\Controllers\Table\AlbumController;
use App\Http\Controllers\Table\CategoryController;
use App\Http\Controllers\Table\FileController;
use App\Http\Controllers\Table\UploadQueueController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
})->name('/');


Route::get('/home', function () {
    return view('home', [
        'title' => 'SmartSorter AI'
    ]);
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('albums', AlbumController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('files', FileController::class)->except(['create', 'store']);
    Route::resource('upload_queues', UploadQueueController::class)->except(['edit', 'update']);

    Route::get('/download-folder/{path?}', [StorageController::class, 'downloadFolder'])
        ->where('path', '.*')
        ->name('download.folder');

    Route::get('/file/{filePath}', [StorageController::class, 'getFile'])
        ->where('filePath', '.*')
        ->name('getFile');
});
