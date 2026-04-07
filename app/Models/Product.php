<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'jenis',
        'isbn',
        'author',
        'publisher',
        'pages',
        'created_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',  // Ini sudah baik, tapi perlu dipastikan
        'stock' => 'integer',
        'pages' => 'integer'
    ];

    /**
     * Relasi ke user yang membuat produk
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke cart items
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relasi ke transaction details
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Format harga ke Rupiah - DIPERBAIKI
     */
    public function getFormattedPriceAttribute()
    {
        // Cek apakah price ada dan tidak null
        if ($this->price === null) {
            return 'Rp 0';
        }
        
        // Konversi ke float dulu
        $price = floatval($this->price);
        
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Format harga tanpa Rp (untuk keperluan lain)
     */
    public function getPriceNumberAttribute()
    {
        return $this->price ? floatval($this->price) : 0;
    }

    /**
     * Cek apakah stok tersedia
     */
    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    /**
     * Kurangi stok
     */
    public function decreaseStock($quantity)
    {
        $this->decrement('stock', $quantity);
    }

    /**
     * Tambah stok
     */
    public function increaseStock($quantity)
    {
        $this->increment('stock', $quantity);
    }
}
