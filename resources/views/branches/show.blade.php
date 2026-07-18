@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('branches.index') }}" class="btn btn-secondary">Back to Branches</a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h3>{{ $branch->name }} - Inventory Management</h3>
        <p class="mb-0 text-muted">{{ $branch->location }}</p>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Product (SKU)</th>
                <th>Current Stock</th>
                <th>Update Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <td class="align-middle">{{ $inventory->product->name }} ({{ $inventory->product->sku }})</td>
                <td class="align-middle fw-bold {{ $inventory->stock_quantity == 0 ? 'text-danger' : 'text-success' }}">
                    {{ $inventory->stock_quantity }}
                </td>
                <td>
                    <form action="{{ route('branches.inventory.update', [$branch, $inventory->product]) }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('PUT')
                        <input type="number" name="stock_quantity" value="{{ $inventory->stock_quantity }}" class="form-control form-control-sm me-2" style="width: 100px" min="0" required>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
