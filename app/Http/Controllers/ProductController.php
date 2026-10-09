<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function show($category, $slug)
    {
        // Mencari produk berdasarkan nama (yang sudah di-slug)
        // Kita asumsikan kolom 'name' di database adalah acuan slug-nya
        $product = Product::all()->first(function ($p) use ($slug) {
            return \Illuminate\Support\Str::slug($p->name) === $slug;
        });

        if (!$product) {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}
