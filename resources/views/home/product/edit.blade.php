@extends('layouts.home')

@section('title') Изменить товар @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <form  method="PUT">
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
                    
                    <div class="form-group images-box">
                        <item-image :hidden-block="true" name-field="image_1" :image-self='{{ $product->imageItem_1(true) }}'></item-image>
                        <item-image :hidden-block="true" name-field="image_2" :image-self='{{ $product->imageItem_2(true) }}'></item-image>
                        <item-image :hidden-block="true" name-field="image_3" :image-self='{{ $product->imageItem_3(true) }}'></item-image>
                       
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