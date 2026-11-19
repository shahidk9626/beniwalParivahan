<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(Request $request): View
    {
        $vendors = User::where('role', User::ROLE_VENDOR)
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('phone', 'like', "%{$s}%")))
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create(): View
    {
        return view('admin.vendors.form', ['vendor' => new User()]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (User::where('role', User::ROLE_VENDOR)->count() >= 30) {
    return back()->withErrors(['email' => 'Vendor limit reached (30).'])->withInput();
}

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', Password::min(8)],
        ]);

        User::create($data + ['role' => User::ROLE_VENDOR, 'is_active' => true]);

        return redirect()->route('admin.vendors.index')->with('success', 'Became a vendor.');
    }

    public function edit(User $vendor): View
    {
        abort_unless($vendor->isVendor(), 404);

        return view('admin.vendors.form', compact('vendor'));
    }

    public function update(Request $request, User $vendor): RedirectResponse
    {
        abort_unless($vendor->isVendor(), 404);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($vendor->id)],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', Password::min(8)], // khaali chhodo to purana password rahega
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $vendor->update($data);

        return redirect()->route('admin.vendors.index')->with('success', 'The vendor has been updated.');
    }

    public function toggle(User $vendor): RedirectResponse
    {
        abort_unless($vendor->isVendor(), 404);

        $vendor->update(['is_active' => ! $vendor->is_active]);

        return back()->with('success', $vendor->is_active ? 'The vendor has been unblocked.' : 'The vendor has been blocked.');
    }

    public function destroy(User $vendor): RedirectResponse
    {
        abort_unless($vendor->isVendor(), 404);

        $vendor->delete();

        return back()->with('success', 'The vendor has been deleted.');
    }
}