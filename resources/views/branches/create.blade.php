@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Add Branch</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('branches.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Branch Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Save Branch</button>
                <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
