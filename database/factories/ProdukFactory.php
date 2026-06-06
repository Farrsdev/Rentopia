<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        $kategori = fake()->randomElement(['game', 'android']);
        $gameNames = ['Stardew Valley', 'Hollow Knight', 'Celeste', 'Hades', 'Among Us', 'Terraria', 'Minecraft', 'Cuphead', 'Ori and the Blind Forest', 'Dead Cells'];
        $androidNames = ['Nova Launcher Pro', 'Tasker', 'Solid Explorer', 'Poweramp', 'Sleep as Android', 'Moon+ Reader Pro', 'SD Maid Pro', 'Titanium Backup', 'Textra SMS', 'Weather Timeline'];

        return [
            'nama_produk' => $kategori === 'game' ? fake()->randomElement($gameNames) : fake()->randomElement($androidNames),
            'deskripsi' => fake()->paragraph(3),
            'kategori' => $kategori,
            'harga_sewa' => fake()->randomElement([5000, 10000, 15000, 20000, 25000, 30000, 50000]),
            'stok' => fake()->numberBetween(5, 50),
            'gambar' => null,
            'link_akses' => $kategori === 'game' ? 'https://github.com/' . fake()->userName() . '/' . fake()->slug(2) : 'https://itch.io/' . fake()->slug(2),
        ];
    }
}
