@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

{{-- Hero Section --}}
<div class="relative overflow-hidden bg-white">
    <div class="absolute inset-0 z-0">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute top-1/2 -left-24 w-72 h-72 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-32 lg:pb-40 flex flex-col items-center text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-sm font-semibold mb-6 animate-fade-in">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            Platform Penyewaan Digital #1
        </div>
        
        <h1 class="text-4xl md:text-6xl font-extrabold font-['Outfit'] text-gray-900 tracking-tight mb-6 max-w-4xl leading-tight">
            Mainkan Game & Aplikasi Premium Tanpa Harus Beli Mahal
        </h1>
        
        <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl">
            Rentopia memberikan akses instan ke ratusan game dan aplikasi Android berbayar dengan sistem sewa yang aman, murah, dan otomatis.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <a href="{{ auth()->check() ? '/katalog' : '/register' }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-[0.98] flex items-center justify-center gap-2 text-lg">
                Mulai Eksplorasi Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border border-gray-200 hover:bg-gray-50 hover:text-gray-900 transition-all active:scale-[0.98] flex items-center justify-center text-lg">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</div>

{{-- Features Section --}}
<div id="features" class="bg-gray-50 py-24 border-y border-gray-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 mb-4">Kenapa Memilih Rentopia?</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Kami mendesain pengalaman menyewa produk digital senyaman mungkin dengan berbagai fitur unggulan.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Feature 1 --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengembalian Otomatis</h3>
                <p class="text-gray-500 leading-relaxed">Sistem cerdas kami akan otomatis menutup akses unduhan ketika masa sewa Anda habis. Anda tidak perlu repot melakukan konfirmasi pengembalian.</p>
            </div>
            
            {{-- Feature 2 --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Transaksi 100% Aman</h3>
                <p class="text-gray-500 leading-relaxed">Alur pembayaran yang transparan dan diverifikasi manual oleh Admin menjamin bahwa setiap penyewaan Anda pasti diproses dengan benar tanpa ada penipuan.</p>
            </div>
            
            {{-- Feature 3 --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Katalog Berkualitas</h3>
                <p class="text-gray-500 leading-relaxed">Akses ke aplikasi produktivitas premium dan game Android terpopuler yang telah melewati kurasi ketat untuk memastikan kualitas terbaik untuk Anda.</p>
            </div>
        </div>
    </div>
</div>

{{-- Featured Products --}}
<div class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 mb-2">Produk Unggulan</h2>
                <p class="text-gray-500">Koleksi terpopuler minggu ini di Rentopia.</p>
            </div>
            <a href="{{ auth()->check() ? '/katalog' : '/login' }}" class="hidden md:inline-flex items-center gap-2 text-blue-600 font-bold hover:text-blue-700 transition">
                Lihat Semua Katalog
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProduks as $produk)
            <div class="group bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300">
                <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 group-hover:scale-105 transition-transform duration-500">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold rounded-lg shadow-sm capitalize">{{ $produk->kategori }}</span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 truncate group-hover:text-blue-600 transition-colors">{{ $produk->nama_produk }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-6">{{ $produk->deskripsi }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Harga Sewa</p>
                            <p class="text-lg font-extrabold text-blue-600">Rp {{ number_format($produk->harga_sewa, 0, ',', '.') }}<span class="text-xs font-medium text-gray-500">/minggu</span></p>
                        </div>
                        <a href="{{ auth()->check() ? route('katalog.show', $produk->id) : '/login' }}" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Belum ada produk yang ditambahkan ke sistem.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-10 text-center md:hidden">
            <a href="{{ auth()->check() ? '/katalog' : '/login' }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                Lihat Semua Katalog
            </a>
        </div>
    </div>
</div>

@endsection
