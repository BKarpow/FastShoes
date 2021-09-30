@extends('layouts.home')

@section('title') Товари @endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1>Керування товарами</h1>
                <products-app />
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection