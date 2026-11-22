
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SELUNÉ</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="register-page">
    <div class="register-card">

        <div class="register-brand">
            <h1>SELUNÉ</h1>
            <p>Your Favorite Collection</p>
        </div>

        <h2>Buat Akun</h2>
        <p class="register-subtitle">
            Daftar untuk mulai berbelanja
        </p>

        @if ($errors->any())
            <div class="register-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('user.register.process') }}" method="POST">
            @csrf

            <div class="register-field">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Masukkan nama kamu"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="register-field">
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
            <div class="register-field">
                <label for="password">Password</label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
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

            <!-- KONFIRMASI PASSWORD -->
            <div class="register-field">
                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword('password_confirmation', this)"
                        aria-label="Lihat password"
                    >
                        👁
                    </button>
                </div>
            </div>

            <button type="submit" class="register-button">
                Daftar Sekarang
            </button>

        </form>

        <div class="register-login">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
        </div>

        <a href="{{ route('user.products.index') }}" class="register-back">
            ← Kembali ke Katalog
        </a>

    </div>
</div>

<!-- SCRIPT ICON MATA -->
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
