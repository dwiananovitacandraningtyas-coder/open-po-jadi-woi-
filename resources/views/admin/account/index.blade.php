
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Account Admin - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        @include('admin.partials.navbar')

        @include('admin.partials.header')

        <section class="account-section">

            <h2>Account Admin</h2>

            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form
                action="{{ route('admin.account.update') }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="account-form-group">
                    <label for="name">Nama Admin</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name ?? '') }}"
                        required
                    >
                    @error('name')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-form-group">
                    <label for="email">Email Admin</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email ?? '') }}"
                        required
                    >
                    @error('email')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-form-group">
                    <label for="password">Password Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin mengubah"
                    >
                    @error('password')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="account-form-group">
                    <label for="password_confirmation">
                        Konfirmasi Password Baru
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password baru"
                    >
                </div>

                <button type="submit" class="account-save-btn">
                    Simpan Perubahan
                </button>

            </form>

        </section>

    </div>

</body>
</html>
