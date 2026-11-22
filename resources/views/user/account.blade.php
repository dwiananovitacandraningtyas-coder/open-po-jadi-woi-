<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Akun Saya - SELUNÉ</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="user-account-page">

    <div class="user-account-card">

        <!-- BRAND -->
        @include('user.partials.header')

        <!-- JUDUL -->
        <div class="user-account-heading">
            <div class="user-account-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <h2>Akun Saya</h2>
            <p>Selamat datang di SELUNÉ!</p>
        </div>

        <!-- INFORMASI AKUN -->
        <div class="user-account-info">

            <div class="user-account-info-item">
                <span>Nama Lengkap</span>
                <strong>{{ Auth::user()->name }}</strong>
            </div>

            <div class="user-account-info-item">
                <span>Email</span>
                <strong>{{ Auth::user()->email }}</strong>
            </div>

            <div class="user-account-info-item">
                <span>Status Akun</span>
                <strong class="user-account-status">Pembeli</strong>
            </div>

        </div>

        <!-- MENU -->
        <div class="user-account-menu">

            <a href="{{ route('user.products.index') }}"
               class="user-account-menu-button">
                🛍️ Kembali ke Katalog
            </a>

            <a href="{{ route('user.cart.index') }}"
               class="user-account-menu-button secondary">
                🛒 Lihat Keranjang
            </a>

        </div>

        <!-- LOGOUT -->
        <form action="{{ route('user.logout') }}" method="POST">
            @csrf

            <button type="submit" class="user-account-logout">
                Keluar dari Akun
            </button>
        </form>

    </div>

</div>

</body>
</html>
