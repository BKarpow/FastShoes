@extends('layouts.app')

@section('title') Корзина @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                
                <!-- /.row -->
                <h3>В корзине</h3>
                @if ($cartProducts->count() == 0)
                    <div class="alert alert-info">
                        <h5>У Вас пока нет товаров в корзине.</h5>
                    </div>
                    <!-- /.alert alert-info -->
                @else 
                    <h4>Заказов: {{$cartProducts->count()}}</h4>
                    <table class="table table-responsive table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Детали заказа</th>
                                <th>X</th>
                                <th>Цена</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartProducts as $item)
                                <tr>
                                    <td>
                                        <h5>
                                            <a href="{{$item->product->uri()}}">
                                                {{$item->product->title}}
                                            </a>
                                        </h5>
                                        <img width="120" src="{{$item->product->mainImage()}}" class=" img-thumbnail" alt="">
                                    </td>
                                    <td>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                Размер : {{$item->size}}
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                Цена за один : {{$item->product->price}} грн.
                                            </li>
                                            <li class="list-group-item">
                                                Заказано: {{$item->createdDate()}}
                                            </li>
                                            <!-- /.list-group-item -->
                                            <li class="list-group-item">
                                                <a href="{{route('cart.delete', ['id' => $item->id])}}" class="btn btn-outline-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash-fill" viewBox="0 0 16 16">
                                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM6.5 7h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1 0-1z"/>
                                                    </svg> Убрать из корзины
                                                </a>
                                                <!-- /.btn btn-outline-danger -->
                                            </li>
                                            <!-- /.list-group-item -->
                                            
                                        </ul>
                                        <!-- /.list-group -->
                                    </td>
                                    <td>
                                       X{{$item->count}}
                                    </td>
                                    <td>{{ ($item->product->price * $item->count) }}грн.</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table -->
                    <div class="mt-2">
                        <h3>Цена з все : {{$allPrice}}грн. </h3>
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