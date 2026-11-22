
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Katalog Produk - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">

    <!-- HEADER -->
    @include('user.partials.header')


    <!-- NAVBAR PEMBELI LOGIN -->
    @if (Auth::check() && Auth::user()->role === 'pembeli')

        @include('user.partials.navbar')

    <!-- NAVBAR PENGUNJUNG -->
    @elseif (!Auth::check())

        <nav class="user-navbar">

            <a href="{{ route('user.products.index') }}" class="active">
                Katalog
            </a>

            <a href="{{ route('user.cart.index') }}">
                Keranjang
            </a>

            <a href="{{ route('login') }}">
                Login
            </a>

            <a href="{{ route('user.register') }}">
                Daftar
            </a>

        </nav>

    <!-- NAVBAR ADMIN -->
    @else

        <nav class="user-navbar">

            <a href="{{ route('user.products.index') }}">
                Katalog
            </a>

            <a href="{{ route('user.cart.index') }}">
                Keranjang
            </a>

            <a href="{{ route('products.index') }}">
                Admin Panel
            </a>

        </nav>

    @endif


    <!-- KATALOG -->
    <section class="catalog-section">

        <div class="catalog-heading">
            <h2>Our Collection</h2>
            <p>Temukan produk favoritmu di sini ♡</p>
        </div>

        @if ($products->count() > 0)

            <div class="catalog-grid">

                @foreach ($products as $product)

                    <div class="catalog-card">

                        @if ($product->gambar)

                            <img
                                src="{{ asset('storage/' . $product->gambar) }}"
                                alt="{{ $product->nama_produk }}"
                                class="catalog-image"
                            >

                        @else

                            <div class="catalog-no-image">
                                No Image
                            </div>

                        @endif

                        <div class="catalog-info">

                            <h3>{{ $product->nama_produk }}</h3>

                            <p class="catalog-description">
                                {{ $product->deskripsi }}
                            </p>

                            <p class="catalog-price">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>

                            <p class="catalog-stock">
                                Stok: {{ $product->stok }}
                            </p>

                            <span class="catalog-status">
                                {{ ucfirst($product->status) }}
                            </span>

                            <a href="{{ route('user.products.show', $product->id) }}"
                               class="catalog-detail-btn">
                                Lihat Detail
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="catalog-empty">
                <h3>Belum Ada Produk</h3>
                <p>Produk Seluné akan segera hadir. Tunggu ya! ♡</p>
            </div>

        @endif

    </section>

</div>

</body>
</html>
