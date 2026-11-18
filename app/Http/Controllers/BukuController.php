<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku; // Sesuaikan dengan model buku kamu

class BukuController extends Controller
{
    public function index()
    {
        // Kode untuk menampilkan daftar buku
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        // Menampilkan form tambah buku (jika pakai halaman terpisah)
        return view('buku.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan dari form
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
        ]);

        // 2. Simpan ke database
        Buku::create([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Kode untuk hapus buku
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}