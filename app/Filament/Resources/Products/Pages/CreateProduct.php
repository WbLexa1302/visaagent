<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        $product = $this->record;

        // Ambil data sub-kategori (tourist-visa)
        $subCategory = $product->category;

        // Ambil data kategori utama (single-entry) via relasi parent
        $categoryUtama = $subCategory?->parent;

        if ($categoryUtama) {
            return url("/visa/{$categoryUtama->slug}/{$subCategory->slug}/{$product->slug}");
        }

        return $this->getResource()::getUrl('index');
    }
}
