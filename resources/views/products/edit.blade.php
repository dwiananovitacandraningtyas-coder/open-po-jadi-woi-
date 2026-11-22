
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Open PO</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">
        @include('admin.partials.header')

        <section class="form-section">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input
                        type="text"
                        id="nama_produk"
                        name="nama_produk"
                        value="{{ old('nama_produk', $product->nama_produk) }}"
                        required
                    >
                    @error('nama_produk')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="3"
                    >{{ old('deskripsi', $product->deskripsi) }}</textarea>
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
                            value="{{ old('harga', $product->harga) }}"
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
                            value="{{ old('stok', $product->stok) }}"
                            required
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_mulai_po">Tanggal Mulai PO</label>
                        <input
                            type="date"
                            id="tanggal_mulai_po"
                            name="tanggal_mulai_po"
                            value="{{ old('tanggal_mulai_po', $product->tanggal_mulai_po?->format('Y-m-d')) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai_po">Tanggal Selesai PO</label>
                        <input
                            type="date"
                            id="tanggal_selesai_po"
                            name="tanggal_selesai_po"
                            value="{{ old('tanggal_selesai_po', $product->tanggal_selesai_po?->format('Y-m-d')) }}"
                        >
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Simpan Perubahan
                </button>

                <a href="{{ route('products.index') }}" class="btn-batal">
                    Batal
                </a>
                
            </form>
        </section>
    </div>

</body>
</html>