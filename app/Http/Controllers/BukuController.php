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
        $buku = Buku::all(); 
        
        // Jika request mengharapkan JSON (AJAX)
        if (request()->expectsJson()) {
            return response()->json($buku);
        }

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
        try {
            // Validasi inputan form
            $request->validate([
                'kategori_id' => 'required',
                'judul' => 'required|string|max:255',
                'penulis' => 'required|string|max:255',
                'tahun_terbit' => 'required|numeric',
            ]);

            // Simpan data ke database Supabase
            $buku = Buku::create([
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'tahun_terbit' => $request->tahun_terbit,
            ]);

            // Jika dikirim lewat AJAX/Fetch
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku berhasil ditambahkan!',
                    'data' => $buku
                ]);
            }

            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Tangkap error jika validasi/simpan gagal agar tidak merusak format JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
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
    public function destroy(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus!'
            ]);
        }

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}