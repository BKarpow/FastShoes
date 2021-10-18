@extends('layouts.home')

@section('title') Изменить товар @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <form action="{{route('home.product.updateFull')}}" method="PUT">
                    @csrf;
                    <div class="form-group">
                        <label for="name">Имя товара</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="form-control"
                            value="{{ $product->title }}"
                        >
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input 
                            id="price" 
                            name="price"
                            type="text" 
                            class="form-control col-md-3"
                            value="{{ $product->price }}"
                        >
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection