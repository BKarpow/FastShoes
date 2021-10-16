@component('mail::message')
# Вы заказали

<table>
    <tbody>
        <tr>
            <td>Товар</td>
            <td>Размер</td>
            <td>Количество</td>
            <td>Сума</td>
        </tr>
        @foreach($products as $product)
            <tr>
                <td>
                    <h5> <a href="{{$product->product->uri()}}"> {{$product->product->title}}</a></h5>
                    <img src="{{$product->product->mainImage()}}" alt="{{$product->product->title}}" width="125">
                </td>
                <td>
                    {{$product->size}}
                </td>
                <td>
                    {{$product->product->price}}X{{$product->count}}
                </td>
                <td>
                    {{ (int)$product->product->price * (int) $product->count}}
                </td>
            </tr>
        @endforeach
        <tr>
            <th colspan="3"> Всего: </th>
            <th>{{$fullPrice}}</th>
        </tr>
    </tbody>
</table>

Детали в вашем кабинете на сайте.

@component('mail::button', ['url' => url('/my')])
В мой кабинет
@endcomponent

Скоро Вам поступить звонок на номер: {{$phone}}



Это письмо из магазина обуви -
{{ config('app.name') }}
@endcomponent
