@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Buy @parent
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

{{ Asset::queue('charts-amcharts', 'admin/pages/scripts/charts-amcharts.js') }}


@section('scripts')
    <script>jQuery(document).ready(function () {
            Metronic.init();
            Layout.init();
        });
        ChartsAmcharts.init();
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
            @if( isset( $newlyBought ) )
                {{--<!-- BEGIN PAGE TITLE -->--}}
                <div class="page-title">
                    <h1 style="color: green;"> {{ $item->buyer->display_name }}'s {{ $item->item_name }} </h1>
                </div>
                {{--<!-- END PAGE TITLE -->--}}
            @elseif( $item->user->anonymous === 0 )
                {{--<!-- BEGIN PAGE TITLE -->--}}
                <div class="page-title">
                    <h1> {{ $item->user->display_name }}'s {{ $item->item_name }} </h1>
                </div>
                {{--<!-- END PAGE TITLE -->--}}
            @else
                {{--<!-- BEGIN PAGE TITLE -->--}}
                <div class="page-title">
                    <h1> Anon's {{ $item->item_name }} </h1>
                </div>
                {{--<!-- END PAGE TITLE -->--}}
            @endif
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
                                <img src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $item->item_img }}/512x512f"
                                     class="img-responsive" alt="">
                            </div>
                            {{--<!-- END SIDEBAR USERPIC -->--}}
                            {{--<!-- SIDEBAR USER TITLE -->--}}
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    {{ $item->item_name }}
                                </div>
                            </div>
                            <div class="profile-userbuttons">
                                <i class="fa fa-money"></i> {{ $item->price }}
                                $ {{ number_format(($item->price/100), 2) }}
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
                                        @if( isset( $buyer ) )
                                            <div class="portlet light">
                                                <div class="portlet-title tabbable-line">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab"> Confirmation </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        Are you Sure you want to Purchase this Item
                                                        for: {{ $item->price }} Tokens?
                                                        <form action="/{{ Request::path() }}/confirm" method="post">
                                                            <button name="buyConf" value="yes"
                                                                    class="btn btn-circle green-haze btn-sm"> Yes
                                                            </button>
                                                            <button name="buyConf" value="no"
                                                                    class="btn btn-circle btn-danger btn-sm"> No
                                                            </button>
                                                            {!! csrf_field() !!}
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif( isset( $newlyBought ) )
                                            <div class="portlet light">
                                                <div class="portlet-title tabbable-line">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab"> New Owner! </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            Congratulations, you have just bought
                                                            a(n) {{ $item->item_name }}!
                                                            <br>
                                                            Go <b><a href="/mypurchases/{{ $item->id }}">HERE</a></b> to
                                                            Receive this New Item
                                                            <br>
                                                            <br>
                                                            ** You can also manage this Item later under "My Purchases"
                                                            section in the Profile Menu.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        @else
                                            <div class="portlet light">
                                                <div class="portlet-title tabbable-line">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab"> Info </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- STRIPE TAB -->
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            You Don't have enough Tokens for this Item.<b> <a
                                                                        href="/addtokens"> Click Here to Add More </a>
                                                            </b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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