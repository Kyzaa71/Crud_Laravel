@include('layouts.header')

<div class="container mt-4">
  <div class="card border-0">
    <div class="card-body">
      <h4 class="mb-4 fw-semibold">
        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
      </h4>

      <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-3">
          <div class="col-md-6">
            <label for="nama" class="form-label fw-bold">Nama Produk</label>
            <input  type="text" 
                    name="nama" 
                    id="nama" 
                    class="form-control" 
                    placeholder="Masukkan nama produk" required>
          </div>

          <div class="col-md-6">
            <label for="harga" class="form-label fw-bold">Harga (Rp)</label>
            <input  type="number" 
                    name="harga" 
                    id="harga" 
                    class="form-control" 
                    placeholder="Masukkan harga" required>
          </div>

          <div class="col-md-6">
            <label for="quantity" class="form-label fw-bold">Jumlah Barang</label>
            <input  type="number" 
                    name="quantity" 
                    id="quantity" 
                    class="form-control" 
                    value="{{ old('quantity') }}" required min="0">
          </div>

          <div class="col-md-6">
            <label for="stock" class="form-label fw-bold">Status Stok</label>
            <select name="stock" id="stock" class="form-select" required>
              <option value="Tersedia">Tersedia</option>
              <option value="Kosong">Kosong</option>
            </select>
          </div>

          <div class="col-md-12">
            <label for="foto" class="form-label fw-bold">Foto Produk</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
            <small class="text-muted">Format gambar: JPG, PNG, maksimal 2MB</small>

            <!-- Preview Foto -->
            <div class="text-center mt-3" id="image-preview-container" style="display:none;">
              <img id="image-preview" class="img-thumbnail" style="width:120px; height:120px; object-fit:cover; border-radius:8px;">
              <p class="text-muted small mt-2 mb-0">Pratinjau Foto</p>
            </div>
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-save me-1"></i> Simpan
          </button>
          <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">
            <i class="bi bi-arrow-left me-1"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // 🔹 Preview Foto Otomatis
  function previewImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('image-preview-container');
    const preview = document.getElementById('image-preview');

    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        previewContainer.style.display = 'block';
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      previewContainer.style.display = 'none';
    }
  }
</script>

@include('layouts.footer')
