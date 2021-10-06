@extends('layouts.app')

@if (isset($isMeta))
    @section('meta')
        <meta name="description" content="{{$meta->metaDescription()}}" />
    @endsection
@endif

@section('content')
    <product-app /> 
@endsection