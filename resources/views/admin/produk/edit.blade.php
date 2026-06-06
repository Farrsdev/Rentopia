@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.produk.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold font-['Outfit'] text-gray-900">Edit Produk</h1>
        <p class="text-gray-500 mt-1 text-sm">Ubah data produk "{{ $produk->nama_produk }}"</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                    @error('nama_produk')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select id="kategori" name="kategori" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm appearance-none cursor-pointer">
                        <option value="game" {{ old('kategori', $produk->kategori) == 'game' ? 'selected' : '' }}>Game</option>
                        <option value="android" {{ old('kategori', $produk->kategori) == 'android' ? 'selected' : '' }}>Android</option>
                    </select>
                </div>
                <div>
                    <label for="harga_sewa" class="block text-sm font-semibold text-gray-700 mb-2">Harga Sewa (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="harga_sewa" name="harga_sewa" value="{{ old('harga_sewa', $produk->harga_sewa) }}" required min="0" step="100"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                </div>
                <div>
                    <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" required min="0"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                </div>
                <div>
                    <label for="link_akses" class="block text-sm font-semibold text-gray-700 mb-2">Link Akses (URL) <span class="text-red-500">*</span></label>
                    <input type="url" id="link_akses" name="link_akses" value="{{ old('link_akses', $produk->link_akses) }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm resize-none">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                    @if($produk->gambar)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-32 h-32 rounded-xl object-cover border border-gray-200 shadow-sm" alt="Current image">
                        <p class="text-xs text-gray-500 mt-2 font-medium">Gambar saat ini (upload baru untuk mengganti)</p>
                    </div>
                    @endif
                    <input type="file" id="gambar" name="gambar" accept="image/*"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold file:text-xs hover:file:bg-blue-100 file:cursor-pointer transition-all text-sm">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-6 mt-6 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 text-sm active:scale-95">Simpan Perubahan</button>
                <a href="{{ route('admin.produk.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
