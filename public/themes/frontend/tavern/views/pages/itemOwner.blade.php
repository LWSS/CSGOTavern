@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Item Owner @parent
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

{{ Asset::queue('amcharts', 'admin/pages/scripts/amcharts.js') }}
{{ Asset::queue('amcharts-serial', 'admin/pages/scripts/serial.js') }}

@section('scripts')
    <script>jQuery(document).ready(function () {
            Metronic.init();
            Layout.init();
        });
        @if( isset( $cacheHistory ))
            AmCharts.makeChart("chartdiv",
                {
                    "type": "serial",
                    "categoryField": "date",
                    "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
                    "pathToImages": "/themes/frontend/tavern/assets/global/plugins/amcharts/amcharts/images/",
                    "categoryAxis": {
                        "minPeriod": "mm",
                        "parseDates": true,
                        "position": "top",
                    },
                    "chartCursor": {
                        "categoryBalloonDateFormat": "MM-DD-YYYY JJ:NN"
                    },
                    "chartScrollbar": {},
                    "trendLines": [],
                    "graphs": [
                        {
                            "bullet": "round",
                            "id": "AmGraph-1",
                            "title": "Price: ",
                            "valueField": "column-1"
                        }
                    ],
                    "guides": [],
                    "allLabels": [],
                    "balloon": {},
                    "legend": {
                        "useGraphSettings": true
                    },
                    "titles": [
                        {
                            "id": "Title-1",
                            "size": 12,
                            "text": "{{ $cacheHistory[0]->item_name }}"
                        }
                    ],
                    "dataProvider": [
                            @foreach( $cacheHistory as $historyItem )
                            {
                            "column-1": {{ $historyItem->price }},
                            "date": "{{ $historyItem->updated_at }}"
                        },
                        @endforeach
                    ]
                }
        );
        @endif
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
            @if( $item->user->anonymous === 0 )
                {{--<!-- BEGIN PAGE TITLE -->--}}
                <div class="page-title">
                    <h1> Your {{ $item->item_name }} </h1>
                </div>
                {{--<!-- END PAGE TITLE -->--}}
            @else
                {{--<!-- BEGIN PAGE TITLE -->--}}
                <div class="page-title">
                    <h1> Your {{ $item->item_name }} ( Anonymous ) </h1>
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
                                <img src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $item->item_img }}/512fx512f"
                                     class="img-responsive" alt="">
                            </div>
                            {{--<!-- END SIDEBAR USERPIC -->--}}
                            {{--<!-- SIDEBAR USER TITLE -->--}}
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    {{ $item->item_name }}
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
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase"> This is your Item </span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab"> Item Comments </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab"> Price History </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_3" data-toggle="tab"> Item Settings </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <!-- ITEM COMMENTS TAB -->
                                                    <div class="tab-pane active" id="tab_1_1">
                                                        @if( !isset( $comments ) )
                                                            <div class="portlet light">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">We Couldn't Find any Comments on this Item</span>
                                                                    </div>
                                                                </div>
                                                                <form action="/{{ Request::path() }}/comment"
                                                                      id="commentForm" method="post">
                                                                    {!! csrf_field() !!}
                                                                </form>
                                                                <textarea class="form-control" name="comment" rows="3"
                                                                          form="commentForm"></textarea>

                                                                <div class="margin-top-10">
                                                                    <a href="javascript:{}" class="btn green-haze"
                                                                       onclick="document.getElementById('commentForm').submit();">
                                                                        Comment </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="portlet light">
                                                                <div class="portlet-title">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-bar-chart theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Comments on Your Item</span>
                                                                    </div>
                                                                </div>
                                                                <div class="portlet-body">
                                                                    <div class="scroller" style="height: 350px;"
                                                                         data-always-visible="1"
                                                                         data-rail-visible1="0"
                                                                         data-handle-color="#000000">
                                                                        <div class="general-item-list">
                                                                            @foreach( $comments as $comment )
                                                                                <div class="item">
                                                                                    <div class="item-head">
                                                                                        <div class="item-details">
                                                                                            <img class="item-pic"
                                                                                                 src="{{ $comment->commenter->avatar_url }}">
                                                                                            <a href="/profile/{{ $comment->commenter->id }}"
                                                                                               class="item-name primary-link">{{ $comment->commenter->display_name }}</a>
                                                                                            <span class="item-label">{{ $comment->created_at }}
                                                                                                <a href="/{{ Request::path() }}/comment/delete?commentID={{ $comment->id }}"><b>delete</b></a></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="item-body">
                                                                                        {{ $comment->comment }}
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <form action="/{{ Request::path() }}/comment"
                                                                          id="commentForm" method="post">
                                                                        {!! csrf_field() !!}
                                                                    </form>
                                                                    <textarea class="form-control" name="comment"
                                                                              rows="3" form="commentForm"></textarea>

                                                                    <div class="margin-top-10">
                                                                        <a href="javascript:{}" class="btn green-haze"
                                                                           onclick="document.getElementById('commentForm').submit();">
                                                                            Comment </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <!-- END ITEM COMMENTS TAB -->
                                                    <!-- ITEM HISTORY TAB -->
                                                    <div class="tab-pane" id="tab_1_2">
                                                        <!-- BEGIN ROW -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <!-- BEGIN CHART PORTLET-->
                                                                <div class="portlet light">
                                                                    <div class="portlet-title">

                                                                        <div class="portlet-body">
                                                                            <div id="chartdiv"
                                                                                 style="width: 100%; height: 400px; background-color: #FFFFFF;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- END CHART PORTLET-->
                                                                </div>
                                                            </div>
                                                            <!-- END ROW -->
                                                        </div>
                                                    </div>
                                                    <!-- END ITEM HISTORY TAB -->
                                                    <!-- CHANGE OWNER SETTINGS TAB -->
                                                    <div class="tab-pane" id="tab_1_3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <!-- BEGIN CHART PORTLET-->
                                                                <div class="portlet light">
                                                                    <div class="portlet-title">

                                                                        <div class="portlet-body">
                                                                            Nothing Here.
                                                                        </div>
                                                                    </div>
                                                                    <!-- END CHART PORTLET-->
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <!-- END OWNER SETTINGS TAB -->
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