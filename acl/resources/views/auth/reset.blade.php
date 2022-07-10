@extends('core/acl::auth.master')
@section('content')
    <h1>{{ setting('admin_title', config('core.base.general.base_name')) }}</h1>
    <h3>{{ trans('core/acl::auth.reset_password') }}</h3>
    {!! Form::open(['route' => 'access.password.reset.post', 'method' => 'POST', 'class' => 'login-form']) !!}
        <div class="form-group mb-3 has-feedback{{ $errors->has('email') ? ' has-error' : '' }}" id="groupEmail">
            <label>{{ trans('core/acl::auth.reset.email') }}</label>
            {!! Form::text('email', old('email', $email), ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.reset.email')]) !!}
        </div>

        <div class="form-group mb-3 has-feedback{{ $errors->has('password') ? ' has-error' : '' }}" id="groupPassword">
            <label>{{ trans('core/acl::auth.reset.new_password') }}</label>
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.reset.new_password')]) !!}
        </div>

        <div class="form-group mb-3 has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" id="passwordConfirmationGroup">
            <label>{{ trans('core/acl::auth.password_confirmation') }}</label>
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.reset.password_confirmation')]) !!}
        </div>

        <button type="submit" class="btn btn-block btn-light login-button">
            <input type="hidden" name="token" value="{{ $token }}"/>
            <span class="signin text-white">{{ trans('core/acl::auth.reset.update') }}</span>
        </button>
    {!! Form::close() !!}
@stop
