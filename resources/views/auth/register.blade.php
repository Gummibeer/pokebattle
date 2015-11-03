@extends('auth')

@section('content')
    {!! Form::open(['url' => 'auth/register']) !!}
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon wh-user"></i></span>
                {!! Form::text('name', null, [
                    'placeholder' => trans('messages.username'),
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            <div id="email-handler" class="input-group">
                <span class="input-group-addon"><i class="icon wh-envelope"></i></span>
                {!! Form::email('email', null, [
                    'placeholder' => trans('messages.email'),
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            <div id="password-handler" class="input-group">
                <span class="input-group-addon"><i class="icon wh-lock"></i></span>
                {!! Form::password('password', [
                    'placeholder' => trans('messages.password'),
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            <div id="confirm-handler" class="input-group">
                <span class="input-group-addon"><i class="icon wh-lock"></i></span>
                {!! Form::password('password_confirmation', [
                    'placeholder' => trans('messages.confirm'),
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            <div id="confirm-handler" class="input-group">
                <span class="input-group-addon"><i class="icon wh-pokemon"></i></span>
                {!! Form::select('pokemon_id', $startPokemons, null, [
                    'placeholder' => trans('messages.start_pokemon'),
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::submit(trans('messages.signup'), [
                'class' => 'btn btn-block btn-primary btn-lg',
            ]) !!}
        </div>
    {!! Form::close() !!}
    <p class="pull-right">
        Du hast schon einen Account? Dann <a href="{{ url('auth/register') }}">melde</a> dich an.
    </p>
@endsection