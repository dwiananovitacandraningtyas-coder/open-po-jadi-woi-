<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Terima Orderan - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        @include('admin.partials.navbar')

        @include('admin.partials.header')

        <section class="payment-section">

            <h2>Terima Orderan</h2>

            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($payments as $payment)

                <article class="payment-card">

                    <div class="payment-header">
                        <div>
                            <h3>
                                {{ $payment->order->kode_pesanan ?? 'Pesanan tidak ditemukan' }}
                            </h3>

                            <p>
                                Pembeli:
                                {{ $payment->order->user->name ?? '-' }}
                            </p>
                        </div>

                        <span class="payment-status">
                            {{ str_replace('_', ' ', ucfirst($payment->status)) }}
                        </span>
                    </div>

                    <div class="payment-info">
                        <p>
                            <strong>Metode Pembayaran:</strong>
                            {{ ucfirst($payment->metode_pembayaran) }}
                        </p>

                        <p>
                            <strong>Total Pesanan:</strong>
                            Rp {{ number_format($payment->order->total_harga ?? 0, 0, ',', '.') }}
                        </p>

                        <p>
                            <strong>Tanggal Bayar:</strong>
                            {{ $payment->tanggal_bayar
                                ? $payment->tanggal_bayar->format('d/m/Y H:i')
                                : '-' }}
                        </p>
                    </div>

                    <div class="payment-products">
                        <strong>Produk yang Dipesan:</strong>

                        @forelse ($payment->order->orderDetails ?? [] as $detail)
                            <p>
                                {{ $detail->product->nama_produk ?? 'Produk tidak ditemukan' }}
                                — {{ $detail->jumlah }} pcs
                            </p>
                        @empty
                            <p>Belum ada detail produk.</p>
                        @endforelse
                    </div>

                    <div class="payment-proof">
                        <strong>Bukti Pembayaran:</strong>

                        @if ($payment->bukti_pembayaran)
                            <a
                                href="{{ asset('storage/' . $payment->bukti_pembayaran) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Lihat Bukti Pembayaran
                            </a>
                        @else
                            <p>Belum ada bukti pembayaran.</p>
                        @endif
                    </div>

                    @if ($payment->status === 'menunggu_verifikasi')
                        <div class="payment-actions">

                            <form
                                action="{{ route('admin.payments.updateStatus', $payment->id) }}"
                                method="POST"
                                onsubmit="return confirm('Terima pembayaran ini?')"
                            >
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="status" value="diterima">

                                <button type="submit" class="btn-accept">
                                    Terima Pembayaran
                                </button>
                            </form>

                            <form
                                action="{{ route('admin.payments.updateStatus', $payment->id) }}"
                                method="POST"
                                onsubmit="return confirm('Tolak pembayaran ini?')"
                            >
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="status" value="ditolak">

                                <button type="submit" class="btn-reject">
                                    Tolak Pembayaran
                                </button>
                            </form>

                        </div>
                    @endif

                </article>

            @empty

                <p class="empty-message">
                    Belum ada pembayaran yang masuk.
                </p>

            @endforelse

            <div class="pagination">
                {{ $payments->links() }}
            </div>

        </section>

    </div>

</body>
</html>
