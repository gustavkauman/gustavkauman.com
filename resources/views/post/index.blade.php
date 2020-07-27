@extends('layouts.base')

@section('title', 'Blog | gustavkauman.com')

@section('content')

    @foreach($posts as $post)
        {{ $post }}
    @endforeach

@endsection
