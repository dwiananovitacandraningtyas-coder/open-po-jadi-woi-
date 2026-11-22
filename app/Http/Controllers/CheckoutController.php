<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('user.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        // Validasi data pengiriman
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        DB::beginTransaction();

        try {
            $total = 0;

            // Hitung harga berdasarkan database
            foreach ($cart as $id => $item) {
                $product = DB::table('products')
                    ->where('id', $id)
                    ->first();

                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                $total += $product->harga * $item['jumlah'];
            }

            // Simpan pesanan
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => Auth::id(),
                'kode_pesanan' => 'PO-' . strtoupper(Str::random(8)),
                'tanggal_pesan' => now(),
                'total_harga' => $total,
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'catatan' => $request->catatan,
                'status' => 'menunggu_pembayaran',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan detail produk pesanan
            foreach ($cart as $id => $item) {
                $product = DB::table('products')
                    ->where('id', $id)
                    ->first();

                $harga = $product->harga;
                $jumlah = $item['jumlah'];
                $subtotal = $harga * $jumlah;

                DB::table('order_details')->insert([
                    'order_id' => $orderId,
                    'product_id' => $id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            // Kosongkan keranjang setelah berhasil
            session()->forget('cart');

            return redirect()->route('user.products.index')
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Pesanan gagal dibuat: ' . $e->getMessage());
        }
    }
}
