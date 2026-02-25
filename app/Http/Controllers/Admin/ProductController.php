<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk logging

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur pencarian
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter stok
        if ($request->has('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('stock', '<', 10);
            } elseif ($request->stock_status === 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->latest()->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($products);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show form untuk tambah produk.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store produk baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isbn' => 'nullable|string|unique:products,isbn',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'pages' => 'nullable|integer|min:1'
        ]);

        $data = $request->except('image');

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }

        $data['created_by'] = auth()->id();

        Product::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $data
            ], 201);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display produk tertentu.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show form edit produk.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isbn' => 'nullable|string|unique:products,isbn,' . $product->id,
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'pages' => 'nullable|integer|min:1'
        ]);

        $data = $request->except('image');

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }

        $product->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'data' => $product
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        // Hapus image jika ada
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Update stok produk.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $oldStock = $product->stock;
        $product->update(['stock' => $request->stock]);

        // Log sederhana ke file Laravel (optional)
        Log::info('Stock updated', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'old_stock' => $oldStock,
            'new_stock' => $request->stock,
            'updated_by' => auth()->id(),
            'notes' => $request->notes
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Stok berhasil diupdate',
                'data' => [
                    'old_stock' => $oldStock,
                    'new_stock' => $request->stock,
                    'product' => $product
                ]
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Stok produk berhasil diupdate dari ' . $oldStock . ' menjadi ' . $request->stock);
    }

    /**
     * Bulk delete produk.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => count($request->ids) . ' produk berhasil dihapus'
        ]);
    }

    /**
     * Export produk ke CSV/Excel.
     */
    public function export()
    {
        $products = Product::all();
        
        $csvFileName = 'products_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"'
        ];

        return response()->stream(
            function() use ($products) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Nama', 'ISBN', 'Penulis', 'Harga', 'Stok', 'Dibuat']);

                foreach ($products as $product) {
                    fputcsv($handle, [
                        $product->id,
                        $product->name,
                        $product->isbn,
                        $product->author,
                        $product->price,
                        $product->stock,
                        $product->created_at->format('Y-m-d')
                    ]);
                }

                fclose($handle);
            },
            200,
            $headers
        );
    }
}
