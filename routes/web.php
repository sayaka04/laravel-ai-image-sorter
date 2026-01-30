<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UploadQueueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Route::resource('albums', AlbumController::class);
// Route::resource('categories', CategoryController::class);
// Route::resource('files', FileController::class);
// Route::resource('upload_queues', UploadQueueController::class);

Route::resources([
    'albums' => AlbumController::class,
    'categories' => CategoryController::class,
    'files' => FileController::class,
    'upload_queues' => UploadQueueController::class,
]);


Route::get('/testing', [TestingController::class, 'index'])->name('testing.index');

Route::view('/test', 'test');
