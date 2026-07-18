@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Sales</h2>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">New Sale</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Employee</th>
                <th>Branch</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>#{{ $sale->id }}</td>
                <td>{{ ($sale->sale_date ?? $sale->created_at)->format('Y-m-d H:i') }}</td>
                <td>{{ $sale->customer->name }}</td>
                <td>{{ $sale->employee->name }}</td>
                <td>{{ $sale->branch?->name ?? 'N/A' }}</td>
                <td>${{ number_format($sale->total_amount, 2) }}</td>
                <td>
                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info text-white">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
