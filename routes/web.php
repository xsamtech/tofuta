<?php

/**
 * @author Xanders
 * @see https://team.xsamtech.com/xanderssamoth
 */

use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| ROUTES FOR EVERY ROLES
|--------------------------------------------------------------------------
*/
// Generate symbolic link
Route::get('/symlink', function () { return view('symlink'); })->name('generate_symlink');
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/language/{locale}', [HomeController::class, 'changeLanguage'])->name('change_language');
Route::get('/notifications', [HomeController::class, 'notification'])->name('notification.home');
Route::get('/about', [HomeController::class, 'about'])->name('about.home');
Route::get('/about/{entity}', [HomeController::class, 'aboutEntity'])->name('about.entity');

require __DIR__.'/auth.php';
