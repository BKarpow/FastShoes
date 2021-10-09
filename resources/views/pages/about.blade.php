@extends('layouts.app')

@section('title') О магазине @endsection

@section('meta')
    <meta name="description" content="Fast - ето быстрый сервис по подбору обуви." />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="О магазине Fast" />
    <meta property="og:image" content="{{ '' }}" />
    <meta property="og:url" content="{{ url('') }}" />
    <meta property="og:description" content="Магазин создан для максимально просто и удобного выбора обуви. Весь товар от проверенных производителей г. Харьков." />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1>Информация о магазине Fast</h1>
                <p class="lead">
                    Магазин создан для максимально просто и удобного выбора обуви. Весь товар от проверенных производителей г. Харьков. 
                    Обувь изготовлена из натуральных материалов (в основном яловая кожа "Флотар").
                </p>
                <!-- /.lead -->
                <p class="lead">
                    Мы работаем с такими формами как: Barzoni, Levon, Levons, Crossav и другими производителями.
                </p>
                <!-- /.lead -->
            </div>
            <!-- /.col-md-11 -->
        </div>
        <!-- /.row mt-2 -->
    </div>
    <!-- /.container -->
@endsection