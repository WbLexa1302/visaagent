<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Product extends Model implements Sitemapable
{
    // Mengizinkan semua kolom untuk diisi secara massal
    protected $guarded = [];

    /**
     * Cast attributes ke tipe data tertentu.
     *
     * Sangat penting untuk kolom 'services' agar otomatis
     * dikonversi dari JSON di database menjadi Array di PHP.
     */
    protected $casts = [
        'services' => 'array',
        'extension_price' => 'array',
    ];

    /**
     * Fungsi ini akan dipanggil otomatis oleh Spatie Sitemap
     */
    public function toSitemapTag(): Url|string|array
    {
        // Mengambil data sub-kategori dan kategori induknya untuk menyusun URL 4 tingkat
    $subCategory = $this->category;
    $parentCategory = $subCategory ? $subCategory->parent : null;

    // Pastikan relasinya ada agar tidak error saat generate
    if ($subCategory && $parentCategory) {
        return Url::create(route('visa.detail', [
            'type' => $parentCategory->slug,
            'category' => $subCategory->slug,
            'slug' => $this->slug
        ]))
        ->setLastModificationDate($this->updated_at)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.9);
    }

    return []; // Abaikan jika data relasi tidak lengkap
    }

    /**
     * Relasi balik ke Sub-Kategori (e.g., Tourist Visa, Business Visa)
     * Kolom 'category_id' di tabel products sekarang menyimpan ID dari Sub-Kategori tersebut.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}