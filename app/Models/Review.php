<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'komentar',
        'foto',
    ];

    // Relasi ke pembeli
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}