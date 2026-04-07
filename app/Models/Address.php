<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'label',
        'province',
        'city',
        'district',
        'postal_code',
        'address_line',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedAddressAttribute()
    {
        $parts = [
            $this->address_line,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code
        ];

        $address = implode(', ', array_filter($parts));

        return trim($address);
    }
}
