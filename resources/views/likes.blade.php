@extends('layouts.app')

@section('title') ♥ Мое избранное @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                
                <h3>Вот что Вы сохранили</h3>
                @if (!$likes)
                    <div class="alert alert-info">
                        <h5>У Вас пока сохраненных товаров, для добавление перейдите на страницу товара и кликните на сердечко ♥.</h5>
                    </div>
                    <!-- /.alert alert-info -->
                @else 
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Товар</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($likes as $like)
                                <tr>
                                    <td>
                                        <h5>
                                            <a href="{{$like->product->uri()}}">
                                                {{$like->product->title}}
                                            </a>
                                        </h5>
                                        <img width="120" src="{{$like->product->mainImage()}}" class="d-block img-thumbnail" alt="">
                                        <small class="d-block mt-2"> {{$like->createdDate()}} </small>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table -->
                    <div class="mt-2">
                        {{$likes->links()}}
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