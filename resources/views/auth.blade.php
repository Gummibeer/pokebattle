@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="row">
        <div class="col-lg-2 col-lg-offset-5 col-md-6 col-md-offset-3">
            <div class="text-center">
                <h1 class="white">{{ trans('messages.pokebattle') }}</h1>
            </div>

            @yield('content')

            <div class="form-group row">
                <div class="col-sm-6">
                    <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-labeled social-facebook">
                        <span class="btn-label"><i class="icon wh-facebook"></i></span>
                        Facebook
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="{{ url('auth/github') }}" class="btn btn-block btn-labeled social-github">
                        <span class="btn-label"><i class="icon wh-github"></i></span>
                        Github
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="{{ url('auth/slack') }}" class="btn btn-block btn-labeled social-slack">
                        <span class="btn-label"><i class="icon wh-chat"></i></span>
                        Slack
                    </a>
                </div>
            </div>

            <div class="text-center out-links">© 2015 <a href="https://gummibeer.de">Gummibeer</a></div>
        </div>
    </div>
@endsection