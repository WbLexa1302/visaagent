<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisaType;

class VisaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan perulangan untuk membuat 20 data dummy
        for ($i = 1; $i <= 20; $i++) {
            VisaType::create([
                'name' => 'Visa Kunjungan ' . $i,
                'price' => 2000000 + ($i * 100000), // Variasi harga
                'description' => 'Deskripsi untuk tipe visa ke-' . $i,
                'processing_time' => ($i + 2) . ' Hari Kerja'
            ]);
        }
    }
}
