<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

Route::middleware('auth:sanctum')->group(function () {

    // Melihat daftar dan detail buku
    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::get('buku', [BukuController::class, 'index']);
        Route::get('buku/{buku}', [BukuController::class, 'show']);
    });

    // Menambah, mengubah, dan menghapus buku
    Route::middleware('permission:kelola data buku')->group(function () {
        Route::post('buku', [BukuController::class, 'store']);
        Route::put('buku/{buku}', [BukuController::class, 'update']);
        Route::patch('buku/{buku}', [BukuController::class, 'update']);
        Route::delete('buku/{buku}', [BukuController::class, 'destroy']);
    });

    // Laporan perpustakaan
    Route::middleware('permission:lihat laporan perpustakaan')->group(function () {
        Route::get('rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
        Route::get('rekap/pemminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
    });
});
