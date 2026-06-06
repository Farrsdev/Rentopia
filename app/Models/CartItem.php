<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cart_id', 'product_id', 'qty'])]
class CartItem extends Model
{
    protected function casts(): array
    {
        return [
            'qty' => 'integer',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
