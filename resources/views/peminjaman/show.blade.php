<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman</title>
</head>

<body>
    <h2>Detail Peminjaman</h2>

    <p><strong>ID Peminjaman:</strong> {{ $peminjaman->id }}</p>
    <p><strong>Nama Anggota:</strong> {{ $peminjaman->anggota->nama ?? '-' }}</p>
    <p><strong>Email Anggota:</strong> {{ $peminjaman->anggota->email ?? '-' }}</p>
    <p><strong>Judul Buku:</strong> {{ $peminjaman->buku->judul ?? '-' }}</p>
    <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
    <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}</p>
</body>

</html>