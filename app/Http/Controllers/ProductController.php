<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // tampilkan semua data
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort   = $request->get('sort');

        $products = $this->productService->getAllProducts($search, $sort, 10);

        return view('products.index', compact('products', 'search', 'sort'));
    }
    // tampilkan form tambah
    public function create()
    {
        return view('products.create');
    }

    // simpan data baru
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'quantity' => 'required|integer|min:0',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    // Tentukan status stock otomatis
    $stockStatus = $request->quantity > 0 ? 'Tersedia' : 'Kosong';

    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('uploads', 'public');
    }

    Product::create([
        'nama' => $request->nama,
        'harga' => $request->harga,
        'quantity' => $request->quantity,
        'stock' => $stockStatus,
        'foto' => $fotoPath,
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
}

    // tampilkan form edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // update data
    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $product = Product::findOrFail($id);

    $stockStatus = $request->quantity > 0 ? 'Tersedia' : 'Kosong';

    $data = [
        'nama' => $request->nama,
        'harga' => $request->harga,
        'quantity' => $request->quantity,
        'stock' => $stockStatus,
    ];

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('uploads', 'public');
    }

    $product->update($data);

    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
}


    // hapus data
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->foto && file_exists(public_path('images/'.$product->foto))) {
            unlink(public_path('images/'.$product->foto));
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
