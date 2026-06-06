<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rentopia') - Platform Penyewaan Aplikasi & Game</title>
    <meta name="description" content="@yield('description', 'Rentopia - Platform penyewaan game dan aplikasi Android online terpercaya dengan antarmuka modern')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-['Inter'] min-h-screen antialiased flex flex-col selection:bg-blue-100 selection:text-blue-900">
    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="fixed top-4 right-4 z-[9999] flex items-center gap-3 bg-white text-gray-800 px-6 py-4 rounded-xl shadow-xl border border-emerald-100 border-l-4 border-l-emerald-500 animate-slide-in">
        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span class="font-medium text-sm">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    @endif
    @if(session('error'))
    <div id="flash-error" class="fixed top-4 right-4 z-[9999] flex items-center gap-3 bg-white text-gray-800 px-6 py-4 rounded-xl shadow-xl border border-red-100 border-l-4 border-l-red-500 animate-slide-in">
        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <span class="font-medium text-sm">{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    @endif
    @if($errors->any())
    <div id="flash-validation" class="fixed top-4 right-4 z-[9999] bg-white text-gray-800 px-6 py-4 rounded-xl shadow-xl border border-red-100 border-l-4 border-l-red-500 animate-slide-in max-w-md">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="font-semibold text-sm">Terdapat kesalahan:</span>
            <button onclick="this.closest('#flash-validation').remove()" class="ml-auto text-gray-400 hover:text-gray-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 ml-11">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-600/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xl font-extrabold font-['Outfit'] text-gray-900 tracking-tight">Rentopia</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="/admin/dashboard" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ request()->is('admin/dashboard*') || request()->is('admin/produk*') ? 'bg-blue-50 text-blue-600' : '' }}">Dashboard</a>
                            <a href="/admin/peminjaman" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-colors relative {{ request()->is('admin/peminjaman*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                Peminjaman
                                @php
                                    $pendingCount = \App\Models\Peminjaman::where('status', 'Menunggu')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                    </span>
                                @endif
                            </a>
                            <a href="/admin/laporan" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ request()->is('admin/laporan*') ? 'bg-blue-50 text-blue-600' : '' }}">Laporan</a>
                        @else
                            <a href="/katalog" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ request()->is('katalog*') ? 'bg-blue-50 text-blue-600' : '' }}">Katalog</a>
                            <a href="/cart" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-colors relative {{ request()->is('cart*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                Keranjang
                                @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-600 rounded-full text-[10px] font-bold text-white flex items-center justify-center">{{ auth()->user()->cart->items->count() }}</span>
                                @endif
                            </a>
                            <a href="/peminjaman" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ request()->is('peminjaman*') ? 'bg-blue-50 text-blue-600' : '' }}">Peminjaman Saya</a>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-full border border-gray-200">
                            <div class="w-6 h-6 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }} border {{ auth()->user()->isAdmin() ? 'border-purple-200' : 'border-green-200' }}">{{ ucfirst(auth()->user()->role) }}</span>
                        </div>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="/login" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Masuk</a>
                        <a href="/register" class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 active:scale-95">Daftar Sekarang</a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white absolute w-full shadow-lg">
            <div class="px-4 py-3 space-y-1">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="/admin/dashboard" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600">Dashboard</a>
                        <a href="/admin/peminjaman" class="block flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                            Peminjaman
                            @if(isset($pendingCount) && $pendingCount > 0)
                                <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="/admin/laporan" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600">Laporan</a>
                    @else
                        <a href="/katalog" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600">Katalog</a>
                        <a href="/cart" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600">Keranjang</a>
                        <a href="/peminjaman" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600">Peminjaman</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="font-bold font-['Outfit'] text-gray-900 tracking-tight">Rentopia</span>
                </div>
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Rentopia. Aplikasi penyewaan digital modern.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto-dismiss flash messages
        setTimeout(() => {
            document.querySelectorAll('[id^="flash-"]').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-10px)';
                el.style.transition = 'all 0.3s ease-out';
                setTimeout(() => el.remove(), 300);
            });
        }, 4000);

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>
</body>
</html>
