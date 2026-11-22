<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <h1>SELUNÉ</h1>
            <p>Little things, made with love.</p>


            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Pesan Berhasil --}}
            @if (session('success'))
                <div class="login-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login.process') }}" method="POST">

                @csrf

                {{-- Email --}}
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                >

                {{-- Password --}}
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
                        onclick="togglePassword()"
                        aria-label="Lihat password"
                    >
                        <svg id="eye-icon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="21"
                            height="21"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                            <circle cx="12" cy="12" r="3"/>

                        </svg>
                    </button>

                </div>

                {{-- Tombol Login --}}
                <button type="submit" class="login-button">
                    LOGIN
                </button>

            </form>

            {{-- Daftar Pembeli --}}
            <div class="login-register">
                <p>Belum punya akun?</p>

                <a href="{{ route('user.register') }}">
                    Daftar sekarang
                </a>
            </div>

            {{-- Kembali ke Katalog --}}
            <a href="{{ route('user.products.index') }}" class="login-back">
                ← Kembali ke Katalog
            </a>

        </div>

    </div>

    {{-- JavaScript Icon Mata --}}
    <script>
        function togglePassword() {

            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const toggleButton = document.querySelector('.toggle-password');

            if (password.type === 'password') {

                password.type = 'text';

                eyeIcon.innerHTML = `
                    <path d="M3 3l18 18"/>
                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a15 15 0 0 1-4 4.5"/>
                    <path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7c1.4 0 2.7-.3 3.8-.8"/>
                `;

                toggleButton.setAttribute('aria-label', 'Sembunyikan password');

            } else {

                password.type = 'password';

                eyeIcon.innerHTML = `
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;

                toggleButton.setAttribute('aria-label', 'Lihat password');

            }
        }
    </script>

</body>
</html>