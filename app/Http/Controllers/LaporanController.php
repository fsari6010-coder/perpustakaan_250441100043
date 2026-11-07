<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $jumlahBuku = Buku::count();
        $jumlahPeminjaman = Peminjaman::count();

        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('laporan.index', compact(
            'jumlahBuku',
            'jumlahPeminjaman',
            'peminjamans'
        ));
    }
}