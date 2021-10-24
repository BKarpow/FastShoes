@extends('layouts.app')

@section('title') {{$product->title}}, {{ $product->category->title }}, {{ $product->category->section->title }} }} @endsection

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
                        @if ($liked) :liked="true" @endif
                    ></add-to-cart>
                </div>
                <!-- /.mt-1 -->
                
            </div>
            <!-- /.col-md-9 -->
        </div>
        <!-- /.row -->
        
        <div class="row mt-2">
            <div class="col-md-11">
                @if (auth()->check())
                @if (auth()->user()->isAdmin())
                <div class="pt-1">
                    <admin-product
                        :category-id="{{ $product->category_id }}"
                        title-product="{{ $product->title }}"
                        price-product="{{ $product->price }}"
                        :product-id="{{ $product->id }}"
                        @if(!empty($product->imageItem_1(true))) :image-self-one='{{ $product->imageItem_1(true) }}' @endif
                        @if(!empty($product->imageItem_2(true))) :image-self-two='{{ $product->imageItem_2(true) }}' @endif
                        @if(!empty($product->imageItem_3(true))) :image-self-three='{{ $product->imageItem_3(true) }}' @endif
                        
                    ></admin-product>
                </div>
                <!-- /.pt-1 -->
                @endif
                @endif
                <div class="py-1">
                    <hide-box v-cloak btn-show-text="Таблица размеров" btn-hide-text="Скрыть таблицу">
                        <table class="table table-responsive table-hover">
                            <tbody>
                                <tr>
                                    <td>Размер</td>
                                    <td>Длина стопы, см</td>
                                    <td>US</td>
                                    <td>UK</td>
                                </tr>
                                <tr>
                                    <td>39</td>
                                    <td>24</td>
                                    <td>6</td>
                                    <td>5.5</td>
                                </tr>
                                <tr>
                                    <td>40</td>
                                    <td>25</td>
                                    <td>7</td>
                                    <td>6.5</td>
                                </tr>
                                <tr>
                                    <td>41</td>
                                    <td>25.5</td>
                                    <td>7.5</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>42</td>
                                    <td>26.5</td>
                                    <td>8.5</td>
                                    <td>8</td>
                                </tr>
                                <tr>
                                    <td>43</td>
                                    <td>27</td>
                                    <td>9</td>
                                    <td>8.5</td>
                                </tr>
                                <tr>
                                    <td>44</td>
                                    <td>28</td>
                                    <td>10</td>
                                    <td>9.5</td>
                                </tr>
                                <tr>
                                    <td>45</td>
                                    <td>29</td>
                                    <td>11</td>
                                    <td>10.5</td>
                                </tr>
                                <tr>
                                    <td>46</td>
                                    <td>30</td>
                                    <td>12</td>
                                    <td>11.5</td>
                                </tr>
                                <tr>
                                    <td>49</td>
                                    <td>32</td>
                                    <td>14</td>
                                    <td>13.5</td>
                                </tr>
                            </tbody>
                        </table>
                    </hide-box>
                </div>
                <!-- /.py-1 -->
                <div class="mb-1">
                    <hide-box btn-show-text="Доставка и оплата" btn-hide-text="Скрыть блок Доставка и оплата" >
                        <span class="d-block h5">
                            Доставка
                        </span>
                        <!-- /.d-block h5 -->
                        <p>Наш менеджер подберет самый оптимальный для Вас способ доставки и оплаты.</p>
                        <p>
                            Доставка осуществляется такими сервисами как:
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Новая почта
                                </li>
                                <!-- /.list-group-item -->
                                <li class="list-group-item">
                                    Укрпочта
                                </li>
                                <!-- /.list-group-item -->
                                <li class="list-group-item">
                                    Самовывоз (только в г. Городише Черкаська область)
                                </li>
                                <!-- /.list-group-item -->
                            </ul>
                            <!-- /.list-group -->
                        </p>
                        <span class="d-block h5 mt-1">
                            Оплата
                        </span>
                        <!-- /.d-block h5 -->
                        <p>Оплата возможна следующим способами:
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Наложений платеж при получении товара в отделении почты.
                                </li>
                                <!-- /.list-group-item -->
                                <li class="list-group-item">
                                    Перевод на карту ПриватБанка.
                                </li>
                                <!-- /.list-group-item -->
                                <li class="list-group-item">
                                    Наличными при получении товара (только в г. Городише, Черкаська область)
                                </li>
                                <!-- /.list-group-item -->
                            </ul>
                            <!-- /.list-group -->
                        </p>
                    </hide-box>
                </div>
                <!-- /.mb-1 -->
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