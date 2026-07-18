<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->email ?? '') }}" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone ?? '') }}">
    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="employee_id" class="form-label">Assign Employee</label>
    <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id">
        <option value="">Unassigned</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}" {{ old('employee_id', $customer->employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->name }}
            </option>
        @endforeach
    </select>
    @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
