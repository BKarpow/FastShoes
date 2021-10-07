@extends('layouts.home')

@section('title') Отзывы товаров @endsection

@section('content')
    <div class="container">
        
        <div class="row">
            <div class="col">
                <h2>Отзывы товаров</h2>
                <table class="mt-2 table table-responsive table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Отзыв</th>
                            <th>Пользователь</th>
                            <th>IP</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>
                                    <h5>
                                        <a href="{{ $review->product->uri() }}">{{ $review->product->title }}</a>
                                        
                                    </h5>
                                    <img width="120" class="img-thumbnail" src="{{$review->product->mainImage()}}" alt="">
                                </td>
                                <td>
                                    <star-rating 
                                        star-size="18"
                                        read-only="true"
                                        rating="{{$review->rating}}"
                                        inline="true"
                                    > </star-rating>
                                    <p>
                                        {{$review->comment}}
                                    </p>
                                    <div class="mt-1">
                                        <div class="btn-group">
                                            <a href="{{ route('review.delete', ['review'=>$review]) }}" data-bs-toggle="tooltip" title="Удалить отзыв." class="btn btn-danger btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg>
                                            </a>
                                            <!-- /.btn btn-danger btn-sm -->
                                            <a href="{{ route('review.toggleModerate', ['review'=>$review]) }}" class="btn btn-primary btn-sm">
                                                @if ($review->moderate == 0)
                                                    <svg data-bs-toggle="tooltip" title="Показать на сайте" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                    </svg>
                                                @else
                                                    <svg data-bs-toggle="tooltip" title="Скрыть на сайте" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                                                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                                                    </svg>
                                                @endif
                                            </a>
                                            <!-- /.btn btn-primary btn-sm -->
                                        </div>
                                        <!-- /.btn-group -->
                                    </div>
                                    <!-- /.mt-1 -->
                                </td>
                                <td>
                                    {{$review->user->name}}
                                </td>
                                <td>
                                    {{$review->ip}}
                                </td>
                                <td> {{ $review->createdDate() }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">
                    {{$reviews->links()}}
                </div>
                <!-- /.mt-2 -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection