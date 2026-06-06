@extends('layouts.app')
@section('title', 'Katalog Produk')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    {{-- Hero --}}
    <div class="text-center mb-12 animate-fade-in max-w-3xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold font-['Outfit'] text-gray-900 mb-4 tracking-tight">Eksplorasi Katalog <span class="text-blue-600">Rentopia</span></h1>
        <p class="text-gray-500 text-lg">Temukan ratusan game dan aplikasi Android premium. Sewa sekarang dan dapatkan akses instan selama 7 hari penuh.</p>
    </div>

    {{-- Search --}}
    <form method="GET" class="flex flex-col sm:flex-row items-center gap-3 mb-10 max-w-3xl mx-auto">
        <div class="relative w-full">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama game atau aplikasi..."
                class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
        </div>
        <select name="kategori" class="w-full sm:w-48 px-4 py-3.5 bg-white border border-gray-200 rounded-2xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm font-medium appearance-none cursor-pointer shadow-sm">
            <option value="">Semua Kategori</option>
            <option value="game" {{ request('kategori') == 'game' ? 'selected' : '' }}>🎮 Kategori Game</option>
            <option value="android" {{ request('kategori') == 'android' ? 'selected' : '' }}>📱 Kategori Android</option>
        </select>
        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 active:scale-95">Cari</button>
    </form>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($produks as $produk)
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover shadow-sm group animate-fade-in flex flex-col">
            <div class="aspect-[4/3] bg-gray-50 relative overflow-hidden border-b border-gray-100">
                @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $produk->nama_produk }}">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-20 h-20 bg-white shadow-sm border border-gray-100 rounded-2xl flex items-center justify-center">
                        @if($produk->kategori === 'game')
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider {{ $produk->kategori === 'game' ? 'bg-indigo-600 text-white' : 'bg-emerald-600 text-white' }} shadow-sm">
                        {{ $produk->kategori }}
                    </span>
                </div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <a href="{{ route('katalog.show', $produk->id) }}">
                    <h3 class="font-bold text-gray-900 mb-1.5 truncate text-lg hover:text-blue-600 transition">{{ $produk->nama_produk }}</h3>
                </a>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed flex-1">{{ $produk->deskripsi }}</p>
                <div class="flex items-center justify-between mb-5 pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-0.5">Harga Sewa</p>
                        <p class="text-lg font-bold text-blue-600">Rp {{ number_format($produk->harga_sewa, 0, ',', '.') }}<span class="text-xs text-gray-500 font-medium">/mgg</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-medium mb-0.5">Stok</p>
                        <span class="text-sm font-bold {{ $produk->stok > 0 ? 'text-gray-900' : 'text-red-500' }}">{{ $produk->stok }}</span>
                    </div>
                </div>
                <form action="/cart/add" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $produk->id }}">
                    <button type="submit" class="w-full py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-blue-600 transition-colors active:scale-[0.98] shadow-sm flex items-center justify-center gap-2" {{ $produk->stok < 1 ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        {{ $produk->stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-gray-900 font-bold text-xl mb-2">Produk Tidak Ditemukan</p>
            <p class="text-gray-500">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
        </div>
        @endforelse
    </div>

    @if(isset($produks) && method_exists($produks, 'hasPages') && $produks->hasPages())
    <div class="mt-10">{{ $produks->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
