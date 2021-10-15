@component('mail::message')
# Заказан товар

Ура заказали товар.
Детали заказа:
-   {{ $phone }}
-   {{ $size }}

@component('mail::button', ['url' => $product->uri()])
{{$product->title}}
@endcomponent

Спасибо ,<br>
{{ config('app.name') }}
@endcomponent
