<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')
            ->with(['addresses' => function ($query) {
                $query->orderByDesc('is_default')->latest();
            }])
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
