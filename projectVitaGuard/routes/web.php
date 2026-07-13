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
use App\Http\Controllers\ConsultationController;

# untuk mengaktifkan semua rute bawaan Laravel UI/Breeze untuk sistem autentikasi, login, register, reset dan logout 
Auth::routes();

# route untuk menampilkan halaman beranda utama aplikasi 
Route::get('/', [FrontEndController::class, 'home'])->name('home');
# route untuk menampilkan halaman detail dari sebuah servuce berdasarkan parameter service yang di klik 
Route::get('/detail/{service}', [FrontEndController::class, 'detail'])->name('detailService');
# route untuk menampilkan halaman keranjang belanja untuk melihat layanan
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
# route untuk memperbarui atau memasukan item ke dalam keranjang 
Route::put('/goto-cart/{service}', [FrontEndController::class, 'putCart'])->name('putCart');
# route untuk menghapus item layanan tertentu dari keranjang belanja 
Route::delete('/goto-cart/{service}', [FrontEndController::class, 'deleteCart'])->name('deleteCart');
# route untuk memproses data belanjaan menjadi transaksi, dia wajib login
Route::post('/submit', [FrontEndController::class, 'checkout'])->name('checkout')->middleware('auth');

# route untuk menampilkan view tamplate bernama welcomehealth
Route::get('/welcome', function () {
    return view('welcomehealth');
})->name('welcome.portal');

# route untuk menampilkan halaman pilihan menu utama 
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

# route untuk mengarahkan pengguna berdasarkan parameter jenis 
Route::get('/menu/{jenis}', function ($jenis) {
    if ($jenis === 'konsultasi') {
        return view('menukonsul');
    } elseif ($jenis === 'janji') {
        return view('menujanji');
    }
    abort(404);
})->name('menu.jenis');

# route ini dibungkus menggunakan middleware artinya hanya pengguna login yang memiliki role admin yang dibolehkan akses 
Route::middleware(['auth', 'role:admin'])->group(function () {

    # route untuk menampilkan halaman pusat monitoring/Dashboard khusus administrator
    Route::get('/admin', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    # route untuk mengarahkan ke URL admin secara cepat, jika /categories dia akan redirect kesana dengan cepat 
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

    # route untuk membuat 7 rute CRUD secara otomatis utnuk masing - masing controller 
    Route::resource('services', ServiceController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('members', MemberController::class);
    Route::resource('bookings', BookingController::class);

    # route untuk menampilkan daftar layanan kesehatan dengan tarif termahal 
    Route::get('/category/showExpensiveService', [CategoryController::class, 'showExpensiveService'])
        ->name('category.showExpensiveService');
    # route untuk menampilkan info detail terkait daftar layanan pada kategori tertentu 
    Route::post('/category/showInfo', [CategoryController::class, 'showInfo'])
        ->name('category.showInfo');
    # menampilkan list services 
    Route::post('/category/showListServices', [CategoryController::class, 'showListServices'])
        ->name('category.showListServices');

    # route khusus berbasis POST untuk Kategori, Artikel, Layanan, dan Transaksi agar Admin bisa melakukan edit data via modal pop-up dan hapus data secara real-time tanpa perlu memuat ulang seluruh halaman (menggunakan AJAX)

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

# route untuk menampilkan halaman statistik kerja khusus dokter 
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboardDokter'])->name('dashboard');

    # route untuk menampilkan daftar reservasi booking konsultasi
    Route::get('/bookings', [BookingController::class, 'indexDoctor'])->name('bookings');
    # route untuk mengubah status booking menggunakan metode HTTP patch 
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

# route dimana hanya bisa diakses oleh member terdaftar 
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    # masuk ke halaman dashboard member 
    Route::get('/dashboard', [HomeController::class, 'dashboardMember'])->name('dashboard');

    # menampilkan formulir pembuatan jadwal booking dengan dokter tertentu berdasarkan id 
    Route::get('/booking/create/{doctor_id}', [BookingController::class, 'create'])->name('booking.create');
    # menyimpan formulir booking yang diajukan member ke dalam database 
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    # menampilkan riwayat janji temu personal milik member. 
    Route::get('/history', [BookingController::class, 'history'])->name('history');
    //  untuk melihat semua daftar dokter
    Route::get('/member/doctors', [App\Http\Controllers\HomeController::class, 'memberDoctors'])->name('doctors');

    //  untuk melihat detail profil dokter tertentu
    Route::get('/member/doctors/{id}', [App\Http\Controllers\HomeController::class, 'memberDoctorProfile'])->name('doctors.profile');

    // Rute untuk daftar artikel dan fitur pencarian
    Route::get('/member/articles', [App\Http\Controllers\HomeController::class, 'memberArticles'])->name('articles');

    // Rute untuk membaca detail artikel tertentu berdasarkan ID
    Route::get('/member/articles/{id}', [App\Http\Controllers\HomeController::class, 'memberArticleDetail'])->name('articles.detail');

    // Rute untuk melihat riwayat konsultasi khusus member (tidak bisa hapus)
    //Route::get('/member/history', [App\Http\Controllers\HomeController::class, 'memberHistory'])->name('member.history');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.dashboard');
});

Route::put('/dokter/profile/update', [HomeController::class, 'updateProfileDokter'])->name('dokter.profile.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/consultation/{id}', [ConsultationController::class, 'show'])
        ->name('consultation.show');

    
    Route::post('/consultation/send', [ConsultationController::class, 'sendMessage'])
        ->name('consultation.send');

    // Ambil pesan terbaru (AJAX GET, dipakai untuk auto-refresh chat)
    Route::get('/consultation/{id}/fetch', [ConsultationController::class, 'fetchMessages'])
        ->name('consultation.fetch');
});

// Hanya dokter yang boleh menutup sesi konsultasi
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::patch('/consultation/{id}/close', [ConsultationController::class, 'close'])
        ->name('consultation.close');
});