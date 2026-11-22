
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SELUNÉ</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="user-login-page">
    <div class="user-login-card">

        <!-- BRAND -->
        <div class="user-login-brand">
            <h1>SELUNÉ</h1>
            <p>Your Favorite Collection</p>
        </div>

        <!-- JUDUL -->
        <h2>Selamat Datang!</h2>
        <p class="user-login-subtitle">
            Login untuk melanjutkan belanja
        </p>

        <!-- PESAN ERROR -->
        @if ($errors->any())
            <div class="user-login-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form action="{{ route('user.login.process') }}" method="POST">
            @csrf

            <!-- EMAIL -->
            <div class="user-login-field">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email kamu"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <!-- PASSWORD -->
            <div class="user-login-field">
                <label for="password">Password</label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword('password', this)"
                        aria-label="Lihat password"
                    >
                        👁
                    </button>
                </div>
            </div>

            <!-- BUTTON LOGIN -->
            <button type="submit" class="user-login-button">
                Login
            </button>

        </form>

        <!-- LINK REGISTER -->
        <div class="user-login-register">
            Belum punya akun?
            <a href="{{ route('user.register') }}">
                Daftar sekarang
            </a>
        </div>

        <!-- KEMBALI -->
        <a href="{{ route('user.products.index') }}" class="user-login-back">
            ← Kembali ke Katalog
        </a>

    </div>
</div>

<!-- SCRIPT LIHAT PASSWORD -->
<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = '🙈';
            button.setAttribute('aria-label', 'Sembunyikan password');
        } else {
            input.type = 'password';
            button.textContent = '👁';
            button.setAttribute('aria-label', 'Lihat password');
        }
    }
</script>

</body>
</html>
