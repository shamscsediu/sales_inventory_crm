@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Customers</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Assigned To</th>
                <th>Last Purchase</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>
                    {{ $customer->name }}
                    @if($customer->is_lost)
                        <span class="badge bg-danger ms-2">Lost</span>
                    @endif
                </td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone ?? 'N/A' }}</td>
                <td>{{ $customer->employee->name ?? 'Unassigned' }}</td>
                <td>{{ $customer->last_purchase_date ? $customer->last_purchase_date->format('Y-m-d') : 'Never' }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
