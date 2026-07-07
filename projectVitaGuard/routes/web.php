<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [FrontEndController::class, 'home'])->name('home');
Route::get('/detail/{service}', [FrontEndController::class, 'detail'])->name('detailService');
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
Route::put('/goto-cart/{service}', [FrontEndController::class, 'putCart'])->name('putCart');
Route::delete('/goto-cart/{service}', [FrontEndController::class, 'deleteCart'])->name('deleteCart');
Route::post('/submit', [FrontEndController::class, 'checkout'])->name('checkout')->middleware('auth');

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

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', [HomeController::class, 'dashboard'])->name('admin.dashboard');

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
    Route::resource('bookings', BookingController::class);

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
    Route::post('/ajax/category/deleteData', [CategoryController::class, 'deleteData'])
        ->name('category.deleteData');

    Route::post('/ajax/article/getEditForm', [ArticleController::class, 'getEditForm'])
        ->name('article.getEditForm');
    Route::post('/ajax/article/getEditFormB', [ArticleController::class, 'getEditFormB'])
        ->name('article.getEditFormB');
    Route::post('/ajax/article/saveDataUpdate', [ArticleController::class, 'saveDataUpdate'])
        ->name('article.saveDataUpdate');
    Route::post('/ajax/article/deleteData', [ArticleController::class, 'deleteData'])
        ->name('article.deleteData');

    Route::post('/ajax/service/getEditForm', [ServiceController::class, 'getEditForm'])
        ->name('service.getEditForm');
    Route::post('/ajax/service/getEditFormB', [ServiceController::class, 'getEditFormB'])
        ->name('service.getEditFormB');
    Route::post('/ajax/service/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])
        ->name('service.saveDataUpdate');
    Route::post('/ajax/service/deleteData', [ServiceController::class, 'deleteData'])
        ->name('service.deleteData');

    Route::post('/ajax/transaction/getEditForm', [TransactionController::class, 'getEditForm'])
        ->name('transaction.getEditForm');
    Route::post('/ajax/transaction/getEditFormB', [TransactionController::class, 'getEditFormB'])
        ->name('transaction.getEditFormB');
    Route::post('/ajax/transaction/saveDataUpdate', [TransactionController::class, 'saveDataUpdate'])
        ->name('transaction.saveDataUpdate');
    Route::post('/ajax/transaction/deleteData', [TransactionController::class, 'deleteData'])
        ->name('transaction.deleteData');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboardDokter'])->name('dashboard');

    Route::get('/bookings', [BookingController::class, 'indexDoctor'])->name('bookings');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboardMember'])->name('dashboard');

    Route::get('/booking/create/{doctor_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/history', [BookingController::class, 'history'])->name('history');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.dashboard');
});

Route::put('/dokter/profile/update', [HomeController::class, 'updateProfileDokter'])->name('dokter.profile.update');

//  untuk melihat semua daftar dokter
Route::get('/member/doctors', [App\Http\Controllers\HomeController::class, 'memberDoctors'])->name('member.doctors');

//  untuk melihat detail profil dokter tertentu
Route::get('/member/doctors/{id}', [App\Http\Controllers\HomeController::class, 'memberDoctorProfile'])->name('member.doctors.profile');

// Rute untuk daftar artikel dan fitur pencarian
Route::get('/member/articles', [App\Http\Controllers\HomeController::class, 'memberArticles'])->name('member.articles');

// Rute untuk membaca detail artikel tertentu berdasarkan ID
Route::get('/member/articles/{id}', [App\Http\Controllers\HomeController::class, 'memberArticleDetail'])->name('member.articles.detail');

// Rute untuk melihat riwayat konsultasi khusus member (tidak bisa hapus)
//Route::get('/member/history', [App\Http\Controllers\HomeController::class, 'memberHistory'])->name('member.history');