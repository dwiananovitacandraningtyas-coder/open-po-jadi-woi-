
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Produk - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        @include('user.partials.header')

        <section class="detail-section">

            <a href="{{ route('user.products.index') }}"
               class="detail-back">
                ← Kembali ke Katalog
            </a>

            <div class="detail-card">

                <div class="detail-image-wrapper">

                    @if ($product->gambar)
                        <img
                            src="{{ asset('storage/' . $product->gambar) }}"
                            alt="{{ $product->nama_produk }}"
                            class="detail-image"
                        >
                    @else
                        <div class="detail-no-image">
                            No Image
                        </div>
                    @endif

                </div>

                <div class="detail-info">

                    <p class="detail-label">SELUNÉ COLLECTION</p>

                    <h2>{{ $product->nama_produk }}</h2>

                    <p class="detail-price">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>

                    <div class="detail-divider"></div>

                    <h3>Deskripsi Produk</h3>

                    <p class="detail-description">
                        {{ $product->deskripsi ?: 'Belum ada deskripsi produk.' }}
                    </p>

                    <p class="detail-stock">
                        Stok tersedia: {{ $product->stok }}
                    </p>

                    <form
                        action="{{ route('user.cart.add', $product->id) }}"
                        method="POST"
                        class="detail-cart-form"
                    >
                        @csrf

                        <button type="submit" class="detail-cart-btn"
                            {{ $product->stok < 1 ? 'disabled' : '' }}>
                            {{ $product->stok < 1 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                        </button>
                    </form>

                    <p class="detail-period">
                        Mulai PO:
                        {{ $product->tanggal_mulai_po ?? '-' }}
                    </p>

                    <p class="detail-period">
                        Akhir PO:
                        {{ $product->tanggal_selesai_po ?? '-' }}
                    </p>

                </div>

            </div>


            {{-- BAGIAN REVIEW --}}

            <section class="review-section">

                <div class="review-heading">
                    <h2>Review Pembeli</h2>

                    <div class="review-summary">
                        <span class="review-average">
                            ⭐ {{ number_format($rataRating, 1) }}
                        </span>

                        <span>
                            ({{ $jumlahReview }} review)
                        </span>
                    </div>
                </div>


                {{-- PESAN SUKSES --}}

                @if (session('success'))
                    <div class="review-success">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- PESAN ERROR --}}

                @if (session('error'))
                    <div class="review-error">
                        {{ session('error') }}
                    </div>
                @endif


                {{-- ERROR VALIDASI --}}

                @if ($errors->any())
                    <div class="review-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- FORM REVIEW PEMBELI --}}

                @auth

                    @if (auth()->user()->role === 'pembeli')

                        <div class="review-form-card">

                            <h3>Berikan Review Kamu</h3>

                            <p class="review-form-description">
                                Bagikan pengalamanmu setelah membeli produk ini.
                            </p>

                            <form
                                action="{{ route('user.reviews.store', $product->id) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="review-form"
                            >
                                @csrf

                                {{-- RATING --}}

                                <div class="review-form-group">

                                    <label class="review-label">
                                        Rating Produk
                                    </label>

                                    <div class="rating-input">

                                        @foreach ([5, 4, 3, 2, 1] as $bintang)

                                            <label class="rating-option">

                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="{{ $bintang }}"
                                                    {{ old('rating') == $bintang ? 'checked' : '' }}
                                                    required
                                                >

                                                <span>
                                                    {{ $bintang }} ⭐
                                                </span>

                                            </label>

                                        @endforeach

                                    </div>

                                </div>


                                {{-- KOMENTAR --}}

                                <div class="review-form-group">

                                    <label for="komentar" class="review-label">
                                        Komentar
                                    </label>

                                    <textarea
                                        name="komentar"
                                        id="komentar"
                                        rows="4"
                                        maxlength="1000"
                                        placeholder="Ceritakan pengalamanmu membeli produk ini..."
                                        class="review-textarea"
                                    >{{ old('komentar') }}</textarea>

                                </div>


                                {{-- FOTO --}}

                                <div class="review-form-group">

                                    <label for="foto" class="review-label">
                                        Foto Produk (Opsional)
                                    </label>

                                    <input
                                        type="file"
                                        name="foto"
                                        id="foto"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="review-file-input"
                                    >

                                    <small>
                                        Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                                    </small>

                                </div>


                                <button type="submit" class="review-submit-btn">
                                    Kirim Review
                                </button>

                            </form>

                        </div>

                    @endif

                @else

                    <div class="review-login-message">
                        Silakan
                        <a href="{{ route('login') }}">login</a>
                        untuk memberikan review.
                    </div>

                @endauth


                {{-- DAFTAR REVIEW --}}

                <div class="review-list">

                    @forelse ($reviews as $review)

                        <div class="review-card">

                            <div class="review-card-header">

                                <div class="review-user">
                                    <strong>
                                        {{ $review->user->name ?? 'Pembeli' }}
                                    </strong>

                                    <span class="review-date">
                                        {{ $review->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="review-stars">
                                    {{ str_repeat('⭐', $review->rating) }}
                                </div>

                            </div>


                            {{-- KOMENTAR REVIEW --}}

                            @if ($review->komentar)
                                <p class="review-comment">
                                    {{ $review->komentar }}
                                </p>
                            @endif


                            {{-- FOTO REVIEW --}}

                            @if ($review->foto)

                                <div class="review-photo-wrapper">

                                    <img
                                        src="{{ asset('storage/' . $review->foto) }}"
                                        alt="Foto review {{ $product->nama_produk }}"
                                        class="review-photo"
                                    >

                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="review-empty">
                            <p>Belum ada review untuk produk ini.</p>
                            <p>Jadilah pembeli pertama yang memberikan review! ✨</p>
                        </div>

                    @endforelse

                </div>

            </section>

        </section>

    </div>

</body>
</html>
