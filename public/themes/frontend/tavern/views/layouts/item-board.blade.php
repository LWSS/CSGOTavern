@extends('layouts/tavern')

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
    @if( isset( $results[0] ) )
        <div class="page-content">
            <div class="container-fluid">
                {{--<!-- BEGIN PAGE BREADCRUMB -->--}}
                @yield('breadcrumb')
                {{--<!-- END PAGE BREADCRUMB -->--}}
                {{--<!-- BEGIN PAGE CONTENT INNER -->--}}
                <div class="tabbable tabbable-custom tabbable-noborder">
                    <div class="tab-content">
                        @section('pagination')
                            {!! $results->render() !!}
                        @show
                        <div class="row booking-results">
                            @foreach( $results->items() as $result )
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 text-center">
                                    <div class="booking-result">
                                        <div class="booking-img">
                                            <a href="/marketitems/{{ $result['id'] }}"><img
                                                        src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $result['item_img'] }}/125fx125f"
                                                        alt=""></a>
                                            <ul class="list-unstyled price-location">
                                                <li>
                                                    <h2>
                                                        <a href="/marketitems/{{ $result['id'] }}"> {{ $result['item_name'] }}</a>
                                                    </h2>
                                                </li>
                                                <li>
                                                    <i class="fa fa-money"></i> {{ $result['price'] }}
                                                    $ {{ number_format(($result['price']/100), 2) }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{--<!--end tabbable-->--}}
                </div>
                {{--<!-- END PAGE CONTENT INNER -->--}}
            </div>
        </div>
        {{--<!-- END PAGE CONTENT -->--}}
    @else
        @include ( 'partials/search-no-results' )
    @endif
@stop