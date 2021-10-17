@extends('layouts.home')
 
@section('title') Заказы @endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1>Все заказы.</h1>
                @if ($orders->count() == 0) 
                            <div class="alert alert-warning my-1">
                                <strong>
                                    Заказов пока нет.
                                </strong>
                            </div>
                            <!-- /.alert alert-warning -->
                @else
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Размер</th>
                            <th>Телефон</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($orders as $order)
                            <tr class="  ">
                                <td>
                                    <h4>{{ $order->product->title }}</h4>
                                    <h5> {{ (int) $order->product->price * (int) $order->count }} (X{{$order->count}})  </h5>
                                    <img src="{{$order->product->image_1}}"
                                     class="img-thumbnail" width="100" alt="{{ $order->product->title }}">
                                </td>
                                <td>
                                    <strong>
                                        {{$order->size}}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        <a href="tel:{{$order->phoneClean()}}">
                                        {{$order->phone}}</a>
                                        @if ($order->use_message)
                                            <div class="mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                width="32" height="32" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
                                                </svg>
                                                <span style="font-weight: bold;">Только писать в мессенджеры</ыз>
                                            </div>
                                            <!-- /.mt-1 -->
                                        @endif
                                        @if ($order->new)
                                        <div class="my-2">
                                            <div class="alert alert-info">
                                                <p>
                                                    Заказ пока не обработан
                                                </p>
                                            </div>
                                            <!-- /.alert-info -->
                                            <a href="{{ route('order.disNew',
                                                 ['order' => $order]) }}" class="btn btn-danger">
                                                Пометить как обработанной.
                                            </a>
                                            <!-- /.btn btn-primary -->
                                        </div>
                                        @endif
                                        
                                    </strong>
                                    <spoller btn-show-text="Показать детали заказа."> 
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                Количество - {{$order->count}}
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                IP - {{$order->ip}}
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                Использовать мессенджеры - @if ($order->use_message) Да @else Нет @endif
                                            </li>
                                            <!-- /.list-group-item -->
                                        </ul>
                                        <!-- /.list-group --> 
                                    </spoller>
                                </td>
                                <td>
                                    {{ $order->createdDate() }}
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                <!-- /.table table-hover -->
            @endif
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                {{ $orders->links(); }}
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection