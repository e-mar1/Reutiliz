<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\ItemController;

Route::get('/', [ItemController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'admin']);

//page details
Route::get('/item/{id}', [ItemController::class, 'show'])->name('components.show-details');
// New: Favorite Route
Route::post('/items/{item}/favorite', [ItemController::class, 'toggleFavorite'])->name('items.toggleFavorite');

// New: Report Routes
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

Route::get('/category/{category}', [ItemController::class, 'category'])->name('category.items');

Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/annonces', [UserController::class, 'getUserAnnonces'])->name('user.annonces');
    Route::get('/user/favorites', [UserController::class, 'getUserFavorites'])->name('user.favorites');
    Route::get('/user/orders', [UserController::class, 'getUserOrders'])->name('user.orders');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users CRUD
    Route::get('users', [UserController::class, 'adminIndex'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    // Annonces (Items) CRUD
    Route::get('annonces', [ItemController::class, 'adminIndex'])->name('annonces.index');
    Route::get('annonces/create', [ItemController::class, 'create'])->name('annonces.create');
    Route::post('annonces', [ItemController::class, 'store'])->name('annonces.store');
    Route::get('annonces/{item}/edit', [ItemController::class, 'edit'])->name('annonces.edit');
    Route::put('annonces/{item}', [ItemController::class, 'update'])->name('annonces.update');
    Route::delete('annonces/{item}', [ItemController::class, 'destroy'])->name('annonces.destroy');
    Route::get('annonces/{item}', [ItemController::class, 'show'])->name('annonces.show');
});

Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
Route::post('/items/{item}/report', [ItemController::class, 'report'])->name('items.report');