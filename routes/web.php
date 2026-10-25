<?php
use App\Http\Middleware\CheckAge;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ProfileController;
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

require __DIR__.'/auth.php';

Route::get('/upload', [FileUploadController::class, 'create'])->name('upload.create');
Route::post('/upload', [FileUploadController::class, 'store'])->name('upload.store');
Route::get('/restricted-content', function () {
    return '<h1>Welcome! You are old enough to view this content.</h1>';
})->middleware(CheckAge::class); 
// Or use 'age.check' if you aliased it
// Route to simulate setting the age in session
Route::get('/set-age/{age}', function ($age) {
    session(['age' => $age]);
    return "Age has been set to {$age} in the session. <a href='/restricted-content'>Try visiting restricted content</a>";
});
