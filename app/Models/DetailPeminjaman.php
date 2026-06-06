<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['peminjaman_id', 'product_id', 'harga_sewa', 'qty'])]
class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';

    protected function casts(): array
    {
        return [
            'harga_sewa' => 'decimal:2',
            'qty' => 'integer',
        ];
    }

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
