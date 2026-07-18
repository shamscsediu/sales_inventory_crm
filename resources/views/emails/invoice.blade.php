<x-mail::message>
# Invoice #{{ $sale->id }}

Hi {{ $sale->customer->name }},

Thank you for your purchase on {{ ($sale->sale_date ?? $sale->created_at)->format('Y-m-d') }}. Here are the details of your order:

<x-mail::table>
| Product | Quantity | Unit Price | Subtotal |
| :--- | :---: | :---: | :---: |
@foreach($sale->saleItems as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | ${{ number_format($item->unit_price, 2) }} | ${{ number_format($item->subtotal, 2) }} |
@endforeach
</x-mail::table>

### **Total: ${{ number_format($sale->total_amount, 2) }}**

Thanks for shopping with us!<br>
{{ config('app.name') }}
</x-mail::message>
