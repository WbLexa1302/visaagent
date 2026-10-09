<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Post extends Model implements Sitemapable
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'cover_image',
        'is_published',
        'views'
    ];

    /**
     * Fungsi ini akan dipanggil otomatis oleh Spatie Sitemap
     */
    public function toSitemapTag(): Url|string|array
    {
        if (!$this->is_published) {
        return [];
    }

    return Url::create(route('posts.show', $this->slug)) // Diubah ke posts.show sesuai web.php Anda
        ->setLastModificationDate($this->updated_at)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8);
    }

    /**
     * Daftarkan relasi Many-to-Many ke model Product
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'post_product');
    }
}