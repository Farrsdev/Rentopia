@extends('layouts.app')
@section('title', $produk->nama_produk)
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <a href="/katalog" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm">
        <div class="md:flex">
            {{-- Image Section --}}
            <div class="md:w-5/12 bg-gray-50 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-gray-100 min-h-[300px]">
                @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="rounded-2xl max-h-80 w-full object-cover shadow-sm" alt="{{ $produk->nama_produk }}">
                @else
                <div class="w-40 h-40 bg-white shadow-sm border border-gray-100 rounded-3xl flex items-center justify-center">
                    @if($produk->kategori === 'game')
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                    <svg class="w-16 h-16 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                @endif
            </div>

            {{-- Content Section --}}
            <div class="md:w-7/12 p-8 lg:p-10 flex flex-col">
                <div class="mb-4">
                    <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider {{ $produk->kategori === 'game' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }} mb-3">{{ $produk->kategori }}</span>
                    <h1 class="text-3xl lg:text-4xl font-extrabold font-['Outfit'] text-gray-900 tracking-tight">{{ $produk->nama_produk }}</h1>
                </div>
                
                <div class="prose prose-sm text-gray-600 mb-8 max-w-none">
                    <p class="leading-relaxed">{{ $produk->deskripsi }}</p>
                </div>

                <div class="mt-auto">
                    <div class="flex flex-wrap items-center gap-8 mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Harga Sewa</p>
                            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($produk->harga_sewa, 0, ',', '.') }}<span class="text-sm font-semibold text-gray-500">/mgg</span></p>
                        </div>
                        <div class="w-px h-12 bg-gray-200 hidden sm:block"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Ketersediaan</p>
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-3 w-3">
                                  @if($produk->stok > 0)
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                  @else
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                  @endif
                                </span>
                                <p class="text-xl font-bold {{ $produk->stok > 0 ? 'text-gray-900' : 'text-red-500' }}">{{ $produk->stok }} <span class="text-sm font-medium text-gray-500">stok</span></p>
                            </div>
                        </div>
                    </div>

                    @if($produk->stok > 0)
                    <form action="/cart/add" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $produk->id }}">
                        <div class="w-full sm:w-32 relative">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Kuantitas</label>
                            <input type="number" name="qty" value="1" min="1" max="{{ $produk->stok }}"
                                class="w-full px-4 py-3.5 bg-white border border-gray-200 rounded-xl text-gray-900 text-center font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-shadow">
                        </div>
                        <div class="w-full sm:flex-1 mt-1 sm:mt-[22px]">
                            <button type="submit" class="w-full h-[52px] bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 active:scale-[0.98] flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Masukkan ke Keranjang
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="w-full p-4 bg-red-50 border border-red-100 rounded-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-red-700 font-semibold">Maaf, produk ini sedang kehabisan stok.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
