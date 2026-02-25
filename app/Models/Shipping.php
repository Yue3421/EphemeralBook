<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'address',
        'courier',
        'tracking_number',
        'shipped_by',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke transaksi
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi ke user yang mengirim
     */
    public function shippedBy()
    {
        return $this->belongsTo(User::class, 'shipped_by');
    }

    /**
     * Status pengiriman dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        if ($this->delivered_at) {
            return 'Telah Diterima';
        } elseif ($this->shipped_at) {
            return 'Dalam Pengiriman';
        } else {
            return 'Menunggu Dikirim';
        }
    }

    /**
     * Cek status pengiriman
     */
    public function isShipped()
    {
        return !is_null($this->shipped_at);
    }

    /**
     * Cek apakah sudah diterima
     */
    public function isDelivered()
    {
        return !is_null($this->delivered_at);
    }

    /**
     * Update status delivered
     */
    public function markAsDelivered()
    {
        $this->update([
            'delivered_at' => now()
        ]);
    }
}