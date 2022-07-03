@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('head')
    {!! MediaManagement::renderHeader() !!}
@endsection

@section('content')
    {!! MediaManagement::renderContent() !!}
@endsection

@section('javascript')
    {!! MediaManagement::renderFooter() !!}
@endsection
