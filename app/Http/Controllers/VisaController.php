<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class VisaController extends Controller
{
    /**
     * Halaman Pertama: Menampilkan halaman utama pilihan (Single Entry, Multiple Entry, KITAS)
     * URL: /visa
     */
    public function index()
    {
        // PENTING: Hanya ambil kategori utama (Single Entry, Multiple Entry, KITAS)
        // Gunakan eager loading 'children' agar query lebih efisien
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('visa.index', compact('categories'));
    }

    /**
     * Halaman Kedua (Sub-Kategori): Klik Single Entry -> Muncul Tourist, Business, dll
     * URL: /visa/single-entry
     */
    public function indexByType($type)
    {
        // 1. Format string: dari 'single-entry' menjadi 'single_entry'
        $formattedType = str_replace('-', '_', $type);

        // 2. Ambil kategori-kategori yang MEMILIKI produk dengan visa_type ini
        $categories = Category::whereHas('products', function($query) use ($formattedType) {
            $query->where('visa_type', $formattedType);
        })->get();

        // 3. Jika tidak ada kategori yang memiliki tipe visa ini
        if ($categories->isEmpty()) {
            abort(404, "Tipe visa $type tidak ditemukan atau belum memiliki produk.");
        }

        // 4. Kirim data ke view sub-kategori baru
        return view('visa.index_type', [
            'categories' => $categories,
            'type' => $type, // Digunakan untuk generate link di Blade: /visa/{{ $type }}/{{ $category->slug }}
            'typeName' => ucwords(str_replace('-', ' ', $type))
        ]);
    }

    /**
     * Halaman Ketiga (List Produk): Klik Tourist Visa -> Muncul C1 Tourist Visa, dll
     * URL: /visa/single-entry/tourist-visa
     */
    public function showProductsBySubCategory($type, $categorySlug)
    {
        // 1. Format string tipe visa untuk query database
        $formattedType = str_replace('-', '_', $type);

        // 2. Cari data kategori berdasarkan slug di URL
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        // 3. Ambil produk yang cocok dengan tipe visa DAN kategori_id-nya
        $products = Product::where('visa_type', $formattedType)
                            ->where('category_id', $category->id)
                            ->get();

        // 4. Kirim data ke view category (view list produk akhir)
        return view('visa.category', [
            'type' => $type, // Ditambahkan jika nanti butuh generate link balik ke halaman detail
            'category' => $category,
            'products' => $products,
            'typeName' => $category->name . ' (' . ucwords(str_replace('-', ' ', $type)) . ')'
        ]);
    }

    /**
     * Level 4: Menampilkan halaman detail produk akhir
     * URL: /visa/{type}/{categorySlug}/{productSlug}
     * Contoh: /visa/single-entry/tourist-visa/c1-tourist-visa
     */
    public function detail($type, $categorySlug, $productSlug)
    {
        // Cari produk berdasarkan slug-nya langsung menggunakan firstOrFail
        $product = Product::where('slug', $productSlug)->firstOrFail();

        // Mengarah ke file blade detail produk kamu (resources/views/visa/detail.blade.php)
        return view('visa.detail', compact('product', 'type', 'categorySlug'));
    }
}
