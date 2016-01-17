@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Locked @parent
@stop

{{-- Meta description --}}
@section('meta-description')
    Your Account is Locked
@stop

@section('scripts')
    <script>jQuery(document).ready(function () {
            Metronic.init();
            Layout.init();
        });</script>
@stop

{{-- Page Header --}}
@section('header')

    {{--<!-- Full Width Image Header -->--}}
    <div class="caption">

        <div class="container-fluid">

            <h1>@setting('platform.app.title' )
                <span>v @setting('platform-foundation.installed_version' )</span>
            </h1>

            <h2>@content('headline', 'headline.html')</h2>

            <p><code>{{ Theme::getActive()->getPath() }}</code></p>

        </div>

    </div>

@stop

{{-- Page content --}}
@section('page')
    <div class="pass-user">
        <a class="brand" href="index.html">
            <img src="{{ $user['avatar_url'] }}" alt="logo"/>
        </a>
        @if( Session::has('error') )
            <h1 style="color: red;"> {{ Session::get('error')  }}</h1>
        @endif
    </div>
    <div class="page-body">
        <div class="pass-body">
            <h1>{{ $user['username'] }}</h1>

            <form action="/lockPass" method="post" id="changePassForm">
                <div class="form-group">
                    <label class="control-label">Session Locked! Enter your Password.</label>
                    <input name="curPass" type="password" class="form-control" maxlength="50"/>
                </div>
                {!! csrf_field() !!}
                <div class="margin-top-10">
                    <a href="javascript:" class="btn green-haze"
                       onclick="document.getElementById('changePassForm').submit();"> Unlock </a>
                </div>
            </form>
        </div>
    </div>
@stop
