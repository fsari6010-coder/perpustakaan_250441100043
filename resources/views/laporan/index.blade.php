@extends('layouts.app')

@section('title', 'Laporan Perpustakaan')

@section('content')
<div class="crud-container">

    <div class="crud-card">
        <h2>Laporan Perpustakaan</h2>

        <div class="crud-message">
            <h3>Ringkasan Data</h3>
            <p>Jumlah Buku: <strong>{{ $jumlahBuku }}</strong></p>
            <p>Jumlah Peminjaman: <strong>{{ $jumlahPeminjaman }}</strong></p>
        </div>
    </div>

    <div class="crud-card">
        <h3>Daftar Transaksi Peminjaman</h3>

        <div class="crud-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                            <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                            <td>
                                {{ $peminjaman->tanggal_kembali
                                    ? 'Sudah dikembalikan'
                                    : 'Belum dikembalikan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection