<div class="page-header">
    {{--<!-- BEGIN HEADER TOP -->--}}
    <div class="page-header-top">
        <div class="container-fluid">
            {{--<!-- BEGIN LOGO -->--}}
            <div class="page-logo">
                <a href="/"><img src="{{ Asset::getUrl('img/logos/logo.png') }}" height="25px" alt="logo"
                                          class="logo-default"></a>
            </div>
            {{--<!-- END LOGO -->--}}
            {{--<!-- BEGIN RESPONSIVE MENU TOGGLER -->--}}
            <a href="javascript:" class="menu-toggler"></a>
            {{--<!-- END RESPONSIVE MENU TOGGLER -->--}}
                <ul class="nav navbar-nav pull-right">
                    @if(Sentinel::check())
                        @if ( Sentinel::check()->steamusers->first() )
                            @include('partials/logged-in-userbar')
                        @else
                            @include('partials/logged-out-userbar')
                        @endif
                    @else
                        @include('partials/logged-out-userbar')
                    @endif
                </ul>
        </div>
    </div>
    {{--<!-- END HEADER TOP -->--}}
    {{--<!-- BEGIN HEADER MENU -->--}}
    <div class="page-header-menu">
        <div class="container-fluid">
            {{--<!-- BEGIN HEADER SEARCH BOX -->--}}
            <form id="search-form" class="search-form" action="/search" method="GET">
                <div class="input-group">
                    <input id="search-query" type="text" class="form-control" placeholder="Search Items" name="query">
					<span class="input-group-btn">
					<a href="javascript:" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
                </div>
            </form>
            {{--<!-- END HEADER SEARCH BOX -->--}}
            {{--<!-- BEGIN MEGA MENU -->--}}
            @include('partials/navigation')
            {{--<!-- END MEGA MENU -->--}}
        </div>
    </div>
    {{--<!-- END HEADER MENU -->--}}
</div>