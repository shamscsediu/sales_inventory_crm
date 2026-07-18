<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

class CustomerService
{
    public function getAllCustomers(): Collection
    {
        return Customer::orderBy('created_at', 'desc')->get();
    }

    public function createCustomer(array $data): Customer
    {
        return Customer::create($data);
    }

    public function updateCustomer(Customer $customer, array $data): bool
    {
        return $customer->update($data);
    }

    public function deleteCustomer(Customer $customer): bool|null
    {
        return $customer->delete();
    }
}
