@extends('layouts/base')

{{ Asset::queue('lockscreen-style', 'admin/pages/css/lock2.css', ['plugins']) }}
@if( $user->lock3d != 0 )
    {{ Asset::queue('three', 'plugins/graphics/three.min.js', ['layout']) }}
    {{ Asset::queue('city-spiral', 'js/graphics/city-spiral.js', ['three']) }}
@endif

@section('styles')
    <style>
        #page-body
        {
            overflow: hidden;
        }
    </style>
@stop

{{-- Page title --}}
@section('title')
    Locked @parent
@stop

{{-- Meta description --}}
@section('meta-description')
    You're Locked Out! Enter your Password!
@stop


@section('body')
    <div class="page-lock">
        <div class="page-logo">
            <a class="brand" href="index.html">
                <img src="{{ Asset::getUrl('img/logos/logo.png') }}" alt="logo" height="19" width="150"/>
            </a>
        </div>
        <div class="page-body">
            <img class="page-lock-img" src="{{ $user->avatar_url }}" alt="">

            <div class="page-lock-info">
                @if( ($user->first_name === null || $user->first_name === '' )|| ($user->last_name === null || $user->last_name === '' ))
                    <h1>{{ ucfirst($user->display_name) }}</h1>
                @else
                    <h1>{{ ucfirst($user->first_name) . " "  . ucfirst($user->last_name) }}</h1>
                @endif
                @if( Session::has('error') )
                    <span class="locked" style="color: red;"> <b>{{ Session::get('error') }}</b></span>
                @else
                    <span class="locked"> <b> Locked </b></span>
                @endif
                <form class="form-inline" action="/lockPass" method="post">
                    <div class="input-group input-medium">
                        <input name="curPass" type="password" class="form-control" placeholder="Password">
                        <span class="input-group-btn">
                            <button type="submit" class="btn red icn-only"><i class="m-icon-swapright m-icon-white"></i>
                            </button>
                        </span>
                    </div>
                    {!! csrf_field() !!}
                    <!-- /input-group -->
                    <div class="relogin">
                        <a href="/steamlogout"> Not {{ ucfirst($user->display_name) }}? </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="page-footer-custom">
            <p class="footer__company">@setting('platform.app.copyright')</p>
        </div>
    </div>
@stop