<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ==========================================
    // MENAMPILKAN PRODUK ADMIN
    // ==========================================

    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }


    // ==========================================
    // MENAMPILKAN KATALOG USER
    // ==========================================

    public function catalog()
    {
        $products = Product::where('status', 'aktif')
            ->latest()
            ->get();

        return view('user.products.index', compact('products'));
    }


    // ==========================================
    // MENAMPILKAN DETAIL PRODUK + REVIEW
    // ==========================================

    public function show(Product $product)
    {
        $reviews = Review::with('user')
            ->where('product_id', $product->id)
            ->latest()
            ->get();

        $jumlahReview = $reviews->count();

        $rataRating = $jumlahReview > 0
            ? $reviews->avg('rating')
            : 0;

        return view('user.products.show', compact(
            'product',
            'reviews',
            'jumlahReview',
            'rataRating'
        ));
    }


    // ==========================================
    // MENAMBAHKAN PRODUK KE KERANJANG
    // ==========================================

    public function addToCart(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['jumlah']++;
        } else {
            $cart[$product->id] = [
                'nama_produk' => $product->nama_produk,
                'harga' => $product->harga,
                'gambar' => $product->gambar,
                'jumlah' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('user.products.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    // ==========================================
    // MENAMPILKAN HALAMAN KERANJANG
    // ==========================================

    public function cart()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('user.cart.index', compact('cart', 'total'));
    }


    // ==========================================
    // MENGHAPUS PRODUK DARI KERANJANG
    // ==========================================

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('user.cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang!');
    }


    // ==========================================
    // MENAMBAHKAN PRODUK BARU (ADMIN)
    // ==========================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal_mulai_po' => 'nullable|date',
            'tanggal_selesai_po' => 'nullable|date|after_or_equal:tanggal_mulai_po',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('products', 'public');
        }

        $validated['status'] = 'aktif';

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    // ==========================================
    // MENGEDIT PRODUK (ADMIN)
    // ==========================================

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }


    // ==========================================
    // MEMPERBARUI PRODUK (ADMIN)
    // ==========================================

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'tanggal_mulai_po' => 'nullable|date',
            'tanggal_selesai_po' => 'nullable|date|after_or_equal:tanggal_mulai_po',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    // ==========================================
    // MENGHAPUS PRODUK (ADMIN)
    // ==========================================

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}