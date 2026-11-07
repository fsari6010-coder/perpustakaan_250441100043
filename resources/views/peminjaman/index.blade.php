@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="crud-container">

    <div class="crud-card">
        <h2>Data Peminjaman Buku</h2>

        @if(session('success'))
            <div class="crud-message">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="crud-message">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @hasanyrole('admin|petugas')
            <h3>Tambah Peminjaman</h3>

            <form action="{{ route('peminjaman.store') }}" method="POST" class="crud-form">
                @csrf

                <div class="crud-field">
                    <label>Anggota</label>
                    <select name="anggota_id" required>
                        <option value="">Pilih Anggota</option>
                        @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id }}">
                                {{ $anggota->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="crud-field">
                    <label>Buku</label>
                    <select name="buku_id" required>
                        <option value="">Pilih Buku</option>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}">
                                {{ $buku->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="crud-field">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" required>
                </div>

                <div class="crud-field">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali">
                </div>

                <button type="submit" class="crud-btn crud-btn-primary">
                    Simpan Peminjaman
                </button>
            </form>
        @endhasanyrole
    </div>

    <div class="crud-card">
        <h2>Daftar Peminjaman</h2>

        <div class="crud-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        @can('kelola pengembalian')
                            <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                            <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}</td>

                            @can('kelola pengembalian')
                                <td>
                                    @if(!$peminjaman->tanggal_kembali)
                                        <form action="{{ route('peminjaman.kembali', $peminjaman->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="crud-btn crud-btn-primary">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        Sudah dikembalikan
                                    @endif
                                </td>
                            @endcan
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
