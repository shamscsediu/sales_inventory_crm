<x-mail::message>
# Special Promotion Just For You!

Hi {{ $customer->name }},

We noticed you haven't shopped with us in a while. We miss you!
Use the promo code **WELCOMEBACK** to get 20% off your next purchase.

<x-mail::button :url="url('/products')">
Shop Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
