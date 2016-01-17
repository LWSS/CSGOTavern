@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Sell @parent
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

{{ Asset::queue('pages.auctions', 'js/pages/auctions.js', ['jquery', 'bootstrap']) }}

@section('scripts')
    @parent
@stop

{{-- Page Header --}}
{{--@section('header')--}}
{{--@stop--}}
{{--@stop--}}

{{-- Page content --}}
@section('page')
    <div class="page-content">
        <div class="container-fluid">
            <div class="tiles">
                <div class="csgoitem">
                    <div class="tile bg-parchment">
                        <div class="tile-body">
                            {{--<i class="fa fa-briefcase"></i>--}}
                            <img src="https://steamcommunity-a.akamaihd.net/economy/image/KZrvJQobc-UDF4O4EBp0_ZHWJZROa32l19lQovT8PFrgkdjeUwc196POn0Y2eihzidF-00d0faHR0lew9eorUO_TzNRCAzL-s7-bTDUwO2KNxzXLAyEzuN3TZqe_7i9T5KPJ3HsRJPOrhY92OScodZb9PY0TLCbm1NkL9ei9KQzkypCJQVF_paXYmBE4ZnBiy8Rk3UBwZfrR2Aul6-t_Ca-MxtY=/127fx127f"
                                 alt="">
                        </div>
                        <div class="tile-object">
                            <div class="name">{{-- Max 19 characters --}}
                                Factory New
                            </div>
                            {{--<div class="number">--}}
                            {{--124--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop