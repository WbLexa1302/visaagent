<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Menampilkan semua daftar artikel/berita yang sudah di-publish.
     * Route: /posts
     */
    public function index()
    {
        // Mengambil post yang berstatus published, diurutkan dari yang terbaru,
        // dan menggunakan pagination (10 artikel per halaman)
        $posts = Post::where('is_published', true)
                     ->latest()
                     ->paginate(10);

        // Mengarahkan ke file view: resources/views/posts/index.blade.php
        return view('posts.index', compact('posts'));
    }

    /**
     * Menampilkan detail artikel berita berdasarkan slug-nya.
     * Route: /posts/{slug}
     */
    public function show($slug)
    {
        // Cari post berdasarkan slug yang statusnya sudah di-publish
        // Serta ambil data layanan visa terkait secara dinamis
        $post = Post::with('products')
                    ->where('slug', $slug)
                    ->where('is_published', true)
                    ->firstOrFail();

        // Otomatis menaikkan jumlah viewer artikel saat halaman dibuka
        $post->increment('views');

        // Mengarahkan ke file view: resources/views/posts/show.blade.php
        return view('posts.show', compact('post'));
    }
}
