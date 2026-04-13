<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome',function(){
    return view ('welcomehealth');
});
Route::get('/menu', function(){
    return view ('menu');
});

Route::get('/menu/{jenis}',function($jenis){
    if($jenis=="konsultasi"){
        return view ('menukonsul');  
    }
    else if($jenis=="janji"){
        return view('menujanji'); 
    }
});

Route::get('/admin/{jenis}',function($jenis){
    if($jenis=="Categories"){
        return view ('admincategories',['judul' => 'Portal Manajemen: Daftar Kategori Layanan']);
    } 
    else if($jenis=="order"){
        return view('adminorder', ['judul' => 'Portal Manajemen: Daftar Konsultasi dan Janji Temu']);
    }
    else if($jenis=="members"){
        return view('adminmembers', ['judul' => 'Portal Manajemen: Daftar Pasien']);
    }
});