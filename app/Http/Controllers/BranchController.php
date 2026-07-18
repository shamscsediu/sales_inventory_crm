<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\BranchInventory;
use App\Models\Product;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('name')->get();
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(StoreBranchRequest $request)
    {
        Branch::create($request->validated());
        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());
        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }

    public function show(Branch $branch)
    {
        $products = Product::orderBy('name')->get();
        
        // Ensure all products have an inventory record for this branch
        foreach ($products as $product) {
            BranchInventory::firstOrCreate([
                'branch_id' => $branch->id,
                'product_id' => $product->id,
            ], [
                'stock_quantity' => 0
            ]);
        }

        $inventories = BranchInventory::with('product')
            ->where('branch_id', $branch->id)
            ->get()
            ->sortBy('product.name');

        return view('branches.show', compact('branch', 'inventories'));
    }

    public function updateInventory(Request $request, Branch $branch, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $inventory = BranchInventory::where('branch_id', $branch->id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        $inventory->update([
            'stock_quantity' => $request->stock_quantity
        ]);

        // Recalculate global stock as sum of all branch inventories
        $globalStock = BranchInventory::where('product_id', $product->id)->sum('stock_quantity');
        $product->update(['stock_quantity' => $globalStock]);

        return redirect()->route('branches.show', $branch)->with('success', 'Inventory updated for ' . $product->name . '. Global stock synced to ' . $globalStock . '.');
    }
}
