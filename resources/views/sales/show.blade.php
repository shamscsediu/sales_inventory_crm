@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back to Sales</a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h3>Sale #{{ $sale->id }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Date:</strong> {{ ($sale->sale_date ?? $sale->created_at)->format('Y-m-d H:i:s') }}</p>
                <p><strong>Customer:</strong> {{ $sale->customer->name }}</p>
                <p><strong>Employee:</strong> {{ $sale->employee->name }}</p>
                <p><strong>Branch:</strong> {{ $sale->branch?->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h4>Total Amount</h4>
                <h2 class="text-success">${{ number_format($sale->total_amount, 2) }}</h2>
            </div>
        </div>
    </div>
</div>

<h4>Items</h4>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sale->saleItems as $item)
        <tr>
            <td>{{ $item->product->name }} ({{ $item->product->sku }})</td>
            <td>{{ $item->quantity }}</td>
            <td>${{ number_format($item->unit_price, 2) }}</td>
            <td>${{ number_format($item->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
