<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Pages Routes (Dummy for Layouts except home)
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/services', function () {
    return Inertia::render('Services/Index');
})->name('services');

Route::get('/pricing', function () {
    return Inertia::render('Pricing/Index');
})->name('pricing');

Route::get('/blog', function () {
    return Inertia::render('Blog/Index');
})->name('blog');

Route::get('/contact', function () {
    return Inertia::render('Contact/Index');
})->name('contact');

// Admin Routes (using Breeze scaffold)
Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
