@extends('layouts.app')

@section('title') {{$product->title}} @endsection

@section('meta')
    <meta name="description" content="{{ $product-> metaDescription() }}" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $product->title }}" />
    <meta property="og:image" content="{{ $product->image_1 }}" />
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
                
               <div class="price-item mt-1">
                   <span>{{$product->price}}</span>
               </div>
               <!-- /.price my-1 -->
               <div class="mt-1">
                   <span class="h6 d-block">
                       Раздел: <a href="{{ $product->category->section->fullHref() }}">
                           {{ $product->category->section->title }}
                       </a>
                   </span>
                   <span class="h6 d-block">
                       Категория: <a href="{{ $product->category->fullHref() }}">
                           {{ $product->category->title }}
                       </a>
                   </span>
               </div>
               <!-- /.mt-1 -->
                
                
                <div class="mt-1">
                    <add-to-cart 
                        @success="updateCart"
                        @if (auth()->check()) :auth="true" @endif
                        price="{{$product->price}}"
                        :product-id="{{$product->id}}"
                        :sizes='{{$product->sizes}}'
                    ></add-to-cart>
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
        <div class="row">
            <div class="col-md-11">
                <span class="d-block meta-item" >Заказов: {{$product->orders}}</span>
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
                @if ($ordered) :is-ordered-product="true" @endif
                @endif
                 />
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row mt-2 -->
    </div>
    <!-- /.container -->
@endsection