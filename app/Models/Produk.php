<?php

namespace App\Models;

use Database\Factories\ProdukFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_produk', 'deskripsi', 'kategori', 'harga_sewa', 'stok', 'gambar', 'link_akses'])]
class Produk extends Model
{
    /** @use HasFactory<ProdukFactory> */
    use HasFactory;

    protected $table = 'produks';

    protected function casts(): array
    {
        return [
            'harga_sewa' => 'decimal:2',
            'stok' => 'integer',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function detailPeminjamans(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'product_id');
    }
}
