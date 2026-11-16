<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya boleh melihat peminjamannya sendiri
        return $user->email === $peminjaman->anggota->email;
    }
}
