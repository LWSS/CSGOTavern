@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Setup @parent
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
                    <h1> Your {{ $marketItem->item_name }} </h1>
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
                                <img src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $marketItem->item_img }}/512fx512f"
                                     class="img-responsive" alt="">
                            </div>
                            {{--<!-- END SIDEBAR USERPIC -->--}}
                            {{--<!-- SIDEBAR USER TITLE -->--}}
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    {{ $marketItem->item_name }}
                                </div>
                            </div>
                            {{--<!-- END SIDEBAR USER TITLE -->--}}
                            @if( $marketItem->asset_id === null && $marketItem->trade_id === null )
                                {{--<!-- SIDEBAR BUTTONS -->--}}
                                <div class="profile-userbuttons">
                                    <a href="/{{ Request::path() }}/send">
                                        <button type="button" class="btn btn-circle green-haze btn-sm"> Send Offer
                                        </button>
                                    </a>
                                </div>
                                {{--<!-- END SIDEBAR BUTTONS -->--}}
                            @endif
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
                                                        <a href="#tab_1_1" data-toggle="tab"> Listing Setup </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <!-- PRELISTING SETTINGS TAB -->
                                                    <div class="portlet ">
                                                        <div class="portlet-title">
                                                            <div class="caption">
                                                                <i class="fa fa-cogs"></i>Listing Details
                                                            </div>
                                                            @if( $marketItem->asset_id !== null && $marketItem->buyer_id === null )
                                                                <div class="actions">
                                                                    <a href="/{{ Request::path() }}/cancel"
                                                                       class="btn btn-default btn-sm"> <i
                                                                                class="fa fa-times"></i> Cancel Listing
                                                                    </a>
                                                                </div>
                                                            @elseif( $marketItem->buyer_id !== null )
                                                                <div class="actions">
                                                                    Item Sold!
                                                                </div>
                                                            @else
                                                                <div class="actions">
                                                                    <a href="/{{ Request::path() }}/delete"
                                                                       class="btn btn-default btn-sm"> <i
                                                                                class="fa fa-trash"></i> Delete </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Listing #:
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                    {{ $marketItem->id }}
                                                                    @if( ($marketItem->trade_id !== null && $marketItem->asset_id === null && $marketItem->last_status === null) )
                                                                        <span class="label label-info label-sm"> Trade Offer was Sent </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Listing Creation Date & Time:
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                    {{ $marketItem->created_at }}
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Bot Assigned:
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                    # {{ $marketItem->bot_id }}
                                                                </div>
                                                            </div>
                                                            @if( $marketItem->trade_id !== null && $marketItem->asset_id !== null )
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Trade ID:
                                                                    </div>
                                                                    <div class="col-md-7 value">
                                                                        # {{ $marketItem->trade_id }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if( $marketItem->buyer_id !== null )
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Sold To:
                                                                    </div>
                                                                    <div class="col-md-7 value">
                                                                        User # {{ $marketItem->buyer_id }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Order Status:
                                                                </div>
                                                                @if( $marketItem->buyer_id !== null )
                                                                    <div class="col-md-7 value">
                                                                        <span class="label label-success"> Sold </span>
                                                                    </div>
                                                                @elseif( $marketItem->asset_id !== null )
                                                                    <div class="col-md-7 value">
                                                                        <span class="label label-primary"> For Sale </span>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-7 value">
                                                                        <span class="label label-warning"> Not Received </span>
                                                                    </div>
                                                                    @if( $marketItem->last_status == 11 )
                                                                        <div class="col-md-7 value">
                                                                            <span class="label label-default"> In Escrow </span>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Item Price:
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                    {{ $marketItem->price }}
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Item's ID
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                    @if( $marketItem->asset_id !== null )
                                                                        {{ $marketItem->asset_id }}
                                                                    @else
                                                                        {{ $marketItem->first_asset_id }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                    Item Description
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                    {{ $marketItem->description }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PRELISTING SETTINGS TAB -->
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