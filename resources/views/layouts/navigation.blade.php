<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-20">

            <!-- Logo dan Nama Aplikasi -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-blue-950 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                        P
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-blue-950">
                            Perpustakaan Kita
                        </h1>
                        <p class="text-xs text-slate-500">
                            Temukan cerita yang ingin kamu baca.
                        </p>
                    </div>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden sm:flex items-center ms-12 gap-2">
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition
                       {{ request()->routeIs('dashboard') ? 'bg-blue-950 text-white' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-950' }}">
                        Dashboard
                    </a>

                    @can('lihat daftar buku')
                        <a href="{{ url('/buku') }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->is('buku*') ? 'bg-blue-950 text-white' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-950' }}">
                            Daftar Buku
                        </a>
                    @endcan

                    @can('kelola data pengguna')
                        <a href="{{ url('/users') }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->is('users*') ? 'bg-blue-950 text-white' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-950' }}">
                            Kelola Pengguna
                        </a>
                    @endcan

                    @can('kelola peminjaman')
                        <a href="{{ url('/peminjaman') }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->is('peminjaman*') ? 'bg-blue-950 text-white' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-950' }}">
                            Peminjaman
                        </a>
                    @endcan

                    @can('lihat riwayat peminjaman sendiri')
                        <a href="{{ url('/riwayat-peminjaman') }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->is('riwayat-peminjaman*') ? 'bg-blue-950 text-white' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-950' }}">
                            Riwayat
                        </a>
                    @endcan

                    @can('lihat laporan perpustakaan')
                        <a href="{{ url('/laporan') }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->is('laporan*') ? 'bg-blue-950 text-white' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-950' }}">
                            Laporan
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Profil Desktop -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-100 transition">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-950 flex items-center justify-center font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="text-left">
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    Akun Saya
                                </p>
                            </div>

                            <svg class="w-4 h-4 text-slate-500" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @can('lihat profil sendiri')
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil Saya
                            </x-dropdown-link>
                        @endcan

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                              class="inline-flex" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div x-show="open" x-transition class="sm:hidden border-t border-slate-200 bg-white">
        <div class="px-5 py-4 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50">
                Dashboard
            </a>

            @can('lihat daftar buku')
                <a href="{{ url('/buku') }}"
                   class="block px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50">
                    Daftar Buku
                </a>
            @endcan

            @can('kelola data pengguna')
                <a href="{{ url('/users') }}"
                   class="block px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50">
                    Kelola Pengguna
                </a>
            @endcan

            @can('kelola peminjaman')
                <a href="{{ url('/peminjaman') }}"
                   class="block px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50">
                    Peminjaman
                </a>
            @endcan

            @can('lihat riwayat peminjaman sendiri')
                <a href="{{ url('/riwayat-peminjaman') }}"
                   class="block px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50">
                    Riwayat Peminjaman
                </a>
            @endcan

            @can('lihat laporan perpustakaan')
                <a href="{{ url('/laporan') }}"
                   class="block px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50">
                    Laporan
                </a>
            @endcan
        </div>

        <div class="border-t border-slate-200 px-5 py-4">
            <p class="font-semibold text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-sm text-slate-500">{{ Auth::user()->email }}</p>

            @can('lihat profil sendiri')
                <a href="{{ route('profile.edit') }}"
                   class="block mt-3 text-sm text-blue-950 font-semibold">
                    Profil Saya
                </a>
            @endcan

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="text-sm text-red-600 font-semibold">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</nav>
