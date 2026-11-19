<?php

use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Vendor\BorderTaxEntryController;

// Website open hote hi vendor login page
Route::middleware('guest')->get('/', [AuthenticatedSessionController::class, 'create']);

// Role ke hisaab se sahi dashboard par bhejta hai
Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->isSuperAdmin() ? 'admin.dashboard' : 'vendor.dashboard');
})->middleware('auth')->name('dashboard');

// Vendor area
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::view('/dashboard', 'vendor.dashboard')->name('dashboard');

    Route::get('/entries/create', [BorderTaxEntryController::class, 'create'])->name('entries.create');
    Route::get('/entries/lookup', [BorderTaxEntryController::class, 'lookup'])->name('entries.lookup');
    Route::post('/entries', [BorderTaxEntryController::class, 'store'])->name('entries.store');
});

// Super Admin area
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'total'   => User::where('role', User::ROLE_VENDOR)->count(),
            'active'  => User::where('role', User::ROLE_VENDOR)->where('is_active', true)->count(),
            'blocked' => User::where('role', User::ROLE_VENDOR)->where('is_active', false)->count(),
        ]);
    })->name('dashboard');

    Route::resource('vendors', VendorController::class)->except('show');
    Route::patch('vendors/{vendor}/toggle', [VendorController::class, 'toggle'])->name('vendors.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';