<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory; // <-- Menambahkan HasFactory dari kode pertama

    // Menggabungkan semua kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'visa_type_id',
        'process_type', // <-- Ditambahkan dari kode pertama
        'full_name',
        'email',
        'passport_number',
        'status'        // <-- Dipertahankan dari kode kedua
    ];

    // Dipertahankan dari kode kedua
    public function visaType()
    {
        return $this->belongsTo(VisaType::class);
    }
}
