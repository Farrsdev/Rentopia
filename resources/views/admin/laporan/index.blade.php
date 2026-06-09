@extends('layouts.app')
@section('title', 'Laporan Penyewaan')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Laporan Penyewaan</h1>
        <p class="text-gray-500 text-sm">Histori transaksi dan statistik penyewaan</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500 mb-2">Total Transaksi</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalTransaksi ?? 0 }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500 mb-2">Disetujui (Aktif)</p>
            <p class="text-3xl font-bold text-emerald-600">{{ $totalDisetujui ?? 0 }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500 mb-2">Selesai</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalSelesai ?? 0 }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full blur-2xl"></div>
            <p class="text-sm font-medium text-gray-500 mb-2 relative z-10">Total Pendapatan</p>
            <p class="text-3xl font-bold text-blue-700 relative z-10">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 shadow-sm">
        <form method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Status Transaksi</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="flex-1 sm:flex-none px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm text-sm">Terapkan Filter</button>
                <a href="/admin/laporan" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-medium rounded-xl hover:bg-gray-200 transition text-sm">Reset</a>
                <a href="{{ route('admin.laporan.pdf', request()->all()) }}" target="_blank" class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-sm text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Cetak PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Informasi Pembeli</th>
                        <th class="px-6 py-4">Produk Disewa</th>
                        <th class="px-6 py-4">Tanggal Transaksi</th>
                        <th class="px-6 py-4">Total Harga</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $index => $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ $peminjamans->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $p->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $p->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <ul class="list-disc list-inside text-gray-700">
                            @foreach($p->details as $d)
                                <li>{{ $d->produk->nama_produk ?? '-' }} <span class="text-gray-400 font-medium">(x{{ $d->qty }})</span></li>
                            @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '-' }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($p->details->sum(fn($d) => $d->harga_sewa * $d->qty), 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $sc = [
                                    'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                    'Selesai' => 'bg-gray-100 text-gray-600 border-gray-200',
                                ];
                            @endphp
                            <span class="px-2.5 py-1.5 rounded-md text-xs font-semibold border {{ $sc[$p->status] ?? '' }}">{{ $p->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-gray-900 font-semibold mb-1">Belum ada data laporan</p>
                            <p class="text-gray-500 text-sm">Gunakan filter untuk mencari tanggal lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($peminjamans) && method_exists($peminjamans, 'hasPages') && $peminjamans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $peminjamans->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
