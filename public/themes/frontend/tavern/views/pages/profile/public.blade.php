@extends('layouts/profile')
@section('page')
        <!-- BEGIN PAGE HEAD -->
<div class="page-head">
    <div class="container-fluid">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1> Here's One of our Valued Users </h1>
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
                            @if( $steamuser->developer )
                                <div class="profile-usertitle-job">
                                    Developer
                                </div>
                            @endif
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <button type="button" class="btn btn-circle green-haze btn-sm">Send Tokens</button>
                            <button type="button" class="btn btn-circle btn-danger btn-sm">Message</button>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->

                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            @if ( count($steamuser->comments)==0 )
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="icon-bar-chart theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">We Couldn't Find any Posted Comments</span>
                                        </div>
                                    </div>
                                </div>
                                <form action="/{{ Request::path() }}/comment" id="commentForm" method="post">
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
                                        <div class="scroller" style="height: 350px;" data-always-visible="1"
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
                                                                <span class="item-label">{{ $comment->created_at }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="item-body">
                                                            {{ $comment->comment }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if( \App\Models\SteamUser::check() === true )
                                            <form action="/{{ Request::path() }}/comment" id="commentForm"
                                                  method="post">
                                                {!! csrf_field() !!}
                                            </form>
                                            <textarea class="form-control" name="comment" rows="3"
                                                      form="commentForm"></textarea>
                                            <div class="margin-top-10">
                                                <a href="javascript:{}" class="btn green-haze"
                                                   onclick="document.getElementById('commentForm').submit();">
                                                    Comment </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
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