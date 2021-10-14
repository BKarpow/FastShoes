@extends('layouts.home')

@section('title') Админка @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Главная страница</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3> Информация </h3>
                    <p>Товаров: {{ $countProducts }}</p>
                    <p>Заказов: {{ $countOrders }}, из ных новых {{ $countNewOrders }}</p>
                    <p> 
                        <a href="{{route('home.order.index')}}" class="btn btn-secondary btn-lg">
                            Заказам товаров {{ $countNewOrders }}
                        </a>
                        <!-- /.btn -->
                    </p>

                    <h4>Управления</h4>
                    <p> 
                        <a href="{{route('sections.spa')}}" class="btn btn-success">
                            Секции товаров
                        </a>
                        <!-- /.btn -->
                    </p>
                    <p> 
                        <a href="{{route('category.spa')}}" class="btn btn-secondary">
                            Категории товаров
                        </a>
                        <!-- /.btn -->
                    </p>
                    <p> 
                        <a href="{{route('product.spa')}}" class="btn btn-primary">
                            Товары
                        </a>
                        <!-- /.btn -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
