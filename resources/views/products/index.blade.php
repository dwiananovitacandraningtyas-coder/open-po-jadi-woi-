
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open PO - Daftar Produk</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        @include('admin.partials.navbar')

        @include('admin.partials.header')

        <!-- PESAN SUKSES -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM TAMBAH PRODUK -->
        <section class="form-section">

            <h2>Tambah Produk</h2>

            @if ($errors->any())
                <div class="alert-error">
                    <strong>Periksa kembali data kamu:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>

                    <input
                        type="text"
                        id="nama_produk"
                        name="nama_produk"
                        value="{{ old('nama_produk') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="3"
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>

                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            min="0"
                            step="0.01"
                            value="{{ old('harga') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok</label>

                        <input
                            type="number"
                            id="stok"
                            name="stok"
                            min="0"
                            value="{{ old('stok', 0) }}"
                            required
                        >
                    </div>

                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Produk</label>

                    <input
                        type="file"
                        id="gambar"
                        name="gambar"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small>
                        Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                    </small>
                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label for="tanggal_mulai_po">
                            Tanggal Mulai PO
                        </label>

                        <input
                            type="date"
                            id="tanggal_mulai_po"
                            name="tanggal_mulai_po"
                            value="{{ old('tanggal_mulai_po') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai_po">
                            Tanggal Selesai PO
                        </label>

                        <input
                            type="date"
                            id="tanggal_selesai_po"
                            name="tanggal_selesai_po"
                            value="{{ old('tanggal_selesai_po') }}"
                        >
                    </div>

                </div>

                <button type="submit" class="btn-submit">
                    + Tambah Produk
                </button>

            </form>

        </section>

        <!-- DAFTAR PRODUK -->
        <section class="product-section">

            <h2>Daftar Produk</h2>

            @if ($products->isEmpty())

                <p class="empty-message">
                    Belum ada produk.
                </p>

            @else

                <div class="product-grid">

                    @foreach ($products as $product)

                        <article class="product-card">

                            <!-- GAMBAR PRODUK -->
                            <div class="product-card-image">

                                @if ($product->gambar)

                                    <img
                                        src="{{ asset('storage/' . $product->gambar) }}"
                                        alt="{{ $product->nama_produk }}"
                                        class="product-image"
                                    >

                                @else

                                    <div class="product-placeholder"></div>

                                @endif

                            </div>

                            <!-- NAMA PRODUK -->
                            <h3>{{ $product->nama_produk }}</h3>

                            <!-- HARGA PRODUK -->
                            <p class="product-price">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>

                            <!-- TOMBOL AKSI -->
                            <div class="product-card-actions">

                                <a
                                    href="{{ route('products.edit', $product->id) }}"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </article>

                    @endforeach

                </div>

            @endif

        </section>

    </div>

</body>
</html>
