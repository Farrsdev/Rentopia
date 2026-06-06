<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Cek dan update otomatis yang expired menjadi Selesai
        $expiredPeminjamans = Peminjaman::where('user_id', auth()->id())
            ->where('status', 'Disetujui')
            ->whereNotNull('tanggal_kembali')
            ->where('tanggal_kembali', '<', now())
            ->get();

        foreach ($expiredPeminjamans as $expired) {
            $expired->update(['status' => 'Selesai']);
        }

        $peminjamans = Peminjaman::with(['details.produk'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pembeli.peminjaman.index', compact('peminjamans'));
    }
}
