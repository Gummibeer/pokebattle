@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="row">
        <div class="col-lg-2 col-lg-offset-5 col-md-6 col-md-offset-3">
            <div class="text-center">
                <h1 class="white">{{ trans('messages.pokebattle') }}</h1>
            </div>

            @yield('content')

            <div class="text-center out-links">© 2015 <a href="https://gummibeer.de">Gummibeer</a></div>
        </div>
    </div>
@endsection