<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Models\Peminjaman;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Pengalihan dashboard berdasarkan role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    return redirect()->route('siswa.dashboard');
})->middleware('auth')->name('dashboard');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'permission:akses dashboard admin'])
    ->name('admin.dashboard');
// Dashboard Petugas
Route::get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
})->middleware(['auth', 'permission:akses dashboard petugas'])
    ->name('petugas.dashboard');

// Dashboard Siswa
Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->middleware(['auth', 'role:siswa'])
    ->name('siswa.dashboard');
// Halaman Daftar Buku
Route::get('/buku', [BukuController::class, 'index'])
    ->middleware(['auth', 'permission:lihat daftar buku'])
    ->name('buku.index');

Route::get('/buku-cari', [BukuController::class, 'cari'])
    ->middleware('auth')
    ->name('buku.cari');

Route::get('/buku/{id}/hapus', [BukuController::class, 'destroy'])
    ->middleware('auth')
    ->name('buku.hapus');
// Profile pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Pengelolaan Pengguna (Khusus Admin)
Route::middleware(['auth', 'permission:kelola data pengguna'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('users.updateRole');
});


// Pengelolaan Peminjaman
Route::middleware(['auth', 'permission:kelola peminjaman'])->group(function () {

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');
});

// Pengujian IDOR (A4)
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
    ->name('peminjaman.show');

Route::patch('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'kembali'])
    ->middleware(['auth', 'role:admin|petugas'])
    ->name('peminjaman.kembali');


// Riwayat Peminjaman Siswa
Route::get('/riwayat-peminjaman', function () {
    $peminjamans = Peminjaman::with(['anggota', 'buku'])
        ->whereHas('anggota', function ($query) {
            $query->where('email', Auth::user()->email);
        })
        ->latest()
        ->get();

    return view('peminjaman.riwayat', compact('peminjamans'));
})->middleware(['auth', 'role:siswa'])
    ->name('peminjaman.riwayat');

// Laporan Perpustakaan
Route::get('/laporan', [LaporanController::class, 'index'])
    ->middleware(['auth', 'permission:lihat laporan perpustakaan'])
    ->name('laporan.index');

// Route autentikasi Breeze
require __DIR__ . '/auth.php';
