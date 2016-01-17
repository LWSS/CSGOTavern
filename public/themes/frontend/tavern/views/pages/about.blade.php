@extends('layouts/blank')

{{-- Page title --}}
@section('title')
@parent
{{ $page->meta_title or $page->name }}
@stop

{{-- Meta description --}}
@section('meta-description')
	{{ $page->meta_description }}
@stop

{{-- Queue styles/scripts --}}
{{ Asset::queue('about', 'platform/less/about.less', 'style') }}

{{-- Page content --}}
@section('page')

<div class="base">

	<div class="page">

		<div class="about">

			<a href="{{ URL::to('/') }}" class="btn btn-lg btn-return"><i class="fa fa-mail-reply"></i> Back</a>

			<div class="brand">
				<img class="svg fade-in" src="{{ Asset::getUrl('platform/img/ornery-octopus.svg') }}" alt="Ornery Octopus">
			</div>

			<div class="credits">

				<div class="title">

					<div>

						<h1>@setting('platform.app.title' )</h1>

						<p class="subtitle">@setting('platform.app.tagline' ) </p>

					</div>

				</div>

				@content('credits', 'credits.html')

			</div>

		</div>

		<div class="version">
			@setting('platform-foundation.release_name' ) - v@setting('platform-foundation.installed_version' )
		</div>

	</div>

</div>

@stop
