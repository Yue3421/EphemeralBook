<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'size',
        'created_by'
    ];

    protected $casts = [
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke user pembuat backup
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Format ukuran file (bytes ke MB/GB)
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Nama file tanpa ekstensi
     */
    public function getFileNameOnlyAttribute()
    {
        return pathinfo($this->file_name, PATHINFO_FILENAME);
    }

    /**
     * Tanggal dibuat dalam format Indonesia
     */
    public function getCreatedAtIndoAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}