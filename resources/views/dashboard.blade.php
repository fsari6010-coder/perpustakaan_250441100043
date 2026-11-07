<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="dashboard-container">

        <div class="dashboard-welcome">
            <h2>Selamat Datang di Perpustakaan Kita!</h2>
            <p>
                Kelola data buku, pengguna, peminjaman, dan laporan
                perpustakaan dengan mudah.
            </p>
        </div>

        <div class="dashboard-grid">

            <a href="{{ route('buku.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📚</div>
                <h3>Data Buku</h3>
                <p>Kelola koleksi dan informasi buku perpustakaan.</p>
            </a>

            <a href="{{ route('users.index') }}" class="dashboard-card">
                <div class="dashboard-icon">👥</div>
                <h3>Pengguna</h3>
                <p>Kelola akun dan hak akses pengguna.</p>
            </a>

            <a href="{{ route('peminjaman.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📖</div>
                <h3>Peminjaman</h3>
                <p>Kelola transaksi peminjaman dan pengembalian.</p>
            </a>

            <a href="{{ route('laporan.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📊</div>
                <h3>Laporan</h3>
                <p>Lihat ringkasan dan transaksi perpustakaan.</p>
            </a>

            <a href="{{ route('profile.edit') }}" class="dashboard-card">
                <div class="dashboard-icon">⚙️</div>
                <h3>Profil</h3>
                <p>Kelola informasi akun pribadi.</p>
            </a>

        </div>
    </div>
</x-app-layout>