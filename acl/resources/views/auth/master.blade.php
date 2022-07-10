@extends('core/base::layouts.base')

@section('page')
        <div class="bg-primary text-white w-100 vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6 col-xl-4 col-10 offset-xl-1">
                @yield('content')
            </div>
        </div>
@stop
