<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index()
    {
        // Menggunakan nama variabel $buku agar sesuai dengan view index.blade.php
        $buku = Buku::all(); 
        return view('buku.index', compact('buku'));
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi inputan form tambah buku
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
        ]);

        // Simpan data ke database Supabase
        Buku::create([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Pencarian buku.
     */
    public function cari(Request $request)
    {
        $keyword = $request->input('q');
        $buku = Buku::where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('penulis', 'LIKE', "%{$keyword}%")
                    ->get();

        return view('buku.index', compact('buku'));
    }

    /**
     * Menghapus data buku.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}