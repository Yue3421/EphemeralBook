<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price_at_time',
        'subtotal'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_at_time' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    /**
     * Relasi ke transaksi
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi ke produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Nama produk (dengan fallback jika produk dihapus)
     */
    public function getProductNameAttribute()
    {
        return $this->product->name ?? 'Produk telah dihapus';
    }

    /**
     * Format subtotal ke Rupiah
     */
    public function getFormattedSubtotalAttribute()
    {
        if ($this->subtotal === null) {
            return 'Rp 0';
        }
        
        return 'Rp ' . number_format(floatval($this->subtotal), 0, ',', '.');
    }

    /**
     * Format harga saat transaksi ke Rupiah
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->price_at_time === null) {
            return 'Rp 0';
        }
        
        return 'Rp ' . number_format(floatval($this->price_at_time), 0, ',', '.');
    }
}