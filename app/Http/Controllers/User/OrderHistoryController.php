<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    // MENAMPILKAN RIWAYAT PESANAN USER
    public function index()
    {
        $orders = Order::with('orderDetails.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }
}