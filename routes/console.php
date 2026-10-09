<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

// Command bawaan Laravel
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Command untuk membuat sitemap secara manual lewat terminal
Artisan::command('sitemap:generate', function () {
    $this->info('Sedang membuat sitemap Bali Ease...');

    Sitemap::create()
        // 1. Halaman Beranda / Home (/)
        ->add(Url::create(route('home'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0))

        // 2. Halaman Utama Katalog Visa (/visa)
        ->add(Url::create(route('visa.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.9))

        // 3. Halaman List Semua Artikel (/posts)
        ->add(Url::create(route('posts.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.8))

        // 4. Masukkan semua data dinamis dari database (Post, Product, Category)
        ->add(Post::all())
        ->add(Product::all())
        ->add(Category::all())
        
        // Simpan file hasil generate ke folder public/sitemap.xml
        ->writeToFile(public_path('sitemap.xml'));

    $this->info('Sitemap sukses dibuat di public/sitemap.xml!');
})->purpose('Generate the website sitemap automatically');


/*
|--------------------------------------------------------------------------
| Automated Schedules
|--------------------------------------------------------------------------
*/

// Sync otomatis dari Google Sheets setiap 30 menit
Schedule::command('sheets:sync')->everyThirtyMinutes();

// Jalankan pembuatan sitemap otomatis setiap hari jam 12 malam
Schedule::command('sitemap:generate')->daily();