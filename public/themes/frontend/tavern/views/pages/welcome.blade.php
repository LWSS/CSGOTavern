@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
	{{ $page->meta_title or 'Welcome' }} @parent
@stop

{{-- Meta description --}}
@section('meta-description')
	{{ $page->meta_description or 'CSGOTavern HomePage' }}
@stop

{{-- Queue styles/scripts --}}
{{ Asset::queue('welcome', 'platform/less/welcome.less', 'style') }}

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

	{{--<!-- BEGIN PAGE HEAD -->--}}
<div class="page-head">
	<div class="container-fluid">
		<div class="page-title">
			{{--<h1>{{$page->name}}</h1>--}}
			<h1> Home </h1>
		</div>
	</div>
</div>
	{{--<!-- END PAGE HEAD -->--}}
	{{--<!-- BEGIN PAGE CONTENT -->--}}
<div class="page-content">
	<div class="container-fluid">
		{{--<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->--}}
		<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Modal title</h4>
					</div>
					<div class="modal-body">
						Widget settings form goes here
					</div>
					<div class="modal-footer">
						<button type="button" class="btn blue">Save changes</button>
						<button type="button" class="btn default" data-dismiss="modal">Close</button>
					</div>
				</div>
				{{--<!-- /.modal-content -->--}}
			</div>
			{{--<!-- /.modal-dialog -->--}}
		</div>
		{{--<!-- /.modal -->--}}
		{{--<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->--}}
		{{--<!-- BEGIN PAGE CONTENT INNER -->--}}
		<div class="portlet light">
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-12 blog-page">
						<div class="row">
							<div class="col-md-9 col-sm-8 article-block">
								<h1 style="margin-top:0px">Latest News</h1>
								<div class="row">
									<div class="col-md-4 blog-img blog-tag-data">
										<img src="{{ Asset::getUrl('admin/pages/media/gallery/image4.jpg') }}" alt="" class="img-responsive">
										<ul class="list-inline">
											<li>
												<i class="fa fa-calendar"></i>
												<a href="javascript:"> October 25th 2015 </a>
											</li>
											<li>
												<i class="fa fa-comments"></i>
												<a href="javascript:"> 38 Comments </a>
											</li>
										</ul>
									</div>
									<div class="col-md-8 blog-article">
										<h3>
											<a href="page_blog_item.html"> CSGOTavern Open! </a>
										</h3>
										<p>
											It is with Great Pleasure that I announce the Grand-Opening of
											csgotavern.com. The site has been in development for a few months now and we
											are finally up-and-running. Click Below for More Info!
										</p>
										<a class="btn blue" href="page_blog_item.html">
											Read more <i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4 blog-img blog-tag-data">
										<img src="../../assets/admin/pages/media/gallery/image3.jpg" alt="" class="img-responsive">
										<ul class="list-inline">
											<li>
												<i class="fa fa-calendar"></i>
												<a href="javascript:">
													April 16, 2013 </a>
											</li>
											<li>
												<i class="fa fa-comments"></i>
												<a href="javascript:">
													38 Comments </a>
											</li>
										</ul>
										<ul class="list-inline blog-tags">
											<li>
												<i class="fa fa-tags"></i>
												<a href="javascript:">
													Technology </a>
												<a href="javascript:">
													Education </a>
												<a href="javascript:">
													Internet </a>
											</li>
										</ul>
									</div>
									<div class="col-md-8 blog-article">
										<h3>
											<a href="page_blog_item.html">
												Hello here will be some recent news.. </a>
										</h3>
										<p>
											At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.
										</p>
										<a class="btn blue" href="page_blog_item.html">
											Read more <i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4 blog-img blog-tag-data">
										<img src="../../assets/admin/pages/media/gallery/image4.jpg" alt="" class="img-responsive">
										<ul class="list-inline">
											<li>
												<i class="fa fa-calendar"></i>
												<a href="javascript:">
													April 16, 2013 </a>
											</li>
											<li>
												<i class="fa fa-comments"></i>
												<a href="javascript:">
													38 Comments </a>
											</li>
										</ul>
										<ul class="list-inline blog-tags">
											<li>
												<i class="fa fa-tags"></i>
												<a href="javascript:">
													Technology </a>
												<a href="javascript:">
													Education </a>
												<a href="javascript:">
													Internet </a>
											</li>
										</ul>
									</div>
									<div class="col-md-8 blog-article">
										<h3>
											<a href="page_blog_item.html">
												Hello here will be some recent news.. </a>
										</h3>
										<p>
											At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.
										</p>
										<a class="btn blue" href="page_blog_item.html">
											Read more <i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4 blog-img blog-tag-data">
										<img src="../../assets/admin/pages/media/gallery/image3.jpg" alt="" class="img-responsive">
										<ul class="list-inline">
											<li>
												<i class="fa fa-calendar"></i>
												<a href="javascript:">
													April 16, 2013 </a>
											</li>
											<li>
												<i class="fa fa-comments"></i>
												<a href="javascript:">
													38 Comments </a>
											</li>
										</ul>
										<ul class="list-inline blog-tags">
											<li>
												<i class="fa fa-tags"></i>
												<a href="javascript:">
													Technology </a>
												<a href="javascript:">
													Education </a>
												<a href="javascript:">
													Internet </a>
											</li>
										</ul>
									</div>
									<div class="col-md-8 blog-article">
										<h3>
											<a href="page_blog_item.html">
												Hello here will be some recent news.. </a>
										</h3>
										<p>
											At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.
										</p>
										<a class="btn blue" href="page_blog_item.html">
											Read more <i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4 blog-img blog-tag-data">
										<img src="../../assets/admin/pages/media/gallery/image5.jpg" alt="" class="img-responsive">
										<ul class="list-inline">
											<li>
												<i class="fa fa-calendar"></i>
												<a href="javascript:">
													April 16, 2013 </a>
											</li>
											<li>
												<i class="fa fa-comments"></i>
												<a href="javascript:">
													38 Comments </a>
											</li>
										</ul>
										<ul class="list-inline blog-tags">
											<li>
												<i class="fa fa-tags"></i>
												<a href="javascript:">
													Technology </a>
												<a href="javascript:">
													Education </a>
												<a href="javascript:">
													Internet </a>
											</li>
										</ul>
									</div>
									<div class="col-md-8 blog-article">
										<h3>
											<a href="page_blog_item.html">
												Hello here will be some recent news.. </a>
										</h3>
										<p>
											At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.
										</p>
										<a class="btn blue" href="page_blog_item.html">
											Read more <i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
							</div>
							<!--end col-md-9-->
							<div class="col-md-3 col-sm-4 blog-sidebar">
								<h3 style="margin-top:0px">Top News</h3>
								<div class="top-news">
									<a href="javascript:" class="btn red">
										<span> Metronic News </span>
										<em>Posted on: April 16, 2013</em>
										<em>
											<i class="fa fa-tags"></i> Money, Business, Google </em>
										<i class="fa fa-briefcase top-news-icon"></i>
									</a>
									<a href="javascript:" class="btn green">
										<span> Top Week </span>
										<em>Posted on: April 15, 2013</em>
										<em>
											<i class="fa fa-tags"></i> Internet, Music, People </em>
										<i class="fa fa-music top-news-icon"></i>
									</a>
									<a href="javascript:" class="btn blue">
										<span> Gold Price Falls </span>
										<em>Posted on: April 14, 2013</em>
										<em>
											<i class="fa fa-tags"></i> USA, Business, Apple </em>
										<i class="fa fa-globe top-news-icon"></i>
									</a>
									<a href="javascript:" class="btn yellow">
										<span> Study Abroad </span>
										<em>Posted on: April 13, 2013</em>
										<em>
											<i class="fa fa-tags"></i> Education, Students, Canada </em>
										<i class="fa fa-book top-news-icon"></i>
									</a>
									<a href="javascript:" class="btn purple">
										<span> Top Destinations </span>
										<em>Posted on: April 12, 2013</em>
										<em>
											<i class="fa fa-tags"></i> Places, Internet, Google Map </em>
										<i class="fa fa-bolt top-news-icon"></i>
									</a>
								</div>
								<div class="space20">
								</div>
								<h3> Developers</h3>
								<div class="tabbable tabbable-custom">
									<ul class="nav nav-tabs">
										<li class="active">
											<a data-toggle="tab" href="#tab_1_1"> Mr. Braun </a>
										</li>
										<li>
											<a data-toggle="tab" href="#tab_1_2"> Xversial </a>
										</li>
									</ul>
									<div class="tab-content">
										<div id="tab_1_1" class="tab-pane active">
											<img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/45/45df903d4caf49362e42fdbbb282dee1a3bb6ef3_full.jpg"
												 height="60px" width="60px">
											<p>
												Hi I'm Mr. Braun!
											</p>
											<p>
												I do most of the UI and Page-Logic. I also designed the SteamBot system.
												You can find me on Steam Here:
												https://steamcommunity.com/profiles/76561198047479758 or on the Forum
												here: https://forum.csgotavern.com/profiles/1. =)
											</p>
										</div>
										<div id="tab_1_2" class="tab-pane">
											<img src="https://en.gravatar.com/userimage/30262514/10cfab6019aabbe339efc31dab1cf482.png?size=184"
												 height="70px" width="60px">
											<p>
												Howdy, I'm Xversial
											</p>
											<p>
                                                
											</p>
										</div>
									</div>
								</div>
								<div class="space20">
								</div>
								<h3>Recent Tweets</h3>
								<div class="blog-twitter">
									<div class="blog-twitter-block">
										<a href="">
											@keenthemes </a>
										<p>
											At vero eos et accusamus et iusto odio.
										</p>
										<a href="javascript:">
											<em>http://t.co/sBav7dm</em>
										</a>
											<span>
											2 hours ago </span>
										<i class="fa fa-twitter blog-twiiter-icon"></i>
									</div>
									<div class="blog-twitter-block">
										<a href="">
											@keenthemes </a>
										<p>
											At vero eos et accusamus et iusto odio.
										</p>
										<a href="javascript:">
											<em>http://t.co/sBav7dm</em>
										</a>
											<span>
											5 hours ago </span>
										<i class="fa fa-twitter blog-twiiter-icon"></i>
									</div>
									<div class="blog-twitter-block">
										<a href="">
											@keenthemes </a>
										<p>
											At vero eos et accusamus et iusto odio.
										</p>
										<a href="javascript:">
											<em>http://t.co/sBav7dm</em>
										</a>
											<span>
											7 hours ago </span>
										<i class="fa fa-twitter blog-twiiter-icon"></i>
									</div>
								</div>
							</div>
							<!--end col-md-3-->
						</div>
						<ul class="pagination pull-right">
							<li>
								<a href="javascript:">
									<i class="fa fa-angle-left"></i>
								</a>
							</li>
							<li>
								<a href="javascript:">
									1 </a>
							</li>
							<li>
								<a href="javascript:">
									2 </a>
							</li>
							<li>
								<a href="javascript:">
									3 </a>
							</li>
							<li>
								<a href="javascript:">
									4 </a>
							</li>
							<li>
								<a href="javascript:">
									5 </a>
							</li>
							<li>
								<a href="javascript:">
									6 </a>
							</li>
							<li>
								<a href="javascript:">
									<i class="fa fa-angle-right"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		{{--<!-- END PAGE CONTENT INNER -->--}}
	</div>
</div>
	{{--<!-- END PAGE CONTENT -->--}}
@stop
