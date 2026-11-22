<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Validasi review
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Cek apakah pembeli sudah membeli produk
        // dan status pesanan sudah selesai
        $pernahMembeli = DB::table('orders')
            ->join(
                'order_details',
                'orders.id',
                '=',
                'order_details.order_id'
            )
            ->where('orders.user_id', auth()->id())
            ->where('order_details.product_id', $product->id)
            ->where('orders.status', 'pembayaran_selesai')
            ->exists();

        if (!$pernahMembeli) {
            return back()->with(
                'error',
                'Kamu hanya bisa mereview produk yang sudah dibeli dan pesanan sudah selesai.'
            );
        }

        // Cek apakah sudah pernah memberikan review
        $reviewSudahAda = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        if ($reviewSudahAda) {
            return back()->with(
                'error',
                'Kamu sudah memberikan review untuk produk ini.'
            );
        }

        // Upload foto review jika ada
        $pathFoto = null;

        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')
                ->store('reviews', 'public');
        }

        // Simpan review ke database
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'foto' => $pathFoto,
        ]);

        return back()->with(
            'success',
            'Review berhasil dikirim. Terima kasih!'
        );
    }
}