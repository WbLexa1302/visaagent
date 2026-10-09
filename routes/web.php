<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisaApplicationController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\PostController; // <-- Sudah di-import dengan benar

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. Homepage ---
Route::get('/', [VisaApplicationController::class, 'index'])->name('home');


// --- 2. Pendaftaran (Apply) ---
Route::get('/apply', [VisaApplicationController::class, 'create'])->name('apply.create');
Route::post('/apply', [VisaApplicationController::class, 'store'])->name('apply.store');


// --- 3. Fitur Tracking Aplikasi (Sudah Diperbarui) ---
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
Route::post('/tracking', [TrackingController::class, 'search'])->name('tracking.search');


// --- 4. Katalog Visa & Produk (Grup & Berurutan) ---
Route::prefix('visa')->group(function () {

    // Level 1: Halaman Utama Visa (Menampilkan Single Entry, Multiple Entry, KITAS)
    // Contoh: /visa
    Route::get('/', [VisaController::class, 'index'])->name('visa.index');

    // Level 2: Halaman Sub-Kategori (1 Parameter)
    // Contoh: /visa/single-entry
    Route::get('/{type}', [VisaController::class, 'indexByType'])->name('visa.type');

    // Level 3: Halaman List Produk Akhir (2 Parameter)
    // Contoh: /visa/single-entry/tourist-visa
    Route::get('/{type}/{category}', [VisaController::class, 'showProductsBySubCategory'])->name('visa.subCategoryList');

    // Level 4: Detail Produk Akhir (3 Parameter)
    // Contoh: /visa/single-entry/tourist-visa/c1-tourist-visa
    Route::get('/{type}/{category}/{slug}', [VisaController::class, 'detail'])->name('visa.detail');
});


// --- 5. Localization / Bahasa ---
Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['id', 'en'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('lang.switch');


// --- 6. Berita / Artikel ---
// Ditambahkan: Jalur untuk menampilkan semua daftar artikel berita
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Jalur untuk menampilkan halaman detail artikel berita berdasarkan slug-nya
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
