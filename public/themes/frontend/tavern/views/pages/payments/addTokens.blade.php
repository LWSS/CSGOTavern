@extends('layouts/tavern')

{{-- Page title --}}
@section('title')
    Add Tokens @parent
@stop

{{-- Meta description --}}
@section('meta-description')
@stop

@section('page')
    {{ Asset::queue('stripe', '//js.stripe.com/v2/stripe.js') }}
    <script type="text/javascript">
        Stripe.setPublishableKey({{ config('services.stripe.key') }});
    </script>
    <div class="row">
        <div class="col-md-12">
            Page content goes here
        </div>
    </div>
@stop