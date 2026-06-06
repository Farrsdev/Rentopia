<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use Illuminate\Console\Command;

class ExpireRentalsCommand extends Command
{
    protected $signature = 'rentals:expire';
    protected $description = 'Otomatis mengubah status peminjaman yang sudah melewati tanggal kembali menjadi Selesai';

    public function handle(): int
    {
        $expiredRentals = Peminjaman::where('status', 'Disetujui')
            ->where('tanggal_kembali', '<', now())
            ->with('details.produk')
            ->get();

        $count = 0;

        foreach ($expiredRentals as $peminjaman) {
            $peminjaman->update(['status' => 'Selesai']);

            // Kembalikan stok
            foreach ($peminjaman->details as $detail) {
                $detail->produk->increment('stok', $detail->qty);
            }

            $count++;
        }

        $this->info("Berhasil memproses {$count} peminjaman yang telah expired.");

        return Command::SUCCESS;
    }
}
