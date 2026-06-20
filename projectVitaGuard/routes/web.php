<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

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



Route::middleware(['auth'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard', [
            'judul' => 'Dashboard Admin VitaGuard'
        ]);
    })->name('admin.dashboard');

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

    Route::resource('services', ServiceController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('members', MemberController::class);

    Route::get('/category/showExpensiveService', [CategoryController::class, 'showExpensiveService'])
        ->name('category.showExpensiveService');

    Route::post('/category/showInfo', [CategoryController::class, 'showInfo'])
        ->name('category.showInfo');

    Route::post('/category/showListServices', [CategoryController::class, 'showListServices'])
        ->name('category.showListServices');


    Route::post('/ajax/category/getEditForm', [CategoryController::class, 'getEditForm'])
        ->name('category.getEditForm');
    Route::post('/ajax/category/getEditFormB', [CategoryController::class, 'getEditFormB'])
        ->name('category.getEditFormB');
    Route::post('/ajax/category/saveDataUpdate', [CategoryController::class, 'saveDataUpdate'])
        ->name('category.saveDataUpdate');
    Route::post('/ajax/category/deleteData', [CategoryController::class, 'deleteData'])->name('category.deleteData');

    Route::post('/ajax/article/getEditForm', [ArticleController::class, 'getEditForm'])
        ->name('article.getEditForm');
    Route::post('/ajax/article/getEditFormB', [ArticleController::class, 'getEditFormB'])
        ->name('article.getEditFormB');
    Route::post('/ajax/article/saveDataUpdate', [ArticleController::class, 'saveDataUpdate'])
        ->name('article.saveDataUpdate');
    Route::post('/ajax/article/deleteData', [ArticleController::class, 'deleteData'])->name('article.deleteData');

    Route::post('/ajax/service/getEditForm', [ServiceController::class, 'getEditForm'])
        ->name('service.getEditForm');
    Route::post('/ajax/service/getEditFormB', [ServiceController::class, 'getEditFormB'])
        ->name('service.getEditFormB');
    Route::post('/ajax/service/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])
        ->name('service.saveDataUpdate');
    Route::post('/ajax/service/deleteData', [ServiceController::class, 'deleteData'])->name('service.deleteData');

    Route::post('/ajax/transaction/getEditForm', [TransactionController::class, 'getEditForm'])
        ->name('transaction.getEditForm');
    Route::post('/ajax/transaction/getEditFormB', [TransactionController::class, 'getEditFormB'])
        ->name('transaction.getEditFormB');
    Route::post('/ajax/transaction/saveDataUpdate', [TransactionController::class, 'saveDataUpdate'])
        ->name('transaction.saveDataUpdate');
    Route::post('/ajax/transaction/deleteData', [TransactionController::class, 'deleteData'])->name('transaction.deleteData');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.dashboard');
});