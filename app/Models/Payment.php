<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payment_method',
        'amount',
        'proof_url',
        'bank_name',
        'account_number',
        'account_name',
        'payment_date',
        'status',
        'confirmed_by',
        'confirmed_at',
        'notes',
        'submitted_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'confirmed_at' => 'datetime',
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
     * Relasi ke user yang konfirmasi
     */
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Relasi ke user yang submit
     */
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * Format amount ke Rupiah
     */
    public function getFormattedAmountAttribute()
    {
        if ($this->amount === null) {
            return 'Rp 0';
        }
        
        return 'Rp ' . number_format(floatval($this->amount), 0, ',', '.');
    }

    /**
     * Status dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'approved' => 'Diterima',
            'rejected' => 'Ditolak'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Metode pembayaran dalam bahasa Indonesia
     */
    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'cash' => 'Tunai'
        ];
        
        return $labels[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Scope untuk payment pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk payment approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Cek apakah payment sudah dikonfirmasi
     */
    public function isConfirmed()
    {
        return !is_null($this->confirmed_at);
    }
}