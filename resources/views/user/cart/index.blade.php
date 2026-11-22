<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keranjang | SELUNÉ</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    @include('user.partials.header')


    {{-- NAVBAR USER --}}
    @if (Auth::check() && Auth::user()->role === 'pembeli')

        @include('user.partials.navbar')

    @elseif (!Auth::check())

        <nav class="user-navbar">

            <a href="{{ route('user.products.index') }}">
                Katalog
            </a>

            <a href="{{ route('user.cart.index') }}" class="active">
                Keranjang
            </a>

            <a href="{{ route('login') }}">
                Login
            </a>

            <a href="{{ route('user.register') }}">
                Daftar
            </a>

        </nav>

    @else

        <nav class="user-navbar">

            <a href="{{ route('user.products.index') }}">
                Katalog
            </a>

            <a href="{{ route('user.cart.index') }}" class="active">
                Keranjang
            </a>

            <a href="{{ route('products.index') }}">
                Admin Panel
            </a>

        </nav>

    @endif


    {{-- KERANJANG --}}
    <main class="cart-container">

        <h2>Keranjang Belanja</h2>

        <p class="cart-subtitle">
            Periksa kembali produk pilihanmu
        </p>


        {{-- PESAN SUKSES --}}
        @if (session('success'))

            <div class="alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if (count($cart) > 0)

            <div class="cart-list">

                @foreach ($cart as $id => $item)

                    <div class="cart-item">

                        {{-- FOTO PRODUK --}}
                        @if ($item['gambar'])

                            <img
                                src="{{ asset('storage/' . $item['gambar']) }}"
                                alt="{{ $item['nama_produk'] }}"
                                class="cart-image"
                            >

                        @else

                            <div class="cart-no-image">
                                No Image
                            </div>

                        @endif


                        {{-- INFORMASI PRODUK --}}
                        <div class="cart-item-info">

                            <h3>{{ $item['nama_produk'] }}</h3>

                            <p>
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </p>

                            <span>
                                Jumlah: {{ $item['jumlah'] }}
                            </span>

                            <strong>
                                Subtotal:
                                Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                            </strong>


                            {{-- TOMBOL HAPUS --}}
                            <form
                                action="{{ route('user.cart.remove', $id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="cart-delete-btn">
                                    Hapus Produk
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- TOTAL BELANJA --}}
            <div class="cart-total">

                <span>Total Belanja</span>

                <h3>
                    Rp {{ number_format($total, 0, ',', '.') }}
                </h3>

            </div>


            {{-- CHECKOUT --}}
            <a href="{{ route('user.checkout.index') }}"
               class="checkout-btn">
                Lanjut Checkout →
            </a>


        @else

            {{-- KERANJANG KOSONG --}}
            <div class="cart-empty">

                <h3>Keranjangmu masih kosong 🛒</h3>

                <p>Yuk, temukan produk favoritmu!</p>

                <a href="{{ route('user.products.index') }}"
                   class="catalog-detail-btn">
                    Lihat Katalog
                </a>

            </div>

        @endif

    </main>

</div>

</body>
</html>