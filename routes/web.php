<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashAdminController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GalleryController;

Route::get('/', [MainPageController::class, 'index'])->name('index');
Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/class', function () {
    return view('classes');
})->name('class');

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

Route::get('/account/profile', [AccountController::class, 'showProfile'])->name('account.profile');
Route::post('/account/profile/update', [AccountController::class, 'updateProfile'])->name('account.profile.update');


Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin-buns/index', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin-buns/index', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::redirect('/admin-buns', '/admin-buns/index');
Route::get('/admin-buns/dashboard', [DashAdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/admi-buns/gallery', [GalleryController::class, 'view'])->name('admin-buns.gallery');
Route::get('/admin-buns/gallery/create', [GalleryController::class, 'create'])->name('admin-buns.gallery.create');
Route::post('/admin-buns/gallery', [GalleryController::class, 'store'])->name('admin-buns.gallery.store');
Route::delete('/admin-buns/gallery/{id}', [GalleryController::class, 'delete'])->name('admin-buns.gallery.delete');
Route::get('/admin-buns/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('admin-buns.gallery.edit');
Route::put('/admin-buns/gallery/update/{id}', [GalleryController::class, 'update'])->name('admin-buns.gallery.update');



Route::get('/admin-buns/users', fn() => view('admin-buns.users'))->name('admin.users');
Route::get('/admin-buns/members', fn() => view('admin-buns.members'))->name('admin.members');
Route::get('/admin-buns/classes', [LanggananController::class, 'index'])->name('admin-buns.classes.index');
Route::post('/admin-buns/classes', [LanggananController::class, 'store'])->name('admin-buns.classes.store');
Route::get('/admin-buns/classes/edit/{id}', [LanggananController::class, 'edit'])->name('admin-buns.classes.edit');
Route::post('/admin-buns/classes/update/{id}', [LanggananController::class, 'update'])->name('admin-buns.classes.update');
Route::delete('/admin-buns/classes/delete/{id}', [LanggananController::class, 'destroy'])->name('admin-buns.classes.destroy');
Route::get('/admin-buns/classes', [LanggananController::class, 'index'])->name('admin-buns.classes.index');
Route::get('/subscribe', [SubscriptionController::class, 'showForm'])->name('subscribe');
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');
Route::get('/payment/index', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
Route::get('/class', [ClassController::class, 'index'])->name('class');
