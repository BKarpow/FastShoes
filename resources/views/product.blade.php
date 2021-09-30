@extends('layouts.app')

@section('title') {{$product->title}} @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 images">
                <product-images product-id="{{$product->id}}" > </product-images>
            </div>
            <!-- /.col-md-6 images-->
            <div class="col-md-6">
                <h5>{{$product->title}}</h5>
                
               <div class="price-item my-1">
                   <span>{{$product->price}}</span>
               </div>
               <!-- /.price my-1 -->
                
                <div class="my-2">
                    <product-order 
                        price="{{$product->price}}" 
                        size-data="{{$product->sizes}}" 
                        product-id="{{$product->id}}"
                    />
                </div>
                <!-- /.mt-2 -->
            </div>
            <!-- /.col-md-9 -->
        </div>
        <!-- /.row -->
        <div class="row mt-2">
            <div class="col-md-11">
                <h5>Описвания товара</h5>
                {!! $product->description !!}
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection