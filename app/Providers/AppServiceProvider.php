<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL; // <-- Tambahkan namespace ini
use App\Models\Peminjaman;
use App\Policies\PeminjamanPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS untuk semua aset di lingkungan Production (Vercel)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Policy untuk mengatur akses data peminjaman
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);

        // Gate untuk mengatur pengelolaan buku
        Gate::define('kelola-buku', function ($user) {
            return $user->hasRole(['admin', 'petugas']);
        });
    }
}