@extends('core/acl::auth.master')

@section('content')
    <h1>{{ setting('admin_title', config('core.base.general.base_name')) }}</h1>
    <h5>{{ trans('core/acl::auth.forgot_password.title') }}</h5>
    {!! Form::open(['route' => 'access.password.email', 'class' => 'mt-6']) !!}
        <p>{!! clean(trans('core/acl::auth.forgot_password.message')) !!}</p>
        <br>
        <div class="form-group mb-2" id="groupEmail">
            {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.login.email')]) !!}
            <label class="form-label">{{ trans('core/acl::auth.login.email') }}</label>
        </div>
        <button type="submit" class="mb-2 btn btn-light">
            {{ trans('core/acl::auth.forgot_password.submit') }}
        </button>
        <br>
        <a class="lost-pass-link text-white" href="{{ route('access.login') }}">{{ trans('core/acl::auth.back_to_login') }}</a>
    {!! Form::close() !!}
@stop
