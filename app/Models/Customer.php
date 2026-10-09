<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * Sesuaikan dengan kolom yang ada di migration tabel customers Anda.
     */
    protected $fillable = [
        'name',
        'email',
        'passport_number',
        'phone',
        'nationality',
    ];

    /**
     * Relasi ke model Order (One-to-Many)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
