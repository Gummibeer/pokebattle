@extends('auth')

@section('content')
    {!! Form::open(['url' => 'auth/register']) !!}
    <div class="form-group">
        <div id="email-handler" class="input-group">
            <span class="input-group-addon"><i class="icon fa fa-envelope"></i></span>
            {!! Form::email('email', null, [
                'placeholder' => trans('E-Mail'),
                'class' => 'form-control',
            ]) !!}
        </div>
    </div>
    <div class="form-group">
        <div id="password-handler" class="input-group">
            <span class="input-group-addon"><i class="icon fa fa-lock"></i></span>
            {!! Form::password('password', [
                'placeholder' => trans('Passwort'),
                'class' => 'form-control',
            ]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::submit(trans('anmelden'), [
            'class' => 'btn btn-block btn-primary btn-lg',
        ]) !!}
    </div>
    {!! Form::close() !!}
@endsection