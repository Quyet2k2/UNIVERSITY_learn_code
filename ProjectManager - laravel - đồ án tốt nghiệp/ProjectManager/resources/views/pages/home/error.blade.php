@extends('layouts.master')
<!-- q-read: title -->
@section('title', 'Error!')

<!-- q-read: content -->
@section('content')
    <?php
    $code = isset($code) ? $code : 404;
    $title = isset($title) ? $title : 'Page not found!';
    $message = isset($message) ? $message : 'Page does not exist.';
    ?>

    <div class="jumbotron">
        <div class="container">
            <h1>{{ $code }}, {{ $title }}</h1>
            <p>{{ $message }}</p>

            {{-- @foreach ($routes as $route)
                @if (strpos($route->getName(), 'admin.') !== false || strpos($route->getName(), 'user.') !== false)
                    <p> {{ $route->getName() }}</p>
                @endif
            @endforeach --}}

        </div>
    </div>

@stop
