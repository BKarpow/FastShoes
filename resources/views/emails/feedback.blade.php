@component('mail::message')
# Сообщения из формы обратной связи

Email: {{$feedback->email}}.
FeedBack id: {{$feedback->id}}.
Сообщения:
{{ $feedback->message }}

Отправлено из сайта {{ url('/') }},<br>
{{ config('app.name') }}
@endcomponent
