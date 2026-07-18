<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function __construct(private SaleService $saleService)
    {
    }

    public function index(): View
    {
        $sales = $this->saleService->getAllSales();
        return view('sales.index', compact('sales'));
    }

    public function create(): View
    {
        $customers = Customer::orderBy('name')->get();
        $employees = Employee::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        
        return view('sales.create', compact('customers', 'employees', 'branches', 'products'));
    }

    public function store(StoreSaleRequest $request): RedirectResponse
    {
        try {
            $this->saleService->createSale($request->validated());
            return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale): View
    {
        $sale->load(['customer', 'employee', 'branch', 'saleItems.product']);
        return view('sales.show', compact('sale'));
    }
}
