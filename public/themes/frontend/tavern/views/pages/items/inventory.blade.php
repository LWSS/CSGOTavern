@extends('layouts/tavern')
@section('title')
    Inventory @parent
@stop
@section('scripts')
    <script>jQuery(document).ready(function () {
            Metronic.init();
            Layout.init();
        });
        $("#searchinput").bind("keyup", function () {
            var text = $(this).val().toLowerCase();
            var items = $(".booking-result");
            items.parent().hide();
            items.filter(function () {
                console.log($(this).attr('id').toLowerCase());
                return $(this).attr('id').toLowerCase().indexOf(text) != -1;
            }).parent().show();
        });
    </script>
@stop
@section('page')
    <div class="page-head">
        <div class="container-fluid">
            <div class="page-title">
                @if( Session::has('error') )
                    <h1 style="color: red;"> {{ Session::get('error')  }}</h1>
                @elseif (Session::has('green'))
                    <h1 style="color: green;"> {{ Session::get('green')  }}</h1>
                @else
                    <h1><b> Your Inventory </b></h1>
                @endif
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="form-group">
                <input class="form-control" id="searchinput" type="search" placeholder="Search..."/>
            </div>
            @if( isset( $invItems ) )
                {{--<!-- BEGIN PAGE CONTENT INNER -->--}}
                <div class="tabbable tabbable-custom tabbable-noborder">
                    <div class="tab-content">
                        <div class="row booking-results">
                            @foreach( $invItems as $item )
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-1 text-center">
                                    <div class="booking-result" id="{{ $item['desc']['name'] }}">
                                        <a href="/sell/list/{{ $item['info']['id'] }}" class="tooltips"
                                           data-container="body" data-placement="top" data-html="true"
                                           data-original-title="Item Name: {{ $item['desc']['name'] }}<br>Item ID: {{ $item['info']['id'] }}<br>ClassID: {{ $item['info']['classid'] }}<br>InstanceID: {{ $item['info']['instanceid'] }}<br>Tradable: {{ $item['desc']['tradable'] }}">
                                            <ul class="list-unstyled price-location">
                                                <li>
                                                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $item['desc']['icon_url'] }}/125fx125f"
                                                         alt="">
                                                </li>
                                            </ul>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{--<!--end tabbable-->--}}
                </div>
                {{--<!-- END PAGE CONTENT INNER -->--}}
            @else
                <div class="tabbable tabbable-custom tabbable-noborder">
                    <div class="tab-content">
                        <h1><b> We Couldn't Grab your Inventory ( Or your Inventory is Empty )</b></h1>
                    </div>
                </div>
            @endif

        </div>
    </div>
@stop