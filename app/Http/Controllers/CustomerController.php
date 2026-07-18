<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $customerService)
    {
    }

    public function index(): View
    {
        $customers = $this->customerService->getAllCustomers();
        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        $employees = \App\Models\Employee::orderBy('name')->get();
        return view('customers.create', compact('employees'));
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $this->customerService->createCustomer($request->validated());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer): View
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        $employees = \App\Models\Employee::orderBy('name')->get();
        return view('customers.edit', compact('customer', 'employees'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $this->customerService->updateCustomer($customer, $request->validated());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $this->customerService->deleteCustomer($customer);

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
