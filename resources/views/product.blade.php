@extends('layouts.app')

@section('title') {{$product->title}} @endsection

@section('meta')
    <meta name="description" content="{{ $product-> metaDescription() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $product->title }}" />
    <meta property="og:image" content="{{ $product->mainImage() }}" />
    <meta property="og:url" content="{{ $product->uri() }}" />
    <meta property="og:description" content="{{ $product-> metaDescription() }}" />
@endsection

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
                <div class="mt-1">
                    <h5>Доступные размеры.</h5>
                    <strong> {{ join(', ', $product->sizesArray() ) }} </strong>
                </div>
                <!-- /.mt-1 -->
                
            </div>
            <!-- /.col-md-9 -->
        </div>
        <!-- /.row -->
        <div class="row mt-2">
            <div class="col-md-11">
                <h5>Описывания товара</h5>
                {!! $product->description !!}
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row -->
        <div class="row mt-2">
            <div class="col-md-11">
                <h4>Отзывы </h4>
                <reviews-app 
                product-id="{{$product->id}}"
                @if (auth()->check())
                auth-flag="1"
                :user-id="{{auth()->user()->id}}"
                @endif
                 />
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row mt-2 -->
    </div>
    <!-- /.container -->
@endsection