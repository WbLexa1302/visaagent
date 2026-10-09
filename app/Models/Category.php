<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Category extends Model implements Sitemapable
{
    protected $guarded = [];

    /**
     * Fungsi ini akan dipanggil otomatis oleh Spatie Sitemap
     */
    public function toSitemapTag(): Url|string|array
    {
        // Jika ini adalah Sub-Kategori (punya parent), rutenya adalah /visa/{type}/{category}
    if ($this->parent) {
        return Url::create(route('visa.subCategoryList', [
            'type' => $this->parent->slug, // Slug dari kategori induk (misal: single-entry)
            'category' => $this->slug       // Slug dari sub-kategori ini (misal: tourist-visa)
        ]))
        ->setLastModificationDate($this->updated_at)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.7);
    }

    // Jika ini adalah Kategori Induk Utama, rutenya adalah /visa/{type}
    return Url::create(route('visa.type', ['type' => $this->slug]))
        ->setLastModificationDate($this->updated_at)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8);
    }

    /**
     * Relasi ke Kategori Induknya (Parent)
     * Contoh: Tourist Visa -> parent-nya adalah Single Entry
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relasi ke Sub-Kategori di bawahnya (Children)
     * Contoh: Single Entry -> children-nya adalah Tourist Visa, Business Visa, dll.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relasi ke Produk
     * Karena produk sekarang ditempelkan di Sub-Kategori, fungsi ini akan
     * dipanggil oleh Sub-Kategori untuk menarik produk di bawahnya (e.g., C1 Tourist Visa).
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}