@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="row">
        <div class="col-lg-2 col-lg-offset-5 col-md-4 col-md-offset-4">
            <div class="text-center">
                <h1>PokéBattle</h1>
            </div>

            @yield('content')

            <div class="form-group row">
                <div class="col-xs-6">
                    <a href="#" class="btn btn-block btn-labeled social-facebook">
                        <span class="btn-label"><i class="icon fa fa-facebook"></i></span>
                        Facebook
                    </a>
                </div>
                <div class="col-xs-6">
                    <a href="#" class="btn btn-block btn-labeled social-github">
                        <span class="btn-label"><i class="icon fa fa-github"></i></span>
                        Github
                    </a>
                </div>
            </div>

            <div class="text-center out-links">© 2015 <a href="https://gummibeer.de">Gummibeer</a></div>
        </div>
    </div>
@endsection