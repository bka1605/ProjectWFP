<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/welcome', function () {
    return view('welcomehealth');
})->name('welcome.portal');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/menu/{jenis}', function ($jenis) {
    if ($jenis === 'konsultasi') {
        return view('menukonsul');
    } elseif ($jenis === 'janji') {
        return view('menujanji');
    }

    abort(404);
})->name('menu.jenis');

Route::get('/admin/{jenis}', function ($jenis) {
    if ($jenis === 'categories') {
        return redirect()->route('categories.index');
    } elseif ($jenis === 'order') {
        return redirect()->route('transactions.index');
    } elseif ($jenis === 'members') {
        return redirect()->route('members.index');
    }

    abort(404);
})->name('admin.menu');

Route::get('/admin', function () {
    return view('admin.menu');
})->name('admin');

Route::resource('services', ServiceController::class)->only(['index']);
Route::resource('categories', CategoryController::class)->only(['index']);
Route::resource('doctors', DoctorController::class)->only(['index']);
Route::resource('articles', ArticleController::class)->only(['index']);
Route::resource('transactions', TransactionController::class)->only(['index']);
Route::resource('members', MemberController::class)->only(['index']);