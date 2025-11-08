<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel 
    protected $table = 'products';

    // Kolom yang bisa diisi 
    protected $fillable = [
        'nama',
        'harga',
        'quantity',
        'stock',
        'foto',
    ];
}
