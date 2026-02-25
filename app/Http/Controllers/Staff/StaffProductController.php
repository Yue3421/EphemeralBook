<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('staff.products.index', compact('products'));
    }

    public function create()
    {
        return view('staff.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'jenis'       => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['created_by'] = auth()->id();   // staff yang login

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Simpan ke storage/app/public/products
            $path = $image->storeAs('products', $filename, 'public');

            $data['image'] = $path;   // simpan path: products/1740572893_xxx.jpg
        }

        Product::create($data);

        return redirect()->route('staff.products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('staff.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}