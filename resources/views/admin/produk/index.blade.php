@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Stats Cards --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Dashboard Admin</h1>
        <p class="text-gray-500 text-sm">Kelola produk game & Android Rentopia</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 card-hover shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProduk ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500">Total Produk</p>
                </div>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 card-hover shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalGame ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500">Kategori Game</p>
                </div>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 card-hover shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAndroid ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500">Kategori Android</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('admin.produk.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-80">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm shadow-sm">
            </div>
            <select name="kategori" onchange="this.form.submit()"
                class="w-full sm:w-40 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm appearance-none cursor-pointer shadow-sm">
                <option value="">Semua Kategori</option>
                <option value="game" {{ request('kategori') == 'game' ? 'selected' : '' }}>Game</option>
                <option value="android" {{ request('kategori') == 'android' ? 'selected' : '' }}>Android</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-200 transition">Cari</button>
        </form>
        <a href="{{ route('admin.produk.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 text-sm active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- Products Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga Sewa</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($produks as $index => $produk)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ $produks->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" alt="{{ $produk->nama_produk }}">
                                @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $produk->nama_produk }}</p>
                                    <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $produk->deskripsi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1.5 rounded-md text-xs font-semibold {{ $produk->kategori === 'game' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                                {{ ucfirst($produk->kategori) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($produk->harga_sewa, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1.5 rounded-md text-xs font-semibold {{ $produk->stok > 10 ? 'bg-green-50 text-green-700 border border-green-100' : ($produk->stok > 0 ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-red-50 text-red-700 border border-red-100') }}">
                                {{ $produk->stok }} item
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.produk.edit', $produk) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.produk.destroy', $produk) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <p class="text-gray-900 font-semibold mb-1">Belum ada produk</p>
                                <p class="text-gray-500 text-sm mb-4">Katalog produk Anda masih kosong saat ini.</p>
                                <a href="{{ route('admin.produk.create') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold transition">Tambah produk pertama →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($produks) && method_exists($produks, 'hasPages') && $produks->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $produks->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
