<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="dashboard-container">

        <div class="dashboard-welcome">
            <h2>Selamat Datang, Siswa!</h2>
            <p>
                Temukan buku yang ingin kamu baca dan pantau
                riwayat peminjaman buku melalui perpustakaan.
            </p>
        </div>

        <div class="dashboard-grid">

            <a href="{{ route('buku.index') }}" class="dashboard-card">
                <div class="dashboard-icon">📚</div>
                <h3>Daftar Buku</h3>
                <p>Lihat koleksi buku yang tersedia di perpustakaan.</p>
            </a>

            <a href="{{ route('peminjaman.riwayat') }}" class="dashboard-card">
                <div class="dashboard-icon">📖</div>
                <h3>Riwayat Peminjaman</h3>
                <p>Lihat daftar buku yang pernah kamu pinjam.</p>
            </a>

            <a href="{{ route('profile.edit') }}" class="dashboard-card">
                <div class="dashboard-icon">⚙️</div>
                <h3>Profil</h3>
                <p>Kelola informasi akun pribadi.</p>
            </a>

        </div>
    </div>
</x-app-layout>