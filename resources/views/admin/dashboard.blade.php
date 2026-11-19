@extends('layouts.portal')
@section('title', 'Dashboard')
@section('content')
    <div class="stats">
        <div class="stat blue"><span>Total Vendors</span><strong>{{ $total }}</strong></div>
        <div class="stat green"><span>Active Vendors</span><strong>{{ $active }}</strong></div>
        <div class="stat red"><span>Blocked Vendors</span><strong>{{ $blocked }}</strong></div>
    </div>

    <div class="card">
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p class="hint" style="margin-bottom:16px">Create vendors, share their login details and manage their access.</p>
        <a class="btn" href="{{ route('admin.vendors.create') }}">+ Add New Vendor</a>
        <a class="btn btn-light" href="{{ route('admin.vendors.index') }}">View All Vendors</a>
    </div>
@endsection