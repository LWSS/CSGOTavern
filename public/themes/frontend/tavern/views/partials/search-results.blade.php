<div class="page-head">
    <div class="container-fluid">
        <div class="page-title">
            <h1> Search Results </h1>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container-fluid">
        {{--<!-- BEGIN PAGE BREADCRUMB -->--}}
        <ul class="page-breadcrumb breadcrumb">
            <a> You Searched For: </a>
            <li class="active">
                <b>{{ $_GET['query'] }}</b>
            </li>
        </ul>
        {{--<!-- END PAGE BREADCRUMB -->--}}
        {{--<!-- BEGIN PAGE CONTENT INNER -->--}}
        <div class="tabbable tabbable-custom tabbable-noborder">
            <div class="tab-content">
                {!! $results->appends(['query' => $_GET['query']])->render() !!}
                <div class="row booking-results">
                    @foreach( $results as $result )
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 text-center">
                            <div class="booking-result">
                                <div class="booking-img">
                                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/{{ $result->item_img }}/125fx125f"
                                         alt="">
                                    <ul class="list-unstyled price-location">
                                        <li>
                                            <h2>
                                                <a href="/marketitems/{{ $result->id }}"> {{ $result->item_name }}</a>
                                            </h2>
                                        </li>
                                        <li>
                                            <i class="fa fa-money"></i> {{ $result->price }}
                                            $ {{ number_format(($result->price/100), 2) }}
                                        </li>
                                        <li>
                                            <i class="fa fa-user"></i> {{ $result->user->display_name }}
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