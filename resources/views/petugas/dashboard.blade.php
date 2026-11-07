<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="dashboard-container">

        <div class="dashboard-welcome">
            <h2>Selamat Datang, Petugas!</h2>
            <p>
                Kelola data buku, transaksi peminjaman, dan laporan
                perpustakaan dengan mudah.
            </p>
        </div>

        <div class="dashboard-grid">

            <a href="{{ route('buku.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📚</div>
                <h3>Data Buku</h3>
                <p>Lihat dan kelola koleksi buku perpustakaan.</p>
            </a>

            <a href="{{ route('peminjaman.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📖</div>
                <h3>Peminjaman</h3>
                <p>Kelola transaksi peminjaman dan pengembalian buku.</p>
            </a>

            <a href="{{ route('laporan.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📊</div>
                <h3>Laporan</h3>
                <p>Lihat data dan transaksi perpustakaan.</p>
            </a>

            <a href="{{ route('profile.edit') }}" class="dashboard-card">
                <div class="dashboard-icon">⚙️</div>
                <h3>Profil</h3>
                <p>Kelola informasi akun pribadi.</p>
            </a>

        </div>
    </div>
</x-app-layout>