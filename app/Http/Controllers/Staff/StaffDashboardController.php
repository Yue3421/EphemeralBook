<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;      // model buku kamu
use App\Models\Transaction;  // model transaksi kamu

class StaffDashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Product::count();
        $totalTransactions = Transaction::count();

        return view('staff.dashboard', compact('totalBooks', 'totalTransactions'));
    }

    /**
     * API untuk auto refresh card tanpa reload halaman
     */
    public function getCounts()
    {
        return response()->json([
            'totalBooks'       => Product::count(),
            'totalTransactions'=> Transaction::count(),
        ]);
    }
}