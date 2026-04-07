<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return view('customer.address.index', compact('addresses'));
    }

    public function create()
    {
        $address = new Address();

        return view('customer.address.form', compact('address'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'label' => 'required|string|max:50',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'address_line' => 'required|string'
        ]);

        $validated['user_id'] = Auth::id();

        $hasDefault = Address::where('user_id', Auth::id())->where('is_default', true)->exists();
        if (!$hasDefault) {
            $validated['is_default'] = true;
        }

        Address::create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Alamat berhasil disimpan');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.address.form', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'label' => 'required|string|max:50',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'address_line' => 'required|string'
        ]);

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Alamat berhasil diperbarui');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        Address::where('user_id', Auth::id())->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')
            ->with('success', 'Alamat utama diperbarui');
    }
}
