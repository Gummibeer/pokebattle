@extends('master')

@section('pre-content')
    @include('partials.navbar')
    @include('partials.sidebar')
@endsection

@section('layout')
    @yield('content')
@endsection