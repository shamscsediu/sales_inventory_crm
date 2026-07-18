<?php

namespace App\Services;

use App\Models\BranchInventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleService
{
    public function getAllSales(): Collection
    {
        return Sale::with(['customer', 'employee', 'branch'])->orderBy('created_at', 'desc')->get();
    }

    public function createSale(array $data): Sale
    {
        $sale = DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'employee_id' => $data['employee_id'],
                'branch_id' => $data['branch_id'],
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            foreach ($data['items'] as $item) {
                // Lock BranchInventory row for update to prevent race conditions
                $branchInventory = BranchInventory::where('branch_id', $data['branch_id'])
                    ->where('product_id', $item['product_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$branchInventory) {
                    throw new Exception("Product ID {$item['product_id']} is not available at this branch.");
                }

                if ($branchInventory->stock_quantity < $item['quantity']) {
                    $product = Product::find($item['product_id']);
                    throw new Exception("Insufficient stock for product: {$product->name} at this branch.");
                }

                // Deduct stock at the branch level
                $branchInventory->stock_quantity -= $item['quantity'];
                $branchInventory->save();

                // Lock and deduct stock at the global Product level
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                
                if ($product->stock_quantity < $item['quantity']) {
                    throw new Exception("Insufficient global stock for product: {$product->name}");
                }

                $product->stock_quantity -= $item['quantity'];
                $product->save();

                $subtotal = $product->price * $item['quantity'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $sale->update(['total_amount' => $totalAmount]);

            $wasLost = $sale->customer->is_lost;

            // Update the customer's last purchase date
            $sale->customer->update([
                'last_purchase_date' => $sale->sale_date ?? now()
            ]);

            if ($wasLost) {
                event(new \App\Events\CustomerRecovered($sale->customer));
            }

            return $sale;
        });

        // Send invoice email after successful transaction
        \Illuminate\Support\Facades\Mail::to($sale->customer->email)->send(new \App\Mail\InvoiceEmail($sale));

        return $sale;
    }
}
