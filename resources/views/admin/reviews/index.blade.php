<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Review - Seluné</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        @include('admin.partials.navbar')

        @include('admin.partials.header')

        <section class="review-section">

            <h2>Daftar Review</h2>

            @forelse ($reviews as $review)

                <article class="review-card">

                    <div class="review-header">
                        <div>
                            <h3>
                                {{ $review->user->name ?? 'Pelanggan' }}
                            </h3>

                            <p>
                                Produk:
                                {{ $review->product->nama_produk ?? 'Produk tidak ditemukan' }}
                            </p>
                        </div>

                        <span class="review-rating">
                            {{ $review->rating }}/5 ★
                        </span>
                    </div>

                    <div class="review-comment">
                        {{ $review->komentar ?? 'Tidak ada komentar.' }}
                    </div>

                    <p class="review-date">
                        {{ $review->created_at->format('d/m/Y H:i') }}
                    </p>

                </article>

            @empty

                <p class="empty-message">
                    Belum ada review dari pelanggan.
                </p>

            @endforelse

            <div class="pagination">
                {{ $reviews->links() }}
            </div>

        </section>

    </div>

</body>
</html>
