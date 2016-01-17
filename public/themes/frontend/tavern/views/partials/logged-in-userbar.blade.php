{{--<!-- BEGIN USER LOGIN DROPDOWN -->--}}
<li class="dropdown dropdown-user dropdown-dark">
    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        Tokens: <b>
            <small>{{ number_format( Sentinel::getUser()->tavern_tokens ) }}</small>
        </b>
        <img alt="" class="img-circle" src="{{  Sentinel::getUser()->steamusers->first()->avatar_url }}">
        <span class="username username-hide-mobile">{{ Sentinel::getUser()->steamusers->first()->display_name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="{{ route('user.profile.self') }}">
                <i class="icon-user"></i> My Profile </a>
        </li>
        <li>
            <a href="/mylistings">
                <i class="fa fa-list-alt"></i> My Listings
                {{--<span class="badge badge-danger"> 3 </span>--}}
            </a>
        </li>
        <li>
            <a href="/mycashouts">
                <i class="fa fa-credit-card"></i> My Cashouts
                {{--<span class="badge badge-success"> 7 </span>--}}
            </a>
        </li>
        <li>
            <a href="/mypurchases">
                <i class="fa fa-gift"></i> My Purchases
                {{--<span class="badge badge-success"> 7 </span>--}}
            </a>
        </li>
        <li class="divider">
        </li>
        @if(Sentinel::getUser()->password)
            <li>
                <a href="/lock">
                    <i class="icon-lock"></i> Lock Screen </a>
            </li>
        @endif
        <li>
            <a href="/steamlogout">
                <i class="icon-key"></i> Log Out </a>
        </li>
    </ul>
</li>
{{--<!-- END USER LOGIN DROPDOWN -->--}}
