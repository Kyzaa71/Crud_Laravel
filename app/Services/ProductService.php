<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Ambil semua produk dengan filter search, sort, dan pagination.
     */
    public function getAllProducts($search = null, $sort = null, $perPage = 10)
    {
        $query = Product::query();

        // 🔍 Search by name
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // 🔽 Sorting
        switch ($sort) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'id_desc':
                $query->orderBy('id', 'desc');
                break;
            case 'nama_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama', 'desc');
                break;
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
                break;
        }

        // 🔢 Pagination (10 data per halaman)
        return $query->paginate($perPage)->appends([
            'sort' => $sort,
            'search' => $search,
        ]);
    }
}
