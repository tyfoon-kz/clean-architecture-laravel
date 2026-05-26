<x-mail::message>
# Product {{ $event }}

SKU: {{ $product->sku }}

Name: {{ $product->name }}

<x-mail::button :url="url('/admin/products/'.$product->id.'/edit')">
Open product
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
