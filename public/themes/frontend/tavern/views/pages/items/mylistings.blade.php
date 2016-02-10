@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    My Listings @parent
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
                @else
                    <h1> Your Listings </h1>
                @endif
            </div>
            {{--<!-- END PAGE TITLE -->--}}
        </div>
    </div>
    {{--<!-- END PAGE HEAD -->--}}
    {{--<!-- BEGIN PAGE CONTENT -->--}}
    <div class="page-content">
        <div class="container-fluid">
            @if( isset( $allListings ) )
                <div class="portlet grey-gallery box">
                    <div class="portlet-title">
                        @if( !isset( $all ) || $all !== true )
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Active Listings
                            </div>
                            <div class="actions">
                                <a href="/mylistings/all" class="btn btn-default btn-sm"> <i class="fa fa-history"></i>
                                    Show All </a>
                            </div>
                        @else
                            <div class="caption">
                                <i class="fa fa-cogs"></i>All Listings
                            </div>
                        @endif
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        Item Name
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $allListings as $listing )
                                    <tr>
                                        <td>
                                            <a href="/sell/list/setup/{{ $listing->id }}">{{ $listing->item_name }}</a>
                                        </td>
                                        <td>
                                            @if( $listing->buyer_id !== null )
                                                <div class="col-md-7 value">
                                                    <span class="label label-success"> Sold </span>
                                                </div>
                                            @elseif( $listing->asset_id !== null )
                                                <div class="col-md-7 value">
                                                    <span class="label label-primary"> For Sale </span>
                                                </div>
                                            @else
                                                <div class="col-md-7 value">
                                                    <span class="label label-warning"> Not Received </span>
                                                </div>
                                                @if( $listing->last_status == 11 )
                                                    <div class="col-md-7 value">
                                                        <span class="label label-default"> In Escrow </span>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $listing->price }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
        </div>
    </div>
    {{--<!-- END PAGE CONTENT -->--}}
@stop