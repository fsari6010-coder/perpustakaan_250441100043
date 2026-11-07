<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BukuResource;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
        ->withCount('peminjamans');

    if ($request->filled('cari')) {
        $cari = $request->cari;

        $query->where(function ($q) use ($cari) {
            $q->where('judul', 'like', "%{$cari}%")
              ->orWhere('penulis', 'like', "%{$cari}%");
        });
    }
    if ($request->filled('kategori_id')) {
    $query->where('kategori_id', $request->kategori_id);
    }

    if ($request->filled('tahun')) {
        $query->where('tahun_terbit', $request->tahun);
    }

    $perPage = (int) $request->input('per_page', 10);
    $perPage = max(1, min($perPage, 100));

    $buku = $query->orderBy('id', 'desc')
    ->paginate($perPage)
    ->withQueryString();

    return BukuResource::collection($buku);
    }

    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku->load('kategori'),
        ], 201);
    }

    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])
        ->find($id);

        if (!$buku) {
        return response()->json([
            'message' => 'Buku tidak ditemukan.',
        ], 404);
    }

        return response()->json([
            'data' => $buku,
        ], 200);
    }

    public function update(UpdateBukuRequest $request, string $id)
    {
         $buku = Buku::find($id);

    if (!$buku) {
        return response()->json([
            'message' => 'Buku tidak ditemukan.',
        ], 404);
    }

    $buku->update($request->validated());

    return response()->json([
        'message' => 'Buku berhasil diperbarui.',
        'data' => $buku->load('kategori'),
    ], 200);
    }

    public function destroy(string $id)
    {
        $buku = Buku::find($id);

    if (!$buku) {
        return response()->json([
            'message' => 'Buku tidak ditemukan.',
        ], 404);
    }

    $buku->delete();

    return response()->json([
        'message' => 'Buku berhasil dihapus',
    ], 200);
    }
}
