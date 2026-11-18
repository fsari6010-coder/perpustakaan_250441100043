<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\Peminjaman;
use App\Policies\PeminjamanPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa HTTPS jika berjalan di Vercel atau environment production
        if ($this->app->environment('production') || str_contains(request()->getHost(), '.vercel.app')) {
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