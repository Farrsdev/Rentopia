<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'metode_pembayaran', 'bukti_transfer'])]
class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'datetime',
            'tanggal_kembali' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function isExpired(): bool
    {
        return $this->status === 'Disetujui' && now()->gt($this->tanggal_kembali);
    }

    public function isActive(): bool
    {
        return $this->status === 'Disetujui' && now()->lte($this->tanggal_kembali);
    }
}
