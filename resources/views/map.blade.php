@extends('layouts.app')

@section('title') Карта сайта @endsection

@section('meta')
    <meta name="description" content="Карта сайта для навигации" />
@endsection

@section('content')
    <div class="container">1
        <div class="row">
            <div class="col-lg-10">
                <h1>Карта сайта</h1>
                <ul>
                    @foreach($sections as $section)
                        <li>
                            <a href="{{ $section->fullHref() }}">
                                {{ $section->title }}
                            </a>
                            <ul>
                                @foreach($section->categories()->get() as $category)
                                    <li>
                                        <a href="{{ $category->fullHref() }}">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
@endsection
