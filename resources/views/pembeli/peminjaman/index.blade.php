@extends('layouts.app')
@section('title', 'Penyewaan Saya')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-['Outfit'] text-gray-900 mb-2 tracking-tight">Penyewaan Saya</h1>
        <p class="text-gray-500">Pantau status transaksi Anda dan dapatkan akses eksklusif produk di sini.</p>
    </div>

    <div class="space-y-6">
        @forelse($peminjamans as $peminjaman)
        <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow animate-fade-in relative overflow-hidden">
            @if($peminjaman->status === 'Menunggu')
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
            @elseif($peminjaman->status === 'Disetujui' && $peminjaman->tanggal_kembali && now()->lte($peminjaman->tanggal_kembali))
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
            @endif

            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center">
                        <span class="text-sm font-bold text-gray-600">#{{ $peminjaman->id }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal Transaksi</p>
                        <p class="font-semibold text-gray-900">{{ $peminjaman->created_at->format('d F Y • H:i') }}</p>
                    </div>
                </div>
                @php
                    $sc = [
                        'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'Disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Ditolak' => 'bg-red-50 text-red-700 border-red-200',
                        'Selesai' => 'bg-gray-100 text-gray-600 border-gray-200',
                    ];
                @endphp
                <span class="px-4 py-2 rounded-xl text-sm font-bold border {{ $sc[$peminjaman->status] ?? '' }} shadow-sm">{{ $peminjaman->status }}</span>
            </div>

            @if($peminjaman->tanggal_pinjam && $peminjaman->status === 'Disetujui')
            <div class="flex flex-wrap items-center gap-6 mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <div>
                    <p class="text-xs text-gray-500 font-medium mb-1 uppercase tracking-wide">Mulai Sewa</p>
                    <p class="font-bold text-gray-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                </div>
                <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>
                <div>
                    <p class="text-xs text-gray-500 font-medium mb-1 uppercase tracking-wide">Batas Akhir</p>
                    <p class="font-bold text-gray-900">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</p>
                </div>
                
                @if(now()->lte($peminjaman->tanggal_kembali))
                <div class="ml-auto">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Sisa {{ now()->diffInDays($peminjaman->tanggal_kembali) }} Hari
                    </span>
                </div>
                @endif
            </div>
            @endif

            <div class="space-y-4">
                @foreach($peminjaman->details as $detail)
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-colors group">
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <div class="w-12 h-12 bg-white border border-gray-100 shadow-sm rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $detail->produk->nama_produk ?? 'Produk dihapus' }}</p>
                            <p class="text-sm font-medium text-gray-500">{{ $detail->qty }}x item — Rp {{ number_format($detail->harga_sewa * $detail->qty, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    {{-- Link Access Logic --}}
                    <div class="w-full sm:w-auto text-right sm:text-left mt-2 sm:mt-0">
                    @if($peminjaman->status === 'Disetujui' && $peminjaman->tanggal_kembali && now()->lte($peminjaman->tanggal_kembali))
                        <a href="{{ $detail->produk->link_akses ?? '#' }}" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Akses
                        </a>
                    @elseif($peminjaman->status === 'Disetujui' && $peminjaman->tanggal_kembali && now()->gt($peminjaman->tanggal_kembali))
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg text-xs font-bold">
                            🔒 Masa sewa habis
                        </span>
                    @elseif($peminjaman->status === 'Selesai')
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-600 border border-gray-200 rounded-lg text-xs font-bold">
                            ✓ Rental Selesai
                        </span>
                    @elseif($peminjaman->status === 'Menunggu')
                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg border border-amber-100">⏳ Sedang diverifikasi Admin</span>
                    @elseif($peminjaman->status === 'Ditolak')
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">✕ Permintaan ditolak</span>
                    @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                <p class="text-gray-500 font-medium">Total Pembayaran</p>
                <p class="text-xl font-extrabold text-blue-600">Rp {{ number_format($peminjaman->details->sum(fn($d) => $d->harga_sewa * $d->qty), 0, ',', '.') }}</p>
            </div>
        </div>
        @empty
        <div class="bg-white border border-gray-200 rounded-3xl p-16 text-center shadow-sm max-w-2xl mx-auto">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Riwayat Penyewaan Kosong</h2>
            <p class="text-gray-500 mb-8">Anda belum pernah melakukan penyewaan. Pesanan Anda akan muncul di halaman ini nantinya.</p>
            <a href="/katalog" class="inline-flex items-center gap-2 px-8 py-3.5 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20 active:scale-95">Mulai Eksplorasi Katalog</a>
        </div>
        @endforelse
    </div>

    @if(isset($peminjamans) && method_exists($peminjamans, 'hasPages') && $peminjamans->hasPages())
    <div class="mt-10">{{ $peminjamans->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
