<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Order - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <!-- NAVBAR ADMIN -->
    <nav class="admin-navbar">

        <a href="{{ route('products.index') }}">
            Daftar Produk
        </a>

        <a href="{{ route('admin.orders.index') }}" class="active">
            Daftar Order
        </a>

        <a href="{{ route('admin.reviews.index') }}">
            Review
        </a>

        <a href="{{ route('admin.account.index') }}">
            Akun Admin
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="admin-nav-logout">
                Logout
            </button>
        </form>

    </nav>


    <!-- HEADER -->
    @include('admin.partials.header')


    <!-- DAFTAR ORDER -->
    <section class="order-section">

        <h2>Daftar Order</h2>

        <div class="order-table-wrapper">

            <table class="order-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Pesanan</th>
                        <th>Pembeli</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Konfirmasi Admin</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($orders as $order)

                        <tr>

                            <!-- NOMOR -->
                            <td>
                                {{ $orders->firstItem() + $loop->index }}
                            </td>

                            <!-- KODE PESANAN -->
                            <td>
                                <strong>
                                    {{ $order->kode_pesanan }}
                                </strong>
                            </td>

                            <!-- NAMA PEMBELI -->
                            <td>
                                {{ $order->user->name ?? 'Pengguna tidak ditemukan' }}
                            </td>

                            <!-- NOMOR HP -->
                            <td>
                                {{ $order->no_hp ?? '-' }}
                            </td>

                            <!-- ALAMAT -->
                            <td>
                                {{ $order->alamat_pengiriman ?? '-' }}
                            </td>

                            <!-- TANGGAL -->
                            <td>
                                {{ $order->tanggal_pesan
                                    ? $order->tanggal_pesan->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <!-- PRODUK -->
                            <td>

                                @forelse ($order->orderDetails as $detail)

                                    <div class="order-product">

                                        {{ $detail->product->nama_produk ?? 'Produk tidak ditemukan' }}

                                        <span>
                                            ({{ $detail->jumlah }} pcs)
                                        </span>

                                    </div>

                                @empty

                                    -

                                @endforelse

                            </td>

                            <!-- TOTAL HARGA -->
                            <td>
                                Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>

                            <!-- STATUS -->
                            <td>

                                @if ($order->status == 'menunggu_pembayaran')

                                    <span class="order-status status-pending">
                                        Menunggu Pembayaran
                                    </span>

                                @elseif ($order->status == 'pembayaran_selesai')

                                    <span class="order-status status-paid">
                                        Pembayaran Selesai
                                    </span>

                                @elseif ($order->status == 'selesai')

                                    <span class="order-status status-completed">
                                        Pesanan Selesai
                                    </span>

                                @else

                                    <span class="order-status">
                                        {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                    </span>

                                @endif

                            </td>


                            <!-- KONFIRMASI ADMIN -->
                            <td>

                                @if ($order->status == 'menunggu_pembayaran')

                                    <form
                                        action="{{ route('admin.orders.confirmPayment', $order->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin mengonfirmasi pembayaran pesanan ini?')"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="confirm-payment-btn">
                                            Konfirmasi Pembayaran
                                        </button>

                                    </form>

                                @elseif ($order->status == 'pembayaran_selesai' || $order->status == 'selesai')

                                    <span class="payment-confirmed">
                                        ✓ Sudah Dikonfirmasi
                                    </span>

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="empty-message">
                                Belum ada pesanan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->
        <div class="pagination">
            {{ $orders->links() }}
        </div>

    </section>

</div>

</body>
</html>