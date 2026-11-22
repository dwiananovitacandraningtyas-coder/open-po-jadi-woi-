<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'order.user',
            'order.orderDetails.product'
        ])
        ->orderByDesc('created_at')
        ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        DB::transaction(function () use ($payment, $validated) {
            $payment->update([
                'status' => $validated['status'],
            ]);

            if ($payment->order) {
                $payment->order->update([
                    'status' => $validated['status'] === 'diterima'
                        ? 'diproses'
                        : 'menunggu_pembayaran',
                ]);
            }
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}
