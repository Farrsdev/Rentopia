<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Cek dan update otomatis yang expired menjadi Selesai (Global)
        $expiredPeminjamans = Peminjaman::where('status', 'Disetujui')
            ->whereNotNull('tanggal_kembali')
            ->where('tanggal_kembali', '<', now())
            ->get();

        foreach ($expiredPeminjamans as $expired) {
            $expired->update(['status' => 'Selesai']);
        }

        $query = Peminjaman::with(['user', 'details.produk'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->paginate(10);

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::with('details.produk')->findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Peminjaman ini tidak dalam status menunggu.');
        }

        // Cek stok cukup
        foreach ($peminjaman->details as $detail) {
            if ($detail->produk->stok < $detail->qty) {
                return back()->with('error', "Stok {$detail->produk->nama_produk} tidak mencukupi (sisa: {$detail->produk->stok}, dibutuhkan: {$detail->qty}).");
            }
        }

        // Set tanggal dan kurangi stok
        $peminjaman->update([
            'status' => 'Disetujui',
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(7),
        ]);

        foreach ($peminjaman->details as $detail) {
            $detail->produk->decrement('stok', $detail->qty);
        }

        return back()->with('success', 'Peminjaman berhasil disetujui! Masa sewa 7 hari dimulai dari sekarang.');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Peminjaman ini tidak dalam status menunggu.');
        }

        $peminjaman->update(['status' => 'Ditolak']);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}
