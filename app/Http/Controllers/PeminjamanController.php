<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $anggotas = Anggota::all();
        $bukus = Buku::all();

        return view('peminjaman.index', compact(
            'peminjamans',
            'anggotas',
            'bukus'
        ));
    }

    // Menyimpan data peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    // Memproses pengembalian buku
    public function kembali(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }


    // Menampilkan detail peminjaman (pengujian IDOR)
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->findOrFail($id);

        return view('peminjaman.show', compact('peminjaman'));
    }
}
