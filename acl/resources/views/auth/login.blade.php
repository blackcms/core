@extends('core/acl::auth.master')

@section('content')
    <h1>{{ setting('admin_title', config('core.base.general.base_name')) }}</h1>
    <h5>{{ trans('core/acl::auth.sign_in') }}</h5>
    {!! Form::open(['route' => 'access.login', 'class' => 'mt-6']) !!}
        <div class="mb-2" id="groupEmail">
            {!! Form::text('username', request()->input('email', old('username', app()->environment('demo') ? config('core.base.general.demo.account.username', 'blackcms') : null)), ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.login.username')]) !!}
            <label class="form-label">{{ trans('core/acl::auth.login.username') }}</label>
        </div>
        <div class="mb-2" id="groupPassword">
            {!! Form::input('password', 'password', request()->input('email') ? null : (app()->environment('demo') ? config('core.base.general.demo.account.password', '159357') : null), ['class' => 'form-control', 'placeholder' => trans('core/acl::auth.login.password')]) !!}
            <label class="form-label">{{ trans('core/acl::auth.login.password') }}</label>
        </div>
        <div class="mb-2">
            <label>
                {!! Form::checkbox('remember', '1', true) !!} {{ trans('core/acl::auth.login.remember') }}
            </label>
        </div>
        <button type="submit" class="btn btn-light mb-2">
            {{ trans('core/acl::auth.login.login') }}
        </button>
        <br>
        <a class="lost-pass-link text-white" href="{{ route('access.password.request') }}" title="{{ trans('core/acl::auth.forgot_password.title') }}">{{ trans('core/acl::auth.lost_your_password') }}</a>
        {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \BlackCMS\ACL\Models\User::class) !!}
    {!! Form::close() !!}
@stop
