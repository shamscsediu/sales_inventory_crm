<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchInventory;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Branches
        $branches = Branch::factory(3)->create();

        // 2. 20 Products
        $products = Product::factory(20)->create();

        // 3. 50 Customers
        $customers = Customer::factory(50)->create();

        // 4. 10 Employees
        $employees = Employee::factory(10)->recycle($branches)->create();

        // 5. Branch Inventories (realistic initial stock values)
        foreach ($branches as $branch) {
            foreach ($products as $product) {
                BranchInventory::factory()->create([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'stock_quantity' => rand(50, 200),
                ]);
            }
        }

        // Make sure total stock_quantity on products is realistic if we are caching it there
        foreach ($products as $product) {
            $product->update([
                'stock_quantity' => $product->branchInventories()->sum('stock_quantity'),
            ]);
        }

        // 6. 200 Sales
        for ($i = 0; $i < 200; $i++) {
            $branch = $branches->random();
            $customer = $customers->random();
            $employee = $employees->where('branch_id', $branch->id)->first() ?? $employees->random();

            $sale = Sale::factory()->create([
                'branch_id' => $branch->id,
                'customer_id' => $customer->id,
                'employee_id' => $employee->id,
                'total_amount' => 0, // Calculated below
            ]);

            // Random sale items (1 to 5 per sale)
            $numItems = rand(1, 5);
            $saleProducts = $products->random($numItems);
            $totalAmount = 0;

            foreach ($saleProducts as $product) {
                $quantity = rand(1, 5);
                $unitPrice = $product->price;
                $subtotal = $quantity * $unitPrice;

                SaleItem::factory()->create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            // Update sale total amount
            $sale->update(['total_amount' => $totalAmount]);
        }
    }
}
