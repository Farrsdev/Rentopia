<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'details.produk'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $peminjamans = $query->paginate(15);

        // Statistik
        $totalTransaksi = Peminjaman::count();
        $totalDisetujui = Peminjaman::where('status', 'Disetujui')->count();
        $totalSelesai = Peminjaman::where('status', 'Selesai')->count();
        $totalPendapatan = Peminjaman::whereIn('status', ['Disetujui', 'Selesai'])
            ->with('details')
            ->get()
            ->sum(function ($p) {
                return $p->details->sum(function ($d) {
                    return $d->harga_sewa * $d->qty;
                });
            });

        return view('admin.laporan.index', compact(
            'peminjamans', 'totalTransaksi', 'totalDisetujui', 'totalSelesai', 'totalPendapatan'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'details.produk'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $peminjamans = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact('peminjamans', 'request'));
        
        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }
}
