<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
   

    public function index()
    {
        $buku = Buku::all();

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = Buku::find($id);

        return view('buku.show', compact('buku'));
    }
}
