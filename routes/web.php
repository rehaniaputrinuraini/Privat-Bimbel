<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('/login-dummy', function () {
    return "Halaman Login sedang dikerjakan teman saya.";
})->name('login'); //dummy login nyak

// ========== ROUTE UNTUK BRANCH DESAIN (TAMPILAN STATIS) ==========

// Dashboard Tentor
Route::get('/dashboard/tentor', function () {
    return view('dashboard.tentor.index');
});

// Dashboard Admin
Route::get('/dashboard/admin', function () {
    return view('dashboard.admin.index');
});

// Dashboard SuperAdmin
Route::get('/dashboard/superadmin', function () {
    return view('dashboard.superadmin.index');
});

// Halaman Company Profile
Route::get('/companyprofile', function () {
    return view('companyprofile.landing');
});

Route::get('/about', function () {
    return view('companyprofile.about');
});

Route::get('/contact', function () {
    return view('companyprofile.contact');
});

// Halaman Profil
Route::get('/dashboard/profil', function () {
    return view('dashboard.profil.index');
});

Route::get('/dashboard/profil/edit', function () {
    return view('dashboard.profil.edit');
});

Route::get('/dashboard/profil/ubah-password', function () {
    return view('dashboard.profil.ubah-password');
});
