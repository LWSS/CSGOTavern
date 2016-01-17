@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    My Purchases @parent
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
                @if( isset( $error ) )
                    <h1 style="color: red;"> {{ $error  }}</h1>
                @else
                    <h1> Your Purchases </h1>
                @endif
            </div>
            {{--<!-- END PAGE TITLE -->--}}
        </div>
    </div>
    {{--<!-- END PAGE HEAD -->--}}
    {{--<!-- BEGIN PAGE CONTENT -->--}}
    <div class="page-content">
        <div class="container-fluid">
            @if( isset( $userPurchases ) )
                <div class="portlet grey-gallery box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Your Purchases
                        </div>
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
                                        Price
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Received?
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $userPurchases as $purchase )
                                    <tr>
                                        <td>
                                            <a href="/mypurchases/{{ $purchase->id }}">{{ $purchase->item_name }}</a>
                                        </td>
                                        <td>
                                            {{ $purchase->price }}
                                        </td>
                                        <td>
                                            {{ $purchase->updated_at }}
                                        </td>
                                        <td>
                                            @if( $purchase->asset_id !== null )
                                                @if( $purchase->last_status === 11 )
                                                    No (ESCROW)
                                                @else
                                                    No
                                                @endif
                                            @else
                                                Yes
                                            @endif
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