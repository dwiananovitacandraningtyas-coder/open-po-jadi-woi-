
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pesanan - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    @include('user.partials.header')

    {{-- NAVBAR USER --}}
    @include('user.partials.navbar')


    {{-- RIWAYAT PESANAN --}}
    <section class="user-orders-section">

        <div class="user-orders-heading">
            <h2>Riwayat Pesanan</h2>
            <p>Lihat semua pesanan yang pernah kamu buat.</p>
        </div>


        {{-- DAFTAR PESANAN --}}
        @forelse ($orders as $order)

            <div class="user-order-card">

                {{-- HEADER PESANAN --}}
                <div class="user-order-header">

                    <div>
                        <span class="user-order-label">
                            Tanggal Pesanan
                        </span>

                        <strong>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </strong>
                    </div>

                    {{-- STATUS --}}
                    <span class="user-order-status
                        {{ $order->status === 'selesai' ? 'status-selesai' : '' }}
                        {{ $order->status === 'pembayaran_selesai' ? 'status-dibayar' : '' }}
                    ">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>

                </div>


                {{-- PRODUK --}}
                <div class="user-order-products">

                    @foreach ($order->orderDetails as $detail)

                        @php
                            $hargaSatuan = $detail->harga_satuan
                                ?? $detail->harga
                                ?? 0;

                            $subtotal = $detail->subtotal
                                ?? ($hargaSatuan * $detail->jumlah);
                        @endphp

                        <div class="user-order-product">

                            {{-- FOTO --}}
                            <div class="user-order-product-image">

                                @if ($detail->product && $detail->product->gambar)

                                    <img
                                        src="{{ asset('storage/' . $detail->product->gambar) }}"
                                        alt="{{ $detail->product->nama_produk }}"
                                    >

                                @else

                                    <div class="user-order-no-image">
                                        No Image
                                    </div>

                                @endif

                            </div>


                            {{-- INFORMASI --}}
                            <div class="user-order-product-info">

                                <h3>
                                    {{ $detail->product->nama_produk ?? 'Produk telah dihapus' }}
                                </h3>

                                <p>
                                    Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                </p>

                                <span>
                                    Jumlah: {{ $detail->jumlah }}
                                </span>

                            </div>


                            {{-- SUBTOTAL --}}
                            <div class="user-order-subtotal">

                                Rp {{ number_format($subtotal, 0, ',', '.') }}

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- INFORMASI PENGIRIMAN --}}
                <div class="user-order-shipping">

                    <h4>Informasi Pengiriman</h4>

                    <p>
                        <strong>Penerima:</strong>
                        {{ $order->nama_penerima ?? '-' }}
                    </p>

                    <p>
                        <strong>No. HP:</strong>
                        {{ $order->no_hp ?? '-' }}
                    </p>

                    <p>
                        <strong>Alamat:</strong>
                        {{ $order->alamat_pengiriman ?? '-' }}
                    </p>

                </div>


                {{-- TOTAL PESANAN --}}
                <div class="user-order-footer">

                    <div>
                        <span>Total Pesanan</span>

                        <strong>
                            Rp {{ number_format($order->total_harga ?? $order->total ?? 0, 0, ',', '.') }}
                        </strong>
                    </div>

                </div>

            </div>

        @empty

            {{-- BELUM ADA PESANAN --}}
            <div class="user-orders-empty">

                <div class="user-orders-empty-icon">
                    🛍️
                </div>

                <h3>Belum Ada Pesanan</h3>

                <p>
                    Kamu belum memiliki pesanan.
                    Yuk, lihat katalog SELUNÉ!
                </p>

                <a
                    href="{{ route('user.products.index') }}"
                    class="user-orders-shop-btn"
                >
                    Lihat Katalog
                </a>

            </div>

        @endforelse


        {{-- PAGINATION --}}
        @if ($orders->hasPages())

            <div class="user-orders-pagination">
                {{ $orders->links() }}
            </div>

        @endif

    </section>

</div>

</body>
</html>
