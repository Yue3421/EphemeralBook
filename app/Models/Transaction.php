<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'user_id',
        'total_amount',
        'subtotal',
        'shipping_cost',
        'shipping_address',
        'shipping_courier',
        'notes',
        'status',
        'payment_status',
        'shipping_status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke detail transaksi
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Relasi ke pembayaran
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relasi ke pengiriman
     */
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    /**
     * Ambil pembayaran terakhir
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Format total ke Rupiah
     */
public function getFormattedTotalAttribute()
{
    if ($this->total_amount === null) {
        return 'Rp 0';
    }
    
    return 'Rp ' . number_format(floatval($this->total_amount), 0, ',', '.');
}

    /**
     * Cek apakah transaksi sudah lunas
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Cek apakah transaksi bisa dibatalkan
     */
    public function isCancellable()
    {
        return $this->status === 'pending' && $this->payment_status === 'unpaid';
    }

    /**
     * Status dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Status pembayaran dalam bahasa Indonesia
     */
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'unpaid' => 'Belum Dibayar',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan'
        ];
        
        return $labels[$this->payment_status] ?? $this->payment_status;
    }

    /**
     * Generate invoice code otomatis
     */
    public static function generateInvoiceCode()
    {
        $date = now()->format('Ymd');
        $lastTransaction = self::whereDate('created_at', today())->count();
        $number = str_pad($lastTransaction + 1, 4, '0', STR_PAD_LEFT);
        
        return 'INV/' . $date . '/' . $number;
    }
}