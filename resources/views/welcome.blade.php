@extends('layouts.app')

@if (isset($isMeta))
    @section('meta')
        <meta name="description" content="{{$meta->metaDescription()}}" />
    @endsection
@else
@section('meta')
    <meta name="description" content="Fast - ето быстрый сервис по подбору обуви. Магазин создан для максимально просто и удобного выбора обуви. Весь товар от проверенных производителей г. Харьков." />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Fast - магазин кожаной обуви" />
    <meta property="og:image" content="{{ '' }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:description" content="Магазин создан для максимально просто и удобного выбора обуви. Весь товар от проверенных производителей г. Харьков." />
@endsection
@endif

@section('content')
    <product-app /> 
@endsection