@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Profile @parent
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
{{ Asset::queue('components-editors', 'admin/pages/scripts/components-editors.js', ['js-bootstrap-fileinput', 'bootstrap']) }}


@section('scripts')
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core components
            Layout.init(); // Used for the Menu Dropdown
        });
    </script>
    @stop

    {{-- Page Header --}}
    @section('header')

            <!-- Full Width Image Header -->
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