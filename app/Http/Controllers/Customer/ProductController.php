<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk untuk customer.
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('stock', '>', 0)
            ->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('jenis', $request->category);
        }

        $products = $query->get();
        $categories = Product::whereNotNull('jenis')
            ->select('jenis')
            ->distinct()
            ->orderBy('jenis')
            ->pluck('jenis');

        return view('customer.products', compact('products', 'categories'));
    }

    /**
     * Detail produk.
     */
    public function show(Product $product)
    {
        return view('customer.product-detail', compact('product'));
    }
}
