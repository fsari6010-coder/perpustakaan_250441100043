@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="crud-container">
    <div class="crud-card">
        <h2>Riwayat Peminjaman Saya</h2>

        <div class="crud-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                            <td colspan="5">
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection