<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsPost extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'post_id',
        'views_count',
        'unique_visitors',
        'shares_count',
        'average_read_time',
    ];

    /**
     * Relasi ke model Post
     * Satu data analitik dimiliki oleh satu post (One-to-One atau Many-to-One)
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
