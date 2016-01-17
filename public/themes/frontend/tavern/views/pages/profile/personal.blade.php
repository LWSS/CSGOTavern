@extends('layouts/profile')
@section('page')
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
    <div class="container-fluid">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            @if( Session::has('error') )
                <h1 style="color: red;"> {{ Session::get('error')  }}</h1>
            @elseif (Session::has('green'))
                <h1 style="color: green;"> {{ Session::get('green')  }}</h1>
            @else
                <h1> Tell us more About Yourself, Traveler.
                    <small> ...Or don't, that's okay too.</small>
                </h1>
            @endif
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<!-- END PAGE HEAD -->
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="container-fluid">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar" style="width: 250px;">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <img src="{{ $steamuser->avatar_url }}" class="img-responsive" alt="">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                {{ $steamuser->display_name }}
                            </div>
                            @if( $steamuser->developer === 1 )
                                <div class="profile-usertitle-job">
                                    Developer
                                </div>
                            @endif
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->

                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase"> This is your Profile </span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">Profile Comments</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab">Personal Info( Not Public )</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_3" data-toggle="tab">Account Password</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_4" data-toggle="tab">Settings</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <p>
                                                Users may Come and Boast about you on your Profile Page, here you can
                                                moderate those you deem unfit.
                                            </p>
                                            @if ( count( $steamuser->comments ) === 0 )
                                                <div class="portlet light">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <i class="icon-bar-chart theme-font hide"></i>
                                                            <span class="caption-subject font-blue-madison bold uppercase">We Couldn't Find any Posted Comments</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="/profile/comment" id="commentForm" method="post">
                                                    {!! csrf_field() !!}
                                                </form>
                                                <textarea class="form-control" name="comment" rows="3"
                                                          form="commentForm"></textarea>

                                                <div class="margin-top-10">
                                                    <a href="javascript:{}" class="btn green-haze"
                                                       onclick="document.getElementById('commentForm').submit();">
                                                        Comment </a>
                                                </div>
                                            @else
                                                <div class="portlet light">
                                                    <div class="portlet-title">
                                                        <div class="caption caption-md">
                                                            <i class="icon-bar-chart theme-font hide"></i>
                                                            <span class="caption-subject font-blue-madison bold uppercase">Comments on Your Profile</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="scroller" style="height: 350px;"
                                                             data-always-visible="1"
                                                             data-rail-visible1="0" data-handle-color="#000000">
                                                            <div class="general-item-list">
                                                                @foreach( $steamuser->comments as $comment )
                                                                    <div class="item">
                                                                        <div class="item-head">
                                                                            <div class="item-details">
                                                                                <img class="item-pic"
                                                                                     src="{{ $comment->commenter->avatar_url }}">
                                                                                <a href="/profile/{{ $comment->commenter->id }}"
                                                                                   class="item-name primary-link">
                                                                                    @if( $comment->commenter->developer === 1 )
                                                                                        <i class="fa fa-star"></i>
                                                                                    @endif
                                                                                        {{ $comment->commenter->display_name }}
                                                                                </a>
                                                                                <span class="item-label">{{ $comment->created_at }}
                                                                                    <a href="/profile/comment/delete?commentID={{ $comment->id }}"><b>delete</b></a></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item-body">
                                                                            {{ $comment->comment }}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <form action="/profile/comment" id="commentForm" method="post">
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
                                                </div>
                                            @endif
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- COMMENTS TAB -->
                                        <div class="tab-pane" id="tab_1_2">
                                            <form role="form" method="post" action="{{ route('user.profile.update') }}" id="infoForm">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input name="first_name" type="text"
                                                           placeholder="{{ $steamuser->user->first_name or 'John' }}"
                                                           class="form-control"
                                                           value="" id="first_name"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input name="last_name" type="text"
                                                           placeholder="{{ $steamuser->user->last_name or 'Doe' }}"
                                                           class="form-control"
                                                           id=last_name"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input name="email" type="text"
                                                           placeholder="{{ $steamuser->user->email or $steamuser->display_name.'@gmail.com' }}"
                                                           class="form-control" id="email"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Steam Trade Token <a
                                                                href="https://steamcommunity.com/profiles/76561198104365816/tradeoffers/privacy#create_new_url_btn">
                                                            <b> -- CLICK HERE </b> </a></label>
                                                    <input name="token" type="text" placeholder="{{ $steamuser->trade_token }}"
                                                           class="form-control" id="token"/>
                                                </div>
                                                {!! csrf_field() !!}

                                                <div class="margin-top-10">
                                                    <a href="javascript:{}" class="btn green-haze"
                                                       onclick="document.getElementById('infoForm').submit();">
                                                        Save Changes </a>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END COMMENTS TAB -->
                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="tab_1_3">
                                        @if( !($steamuser->user->password === null || $steamuser->user->password === ''))
                                            You Already have a Password, Use this Form to Change it. <br>
                                            <b> Note: </b> You may Remove your password by leaving <i>"New Password"</i>
                                            and <i>"Re-type New Password"</i> Blank.
                                            <form action="/profile/passwordchange" method="post" id="changePassForm">
                                                <div class="form-group">
                                                    <label class="control-label">Current Password</label>
                                                    <input name="curPass" type="password" class="form-control"
                                                           maxlength="50"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">New Password</label>
                                                    <input name="newPass" type="password" class="form-control"
                                                           maxlength="50"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type New Password</label>
                                                    <input name="newPassConf" type="password" class="form-control"
                                                           maxlength="50"/>
                                                </div>
                                                {!! csrf_field() !!}
                                                <div class="margin-top-10">
                                                    <a href="javascript:" class="btn green-haze"
                                                       onclick="document.getElementById('changePassForm').submit();">
                                                        Change Password </a>
                                                </div>
                                            </form>
                                        @else
                                            Here you may Set a Password for your Account. <br><b> Note: </b> We will not
                                            Reset your Password, do not forget it.
                                            <form action="/profile/passwordset" method="post" id="addPassForm">
                                                <div class="form-group">
                                                    <label class="control-label">Password</label>
                                                    <input name="password" type="password" class="form-control"
                                                           maxlength="50"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type Password</label>
                                                    <input name="passwordConf" type="password" class="form-control"
                                                           maxlength="50"/>
                                                </div>
                                                {!! csrf_field() !!}
                                                <div class="margin-top-10">
                                                    <a href="javascript:" class="btn green-haze"
                                                       onclick="document.getElementById('addPassForm').submit();">
                                                        Add Password </a>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                    <!-- END CHANGE PASSWORD TAB -->
                                        <!-- PRIVACY SETTINGS TAB -->
                                        <div class="tab-pane" id="tab_1_4">
                                            <form action="/profile/update" method="post" id="settingsForm">
                                                <table class="table table-light table-hover">
                                                    <tr>
                                                        <td>
                                                            Anonymous Listings
                                                        </td>
                                                        <td>
                                                            @if( $steamuser->anonymous === 1 )
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="anonymous" value="yes"
                                                                           checked/> On </label>
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="anonymous" value="no"/>
                                                                    Off </label>
                                                            @else
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="anonymous" value="yes"/>
                                                                    On </label>
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="anonymous" value="no"
                                                                           checked/> Off </label>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            3D Lockscreen
                                                        </td>
                                                        <td>
                                                            @if( $steamuser->lock3d === 1 )
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="lock3d" value="yes"
                                                                           checked/> On </label>
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="lock3d" value="no"/>
                                                                    Off </label>
                                                            @else
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="lock3d" value="yes"/>
                                                                    On </label>
                                                                <label class="uniform-inline">
                                                                    <input type="radio" name="lock3d" value="no"
                                                                           checked/> Off </label>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                                {!! csrf_field() !!}
                                                        <!--end profile-settings-->
                                                <div class="margin-top-10">
                                                    <a href="javascript:" class="btn green-haze"
                                                       onclick="document.getElementById('settingsForm').submit();"> Save
                                                        Changes </a>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PRIVACY SETTINGS TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
    <!-- END PAGE CONTENT INNER -->
</div>
</div>
<!-- END PAGE CONTENT -->
@stop