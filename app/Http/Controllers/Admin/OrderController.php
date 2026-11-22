<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'user',
            'orderDetails.product'
        ])
        ->orderByDesc('tanggal_pesan')
        ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        // Jika pembayaran sudah dikonfirmasi
        if ($order->status == 'pembayaran_selesai') {
            return back()->with('error', 'Pembayaran pesanan ini sudah dikonfirmasi.');
        }

        // Ubah status pembayaran
        $order->status = 'pembayaran_selesai';
        $order->save();

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}