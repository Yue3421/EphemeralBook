<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan isi keranjang.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('customer.cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Tambah produk ke keranjang.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity jika sudah ada
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Cek stok lagi
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Total melebihi stok. Stok tersedia: ' . $product->stock);
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Buat baru jika belum ada
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        // Hitung total item di keranjang
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan ke keranjang',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Update quantity di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        // Pastikan keranjang milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Cek stok produk
        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Maksimal: ' . $cart->product->stock);
        }

        $cart->update(['quantity' => $request->quantity]);

        // Hitung ulang subtotal
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'message' => 'Keranjang berhasil diupdate',
            'subtotal' => $subtotal,
            'item_total' => $cart->product->price * $cart->quantity
        ]);
    }

    /**
     * Hapus item dari keranjang.
     */
    public function remove(Cart $cart)
    {
        // Pastikan keranjang milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Item berhasil dihapus dari keranjang',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Item berhasil dihapus dari keranjang');
    }

    /**
     * Kosongkan keranjang.
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Hitung total keranjang.
     */
    public function getCartTotal()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $count = $cartItems->sum('quantity');

        return response()->json([
            'total' => $total,
            'count' => $count,
            'items' => $cartItems->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity
                ];
            })
        ]);
    }
}