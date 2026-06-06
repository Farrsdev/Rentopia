@extends('layouts.app')
@section('title', 'Konfirmasi Peminjaman')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Konfirmasi Peminjaman</h1>
        <p class="text-gray-500 text-sm">Kelola persetujuan peminjaman dari pembeli</p>
    </div>

    {{-- Filter --}}
    <div class="mb-6">
        <form method="GET" class="flex items-center gap-3">
            <select name="status" onchange="this.form.submit()"
                class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 text-sm font-medium appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui (Aktif)</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($peminjamans as $peminjaman)
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-sm font-bold text-gray-600">#{{ $peminjaman->id }}</span>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $peminjaman->user->name }}</p>
                        <p class="text-xs font-medium text-gray-500">{{ $peminjaman->user->email }} • {{ $peminjaman->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @php
                        $statusColors = [
                            'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Ditolak' => 'bg-red-50 text-red-700 border-red-200',
                            'Selesai' => 'bg-gray-100 text-gray-600 border-gray-200',
                        ];
                    @endphp
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold border {{ $statusColors[$peminjaman->status] ?? '' }}">
                        {{ $peminjaman->status }}
                    </span>
                    @if($peminjaman->status === 'Menunggu')
                    <div class="flex items-center gap-2">
                        @if($peminjaman->bukti_transfer)
                        <a href="{{ asset('storage/' . $peminjaman->bukti_transfer) }}" target="_blank" class="px-4 py-1.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-xs font-bold hover:bg-blue-100 transition shadow-sm mr-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Bukti Transfer
                        </a>
                        @endif
                        <form action="/admin/peminjaman/{{ $peminjaman->id }}/approve" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Setujui peminjaman ini?')" class="px-4 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 transition shadow-sm">
                                ✓ Setujui
                            </button>
                        </form>
                        <form action="/admin/peminjaman/{{ $peminjaman->id }}/reject" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Tolak peminjaman ini?')" class="px-4 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-bold hover:bg-red-100 transition">
                                ✕ Tolak
                            </button>
                        </form>
                    </div>
                    @else
                        @if($peminjaman->bukti_transfer)
                        <a href="{{ asset('storage/' . $peminjaman->bukti_transfer) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">Lihat Bukti Pembayaran</a>
                        @endif
                    @endif
                </div>
            </div>

            @if($peminjaman->tanggal_pinjam)
            <div class="flex items-center gap-6 mb-5 px-4 py-3 bg-gray-50 rounded-xl text-sm border border-gray-100">
                <span class="text-gray-500 font-medium">Mulai: <span class="text-gray-900 font-semibold">{{ $peminjaman->tanggal_pinjam->format('d M Y, H:i') }}</span></span>
                <span class="text-gray-500 font-medium">Batas Kembali: <span class="text-gray-900 font-semibold">{{ $peminjaman->tanggal_kembali->format('d M Y, H:i') }}</span></span>
            </div>
            @endif

            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-gray-600">
                            <th class="text-left px-4 py-3 font-semibold">Produk</th>
                            <th class="text-center px-4 py-3 font-semibold">Qty</th>
                            <th class="text-right px-4 py-3 font-semibold">Harga</th>
                            <th class="text-right px-4 py-3 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($peminjaman->details as $detail)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $detail->produk->nama_produk ?? 'Produk dihapus' }}</td>
                            <td class="px-4 py-3 text-center text-gray-600">{{ $detail->qty }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">Rp {{ number_format($detail->harga_sewa, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp {{ number_format($detail->harga_sewa * $detail->qty, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-600">Total Pembayaran:</td>
                            <td class="px-4 py-3 text-right font-bold text-base text-blue-600">Rp {{ number_format($peminjaman->details->sum(fn($d) => $d->harga_sewa * $d->qty), 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Belum ada peminjaman</p>
            <p class="text-gray-500 text-sm">Transaksi baru akan muncul di sini.</p>
        </div>
        @endforelse
    </div>

    @if(isset($peminjamans) && method_exists($peminjamans, 'hasPages') && $peminjamans->hasPages())
    <div class="mt-8">{{ $peminjamans->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
