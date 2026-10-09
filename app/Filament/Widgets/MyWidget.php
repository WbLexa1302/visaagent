<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MyWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    // Tambahkan Polling agar widget refresh otomatis setiap 15 detik tanpa reload halaman
    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            // Statistik View/Trafik (Masih statis, tapi siap dihubungkan ke Analytics)
            Stat::make('Total Traffic (Visa Inquiries)', '2.4k')
                ->description('Pengunjung tertarik layanan Visa')
                ->descriptionIcon('heroicon-m-users')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

            // Statistik Post (Dinamis dari Database)
            Stat::make('Visa Blog Posts', Post::count())
                ->description('Artikel panduan visa terbit')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),

            // Statistik Produk (Dinamis dari Database)
            Stat::make('Total Visa Products', Product::count())
                ->description('Layanan visa aktif')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'),

            // Statistik View Spesifik
            // Note: Warna 'info' diganti ke 'gray' agar kompatibel jika theme belum di-custom
            Stat::make('Daily Page Views', '150')
                ->description('Rata-rata view per hari')
                ->descriptionIcon('heroicon-m-eye')
                ->chart([1, 5, 10, 20, 15, 25, 30])
                ->color('gray'),
        ];
    }
}
