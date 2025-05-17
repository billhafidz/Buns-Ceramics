<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashAdminController;
use App\Http\Controllers\LanggananController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/member/dashboard', function () {
    if (!session('user')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu');
    }
    return view('member.dashboard');
})->name('member.dashboard');

Route::post('/logout', function () {
    session()->forget('user');
    return redirect('/');
})->name('logout');

Route::post('/admin-buns/logout', function () {
    session()->forget('admin_logged_in');
    session()->forget('admin_nama');
    return redirect('/');
})->name('admin.logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/adminbuns/index', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/adminbuns/index', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::redirect('/adminbuns', '/adminbuns/index');
Route::get('/adminbuns/dashboard', [DashAdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/adminbuns/gallery', fn() => view('adminbuns.gallery'))->name('admin.gallery');
Route::get('/adminbuns/users', fn() => view('adminbuns.users'))->name('admin.users');
Route::get('/adminbuns/members', fn() => view('adminbuns.members'))->name('admin.members');
Route::get('/adminbuns/classes', [LanggananController::class, 'index'])->name('adminbuns.classes.index');
Route::post('/adminbuns/classes', [LanggananController::class, 'store'])->name('adminbuns.classes.store');
Route::get('/adminbuns/classes/edit/{id}', [LanggananController::class, 'edit'])->name('adminbuns.classes.edit');
Route::post('/adminbuns/classes/update/{id}', [LanggananController::class, 'update'])->name('adminbuns.classes.update');
Route::delete('/adminbuns/classes/delete/{id}', [LanggananController::class, 'destroy'])->name('adminbuns.classes.destroy');
Route::get('/adminbuns/classes', [LanggananController::class, 'index'])->name('adminbuns.classes.index');
