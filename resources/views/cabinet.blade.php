@extends('layouts.app')

@section('title') Мой кабинет @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-4 col-sm-3 col-md-2 col-lg-2">
                        <img src="{{$user->getPathAvatar()}}" width="120" class="circle" alt="">
                    </div>
                    <!-- /.col-4 col-sm-3 col-md-2 col-lg-1 -->
                    <div class="col-8 col-sm-9 col-md-10 col-lg-10">
                        <h2>{{ $user->name }}</h2>
                        <ul class="list-group mt-1">
                            <li class="list-group-item">
                                <strong>Email: </strong> {{$user->email}}
                            </li>
                            <!-- /.list-group-item -->
                            <li class="list-group-item">
                                <strong>Phone: </strong> {{$user->phone}}
                            </li>
                            <!-- /.list-group-item -->
                        </ul>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.col-8 col-sm-9 col-md-10 col-lg-11 -->
                </div>
                <!-- /.row -->
                <h3>Ваши заказы</h3>
                @if (!$orders)
                    <div class="alert alert-info">
                        <h5>У Вас пока нет заказов.</h5>
                    </div>
                    <!-- /.alert alert-info -->
                @else 
                    <h4>Заказов: {{$countOrders}}</h4>
                    <table class="table table-responsive table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Детали заказа</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <h5>
                                            <a href="{{$order->product->uri()}}">
                                                {{$order->product->title}}
                                            </a>
                                        </h5>
                                        <img width="120" src="{{$order->product->mainImage()}}" class=" img-thumbnail" alt="">
                                    </td>
                                    <td>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                Цена заказа: {{$order->info->price}} грн.
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                Количество: {{$order->info->count}} 
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                Номер телефона: {{$order->info->phone}} 
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                Писать в мессенджеры:
                                                 @if ($order->info->use_message) Да @else Нет @endif .
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item @if (!$order->info->new) list-group-item-success @else list-group-item-secondary  @endif">
                                                Статус заказ: 
                                                @if ($order->info->new) 
                                                    В обработке 
                                                @else 
                                                    Заказ обработан, ожидайте с Вами скоро свяжутся.
                                                    Обработано: {{ $order->info->updatedDate() }}
                                                    <a href="{{$order->product->uri()}}#reviews"
                                                         class="btn btn-info mt-3"
                                                         target="__blank"
                                                         >
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots-fill" viewBox="0 0 16 16">
                                                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                        </svg> Оценить товар
                                                        </a>
                                                    <!-- /.btn -->
                                                @endif
                                            </li>
                                            <!-- /.list-group-item -->
                                        </ul>
                                        <!-- /.list-group -->
                                    </td>
                                    <td>
                                        {{$order->createdDate()}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table -->
                    <div class="mt-2">
                        {{$orders->links()}}
                    </div>
                    <!-- /.mt-2 -->
                @endif
            </div>
            <!-- /.col-md-9 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection