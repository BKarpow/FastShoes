@extends('layouts.home')

@section('title') Заказы @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1>Все заказы.</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Размер</th>
                            <th>Телефон</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->count() == 0) 
                            <div class="alert alert-warning">
                                <strong>
                                    Заказов пока нет.
                                </strong>
                            </div>
                            <!-- /.alert alert-warning -->
                        @else
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <h4>{{ $order->product->title }}</h4>
                                    <h5> {{ $order->product->price }} </h5>
                                    <img src="{{$order->product->image_1}}"
                                     class="img-thumbnail" style="width:100px" alt="{{ $order->product->title }}">
                                </td>
                                <td>
                                    <strong>
                                        {{$order->size}}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{$order->phone}}
                                        @if ($order->new)
                                        <div class="mt-2">
                                            <a href="{{ route('order.disNew',
                                                 ['order' => $order]) }}" class="btn btn-danger">
                                                ПРОСМОТРЕНО
                                            </a>
                                            <!-- /.btn btn-primary -->
                                        </div>
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    {{ $order->createdDate() }}
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <!-- /.table table-hover -->
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection