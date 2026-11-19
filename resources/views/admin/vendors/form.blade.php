@extends('layouts.portal')
@section('title', $vendor->exists ? 'Edit Vendor' : 'Add New Vendor')
@section('content')
    <div class="card" style="max-width:560px">
        <h2>{{ $vendor->exists ? 'Edit vendor details' : 'Create a vendor account' }}</h2>
        <p class="hint" style="margin-bottom:20px">The vendor will use this email and password to sign in.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <form method="POST"
              action="{{ $vendor->exists ? route('admin.vendors.update', $vendor) : route('admin.vendors.store') }}">
            @csrf
            @if ($vendor->exists) @method('PUT') @endif

            <div class="field">
                <label for="name">Full name</label>
                <input id="name" name="name" value="{{ old('name', $vendor->name) }}" required>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $vendor->email) }}" required>
            </div>
            <div class="field">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="text" name="password" autocomplete="off" {{ $vendor->exists ? '' : 'required' }}>
                <small>{{ $vendor->exists ? 'Leave blank to keep the current password.' : 'Minimum 8 characters.' }}</small>
            </div>

            <div class="actions" style="margin-top:20px">
                <button class="btn" type="submit">{{ $vendor->exists ? 'Save changes' : 'Create vendor' }}</button>
                <a class="btn btn-light" href="{{ route('admin.vendors.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection