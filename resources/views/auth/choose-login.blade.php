<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pilih Login | SELUNÉ</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <div class="choose-login-container">

        {{-- BRAND --}}
        <div class="choose-login-header">

            <h1>SELUNÉ</h1>

            <p>Little things, made with love.</p>

            <span>Selamat datang kembali ✨</span>

        </div>


        {{-- PILIH LOGIN --}}
        <div class="choose-login-card">

            <h2>Masuk sebagai</h2>


            {{-- LOGIN PEMBELI --}}
            <a href="{{ route('login') }}" class="choose-login-option">

                <div class="choose-login-icon">
                    🛍️
                </div>

                <div class="choose-login-info">

                    <h3>Login sebagai Pembeli</h3>

                    <p>
                        Belanja produk favorit dan cek pesananmu
                    </p>

                </div>

                <span class="choose-login-arrow">→</span>

            </a>


            {{-- LOGIN ADMIN --}}
            <a href="{{ route('login') }}" class="choose-login-option">

                <div class="choose-login-icon">
                    🔐
                </div>

                <div class="choose-login-info">

                    <h3>Login sebagai Admin</h3>

                    <p>
                        Kelola produk, pesanan, dan review
                    </p>

                </div>

                <span class="choose-login-arrow">→</span>

            </a>


            {{-- DAFTAR AKUN --}}
            <div class="choose-login-register">

                <p>Belum punya akun pembeli?</p>

                <a href="{{ route('user.register') }}">
                    Daftar sekarang
                </a>

            </div>


            {{-- KEMBALI --}}
            <a href="{{ route('home') }}" class="choose-login-back">
                ← Kembali ke Katalog
            </a>

        </div>

    </div>

</div>

</body>
</html>