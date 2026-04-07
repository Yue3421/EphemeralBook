<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalOrders = Transaction::count();
        $completedOrders = Transaction::where('status', 'completed')->count();
        $cancelledOrders = Transaction::where('status', 'cancelled')->count();

        return view('admin.dashboard', compact(
            'user',
            'totalOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }
}
