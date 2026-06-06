<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produks = [
            [
                'nama_produk' => 'Stardew Valley',
                'deskripsi' => 'Game simulasi pertanian RPG open-ended. Kelola pertanian, beternak, memancing, dan berinteraksi dengan penduduk kota.',
                'kategori' => 'game',
                'harga_sewa' => 15000,
                'stok' => 20,
                'gambar' => null,
                'link_akses' => 'https://github.com/stardew-valley/release',
            ],
            [
                'nama_produk' => 'Hollow Knight',
                'deskripsi' => 'Game metroidvania dengan dunia bawah tanah yang luas. Jelajahi kerajaan serangga yang penuh misteri dan tantangan.',
                'kategori' => 'game',
                'harga_sewa' => 20000,
                'stok' => 15,
                'gambar' => null,
                'link_akses' => 'https://github.com/hollow-knight/release',
            ],
            [
                'nama_produk' => 'Celeste',
                'deskripsi' => 'Platformer presisi tinggi dengan cerita emosional. Bantu Madeline mendaki Gunung Celeste.',
                'kategori' => 'game',
                'harga_sewa' => 12000,
                'stok' => 25,
                'gambar' => null,
                'link_akses' => 'https://github.com/celeste-game/release',
            ],
            [
                'nama_produk' => 'Hades',
                'deskripsi' => 'Roguelike dungeon crawler dari Supergiant Games. Melarikan diri dari dunia bawah sebagai putra Hades.',
                'kategori' => 'game',
                'harga_sewa' => 25000,
                'stok' => 10,
                'gambar' => null,
                'link_akses' => 'https://github.com/hades-game/release',
            ],
            [
                'nama_produk' => 'Among Us',
                'deskripsi' => 'Game multiplayer sosial deduction. Temukan impostor di antara kru kapal luar angkasa.',
                'kategori' => 'game',
                'harga_sewa' => 8000,
                'stok' => 30,
                'gambar' => null,
                'link_akses' => 'https://github.com/among-us/release',
            ],
            [
                'nama_produk' => 'Nova Launcher Pro',
                'deskripsi' => 'Launcher Android premium dengan kustomisasi penuh. Ganti tampilan home screen, ikon, dan animasi.',
                'kategori' => 'android',
                'harga_sewa' => 10000,
                'stok' => 40,
                'gambar' => null,
                'link_akses' => 'https://github.com/nova-launcher/pro-release',
            ],
            [
                'nama_produk' => 'Tasker',
                'deskripsi' => 'Aplikasi automasi Android terlengkap. Buat otomasi berdasarkan lokasi, waktu, event, dan banyak lagi.',
                'kategori' => 'android',
                'harga_sewa' => 15000,
                'stok' => 20,
                'gambar' => null,
                'link_akses' => 'https://github.com/tasker-app/release',
            ],
            [
                'nama_produk' => 'Solid Explorer Pro',
                'deskripsi' => 'File manager Android terbaik dengan dual-pane. Akses cloud storage, FTP, dan root file system.',
                'kategori' => 'android',
                'harga_sewa' => 8000,
                'stok' => 35,
                'gambar' => null,
                'link_akses' => 'https://github.com/solid-explorer/release',
            ],
            [
                'nama_produk' => 'Poweramp Full',
                'deskripsi' => 'Music player Android dengan kualitas audio terbaik. Dukungan hi-res audio dan equalizer 10-band.',
                'kategori' => 'android',
                'harga_sewa' => 12000,
                'stok' => 25,
                'gambar' => null,
                'link_akses' => 'https://github.com/poweramp/release',
            ],
            [
                'nama_produk' => 'Sleep as Android',
                'deskripsi' => 'Aplikasi sleep tracker canggih dengan smart alarm. Pantau siklus tidur dan analisis kualitas tidur.',
                'kategori' => 'android',
                'harga_sewa' => 10000,
                'stok' => 30,
                'gambar' => null,
                'link_akses' => 'https://github.com/sleep-android/release',
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}
