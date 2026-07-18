@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>New Sale</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Branch</label>
                    <select name="branch_id" class="form-select" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>
            <h4>Products</h4>
            <div id="items-container">
                <div class="row mb-2 item-row">
                    <div class="col-md-6">
                        <select name="items[0][product_id]" class="form-select" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (${{ $product->price }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="items[0][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-item w-100">Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-success mb-4" id="add-item">Add Product</button>

            <div>
                <button type="submit" class="btn btn-primary">Complete Sale</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = 1;
        document.getElementById('add-item').addEventListener('click', function () {
            const container = document.getElementById('items-container');
            const row = document.querySelector('.item-row').cloneNode(true);
            
            row.querySelector('select').name = `items[${itemIndex}][product_id]`;
            row.querySelector('select').value = '';
            
            row.querySelector('input').name = `items[${itemIndex}][quantity]`;
            row.querySelector('input').value = '';
            
            container.appendChild(row);
            itemIndex++;
        });

        document.getElementById('items-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                if (document.querySelectorAll('.item-row').length > 1) {
                    e.target.closest('.item-row').remove();
                } else {
                    alert('You must have at least one product in the sale.');
                }
            }
        });
    });
</script>
@endsection
