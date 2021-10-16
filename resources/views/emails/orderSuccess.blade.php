@component('mail::message')
# Ваш заказ обработан.

Ваш заказ принят в обработку, в течении 15-минут с вами свяжется наш менеджер.

@component('mail::button', ['url' => $product->uri()])
Оставить отзыв.
@endcomponent

Отправлено с сайта {{ url('/') }} ,<br>
{{ config('app.name') }}
@endcomponent
