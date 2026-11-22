<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'tanggal_mulai_po',
        'tanggal_selesai_po',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'tanggal_mulai_po' => 'date',
            'tanggal_selesai_po' => 'date',
        ];
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}