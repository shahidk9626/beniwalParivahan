@extends('layouts.portal')
@section('title', 'Vendors')
@section('content')
    @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <div class="page-head">
        <form method="GET" action="{{ route('admin.vendors.index') }}">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email or phone">
            <button class="btn" type="submit">Search</button>
        </form>
        <a class="btn" href="{{ route('admin.vendors.create') }}">+ Add New Vendor</a>
    </div>

    <div class="card" style="padding:0">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($vendors as $vendor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $vendor->name }}</strong></td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $vendor->is_active ? 'badge-ok' : 'badge-off' }}">
                                    {{ $vendor->is_active ? 'Active' : 'Blocked' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-sm btn-light" href="{{ route('admin.vendors.edit', $vendor) }}">Edit</a>

                                    <form method="POST" action="{{ route('admin.vendors.toggle', $vendor) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-warn" type="submit">
                                            {{ $vendor->is_active ? 'Block' : 'Unblock' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="hint">No vendors found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection