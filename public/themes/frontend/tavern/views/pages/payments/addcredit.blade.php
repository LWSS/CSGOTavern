@extends('layouts/tavern')

@section('page')
    <div class="row">
        {{--<div class="grid-25 grid-parent mobile-grid-100">--}}
        {{--<div class="portlet light">--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="grid-75 grid-parent mobile-grid-100">--}}
        <div class="col-md-4"></div>
        <div class="col-md-4">
            {{-- BEGIN Portlet PORTLET--}}
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-university font-yellow-casablanca"></i>
								<span class="caption-subject bold font-yellow-casablanca uppercase">
								Add Tokens </span>
                        {{--<span class="caption-helper">more samples...</span>--}}
                    </div>
                </div>
                <div class="portlet-body form">
                    {{--<div class="row"> --}}
                    <div>
                        <form role="form" action="{{ route('billing.addtokens.action') }}" id="payment-form" method="post">


                            <div class="form-body">


                                {{--<div class="form-group">--}}
                                {{--<label for="col-md-2 form_control_1">Current Balance</label>--}}
                                {{--<div class="col-md-2">--}}
                                {{--<div class="form-control form-control-static">--}}
                                {{--{{ $balance }}--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                @include('sections.forms.payment-methods')
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn blue">Submit</button>
                                <button type="button" class="btn default">Cancel</button>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
            {{-- END Portlet PORTLET--}}


        </div>

        <div class="col-md-4"></div>

    </div>
@stop