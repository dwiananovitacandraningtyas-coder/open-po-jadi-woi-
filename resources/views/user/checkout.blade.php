<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | SELUNÉ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

@include('user.partials.header')

<main class="checkout-container">

    <a href="{{ route('user.cart.index') }}" class="detail-back">
        ← Kembali ke Keranjang
    </a>

    <h2>Checkout</h2>
    <p class="cart-subtitle">Lengkapi informasi pengiriman pesananmu</p>

    @if (session('success'))
    <div class="checkout-alert checkout-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="checkout-alert checkout-error">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="checkout-alert checkout-error">
        <strong>Periksa kembali data kamu ya:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="checkout-layout">

        <!-- FORM PENGIRIMAN -->
        <div class="checkout-form-card">

            <h3>Informasi Pengiriman</h3>

            <form action="{{ route('user.checkout.store') }}" method="POST">
                @csrf

                <div class="checkout-field">
                    <label for="nama_penerima">Nama Penerima</label>
                    <input
                        type="text"
                        id="nama_penerima"
                        name="nama_penerima"
                        placeholder="Masukkan nama penerima"
                        required
                    >
                </div>

                <div class="checkout-field">
                    <label for="no_hp">Nomor HP</label>
                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        placeholder="08xxxxxxxxxx"
                        required
                    >
                </div>

                <div class="checkout-field">
                    <label for="alamat_pengiriman">Alamat Lengkap</label>
                    <textarea
                        id="alamat_pengiriman"
                        name="alamat_pengiriman"
                        rows="4"
                        placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota..."
                        required
                    ></textarea>
                </div>

                <div class="checkout-field">
                    <label for="catatan">Catatan (Opsional)</label>
                    <textarea
                        id="catatan"
                        name="catatan"
                        rows="3"
                        placeholder="Catatan tambahan untuk pesanan..."
                    ></textarea>
                </div>

                <button type="submit" class="checkout-submit-btn">
                    Konfirmasi Pesanan
                </button>

            </form>

        </div>

        <!-- RINGKASAN PESANAN -->
        <div class="checkout-summary-card">

            <h3>Ringkasan Pesanan</h3>

            @foreach ($cart as $id => $item)

                <div class="checkout-product">

                    @if ($item['gambar'])
                        <img
                            src="{{ asset('storage/' . $item['gambar']) }}"
                            alt="{{ $item['nama_produk'] }}"
                        >
                    @else
                        <div class="checkout-no-image">
                            No Image
                        </div>
                    @endif

                    <div class="checkout-product-info">
                        <h4>{{ $item['nama_produk'] }}</h4>

                        <p>
                            {{ $item['jumlah'] }} ×
                            Rp{{ number_format($item['harga'], 0, ',', '.') }}
                        </p>

                        <strong>
                            Rp{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                        </strong>
                    </div>

                </div>

            @endforeach

            <div class="checkout-total">
                <span>Total Pembayaran</span>

                <strong>
                    Rp{{ number_format($total, 0, ',', '.') }}
                </strong>
            </div>

        </div>

    </div>

</main>

</body>
</html>
