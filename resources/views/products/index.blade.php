@include('layouts.header')

<div class="container">

<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Tambah Produk</a>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!--  Sort & Search -->
<div class="d-flex justify-content-between align-items-center mb-4">
  
  <!--  Sort (kiri) -->
  <form method="GET" action="{{ route('products.index') }}" class="d-flex align-items-center" style="gap:10px;">
    <label for="sort" class="fw-bold me-2">Urutkan:</label>
    <select name="sort" id="sort" class="form-select" onchange="this.form.submit()" style="width:200px;">
      <option value="">Pilih...</option>
        <option value="id_asc" {{ $sort=='id_asc'?'selected':'' }}>ID Terkecil</option>
        <option value="id_desc" {{ $sort=='id_desc'?'selected':'' }}>ID Terbesar</option>
        <option value="nama_asc" {{ $sort=='nama_asc'?'selected':'' }}>Nama A–Z</option>
        <option value="nama_desc" {{ $sort=='nama_desc'?'selected':'' }}>Nama Z–A</option>
        <option value="harga_asc" {{ $sort=='harga_asc'?'selected':'' }}>Harga Termurah</option>
        <option value="harga_desc" {{ $sort=='harga_desc'?'selected':'' }}>Harga Termahal</option>
    </select>
  </form>

  <!--  Search (kanan) -->
  <form method="GET" action="{{ route('products.index') }}" class="d-flex align-items-center" style="gap:10px; width:420px;">
    <input type="text" 
           name="search" 
           value="{{ $search }}" 
           class="form-control" 
           placeholder="Cari produk berdasarkan nama...">
    <button type="submit" class="btn btn-primary px-4">Cari</button>
  </form>

</div>

<!--  Table Produk -->
<div class="table-container">
  <table class="table table-bordered bg-white">
    <thead class="table-light">
      <tr class="text-center">
        <th>ID</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Stock</th>
        <th>Foto</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $product)
        <tr class="align-middle text-center">
          <td>{{ $product->id }}</td>
          <td>{{ $product->nama }}</td>
          <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
          <td>{{ $product->quantity }}</td>
          <td>
            <span class="{{ $product->stock == 'Kosong' ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
              {{ $product->stock }}
            </span>
          </td>
          <td>
            @if($product->foto)
              <img src="{{ asset('storage/' . $product->foto) }}" 
                  alt="{{ $product->nama }}" 
                  class="img-thumbnail mx-auto d-block"
                  style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
            @else
              <span class="text-muted">Tidak ada foto</span>
            @endif
          </td>
          <td>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-muted py-3">Tidak ada produk ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!--  Pagination -->
<div class="mt-3 d-flex justify-content-center">
  {{ $products->links('pagination::bootstrap-5') }}
</div>
</div>
@include('layouts.footer')
