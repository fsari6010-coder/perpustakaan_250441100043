<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Menampilkan halaman view daftar buku.
     */
    public function index()
    {
        $buku = Buku::all(); 
        return view('buku.index', compact('buku'));
    }

    /**
     * API: Mengambil semua data buku dalam format JSON (Aman dari error HTML).
     */
    public function apiIndex()
    {
        try {
            $buku = Buku::all();
            return response()->json([
                'success' => true,
                'data' => $buku
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Mengambil detail satu buku berdasarkan ID.
     */
    public function apiShow($id)
    {
        try {
            $buku = Buku::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $buku
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Menyimpan data buku baru (Mendukung AJAX & Form biasa).
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kategori_id' => 'required',
                'judul' => 'required|string|max:255',
                'penulis' => 'required|string|max:255',
                'tahun_terbit' => 'required|numeric',
            ]);

            $buku = Buku::create([
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'tahun_terbit' => $request->tahun_terbit,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan!',
                'data' => $buku
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Memperbarui data buku.
     */
    public function update(Request $request, $id)
    {
        try {
            $buku = Buku::findOrFail($id);

            $request->validate([
                'kategori_id' => 'required',
                'judul' => 'required|string|max:255',
                'penulis' => 'required|string|max:255',
                'tahun_terbit' => 'required|numeric',
            ]);

            $buku->update([
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'tahun_terbit' => $request->tahun_terbit,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data buku berhasil diperbarui!',
                'data' => $buku
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $buku
            ]);
        }

        return view('buku.index', compact('buku'));
    }

    /**
     * Menghapus data buku.
     */
    public function destroy($id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $buku->delete();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus buku: ' . $e->getMessage()
            ], 500);
        }
    }
}