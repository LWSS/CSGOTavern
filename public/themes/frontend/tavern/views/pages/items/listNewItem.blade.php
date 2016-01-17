@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    List New Item @parent
@stop

{{-- Meta description --}}
@section('meta-description')
@stop

{{-- Queue styles/scripts --}}
{{ Asset::queue('bootstrap-fileinput', 'global/plugins/bootstrap-fileinput/bootstrap-fileinput.css', 'bootstrap') }}
{{ Asset::queue('profile', 'admin/pages/css/profile.css', ['bootstrap-fileinput', 'style']) }}
{{ Asset::queue('tasks', 'admin/pages/css/tasks.css', 'profile') }}

{{ Asset::queue('js-bootstrap-fileinput', 'global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', 'layout') }}
{{ Asset::queue('jquery.sparkline', 'global/plugins/jquery.sparkline.min.js', ['js-bootstrap-fileinput', 'bootstrap']) }}



@section('scripts')
    <script>jQuery(document).ready(function () {
            Metronic.init();
            Layout.init();
        });
    </script>
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
    {{--<!-- BEGIN PAGE HEAD -->--}}
    <div class="page-head">
        <div class="container-fluid">
            {{--<!-- BEGIN PAGE TITLE -->--}}
            <div class="page-title">
                @if( Session::has('error') )
                    <h1 style="color: red;"> {{ Session::get('error')  }}</h1>
                @elseif (Session::has('green'))
                    <h1 style="color: green;"> {{ Session::get('green')  }}</h1>
                @else
                    <h1> You're About to List your {{ $confirmedItem['desc']['market_name'] }} </h1>
                @endif
            </div>
            {{--<!-- END PAGE TITLE -->--}}
        </div>
    </div>
    {{--<!-- END PAGE HEAD -->--}}
    {{--<!-- BEGIN PAGE CONTENT -->--}}
    <div class="page-content">
        <div class="container-fluid">
            {{--<!-- BEGIN PAGE CONTENT INNER -->--}}
            <div class="row margin-top-10">
                <div class="col-md-12">
                    {{--<!-- BEGIN PROFILE SIDEBAR -->--}}
                    <div class="profile-sidebar" style="width: 250px;">
                        {{--<!-- PORTLET MAIN -->--}}
                        <div class="portlet light profile-sidebar-portlet">
                            {{--<!-- SIDEBAR USERPIC -->--}}
                            <div class="profile-userpic">

                                <a href=""><img
                                            src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $confirmedItem['desc']['icon_url'] }}/512fx512f"
                                            class="img-responsive" alt=""></a>
                            </div>
                            {{--<!-- END SIDEBAR USERPIC -->--}}
                            {{--<!-- SIDEBAR USER TITLE -->--}}
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    {{ $confirmedItem['desc']['market_name'] }}
                                </div>
                            </div>
                            {{--<!-- END SIDEBAR USER TITLE -->--}}
                        </div>
                        {{--<!-- END PORTLET MAIN -->--}}
                    </div>
                    {{--<!-- END BEGIN PROFILE SIDEBAR -->--}}

                    {{--<!-- BEGIN PROFILE CONTENT -->--}}
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title tabbable-line">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab"> Listing Settings </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <!-- PRELISTING SETTINGS TAB -->
                                                    <form role="form" method="post"
                                                          action="/{{ Request::path() }}/settings" id="infoForm">
                                                        <div class="form-group">
                                                            <label class="control-label">Price</label>
                                                            <input name="price" type="number" placeholder=""
                                                                   class="form-control" value="" id="price"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">(Optional) Description</label>
                                                            <input name="description" type="text" placeholder=""
                                                                   class="form-control" id="description"
                                                                   maxlength="255"/>
                                                        </div>
                                                        {!! csrf_field() !!}

                                                        <div class="margin-top-10">
                                                            <a href="javascript:{}" class="btn green-haze"
                                                               onclick="document.getElementById('infoForm').submit();">
                                                                Save Changes </a>
                                                        </div>
                                                    </form>
                                                    <!-- PRELISTING SETTINGS TAB -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<!-- END PROFILE CONTENT -->--}}
                </div>
            </div>
            {{--<!-- END PAGE CONTENT INNER -->--}}
        </div>
        {{--<!-- END PAGE CONTENT INNER -->--}}
    </div>
    </div>
    {{--<!-- END PAGE CONTENT -->--}}
@stop