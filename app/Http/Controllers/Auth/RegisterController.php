<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses register customer baru
     */
    public function register(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // PASTIKAN HASH
                'role' => 'customer',
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            // Login user setelah register
            Auth::login($user);

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard dengan pesan sukses
            return redirect()->route('customer.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);

        } catch (\Exception $e) {
            // Jika terjadi error
            return redirect()->back()
                ->with('error', 'Registrasi gagal: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Registrasi staff (khusus admin) - untuk API
     */
    public function registerStaff(Request $request)
    {
        // Cek apakah user adalah admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Hanya admin yang dapat menambah staff.'
            ], 403);
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat staff baru
            $staff = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'staff',
                'phone' => $request->phone
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Staff berhasil didaftarkan',
                'data' => [
                    'id' => $staff->id,
                    'name' => $staff->name,
                    'email' => $staff->email,
                    'role' => $staff->role,
                    'phone' => $staff->phone
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan staff: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cek email sudah terdaftar atau belum (untuk AJAX)
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
        ]);
    }
}