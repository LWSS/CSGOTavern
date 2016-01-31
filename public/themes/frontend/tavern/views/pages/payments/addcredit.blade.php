@extends('layouts/tavern')

@section('page')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-university font-yellow-casablanca"></i>
                        <span class="caption-subject bold font-yellow-casablanca uppercase"> Add Tokens </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div>
                        <form role="form" action="{{ route('billing.addtokens.action') }}" id="payment-form" method="post">

                            <div class="form-body">
                                @include('sections.forms.payment-methods')
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn blue"> Submit</button>
                                <button type="button" class="btn default" onclick="window.location.href='/';"> Cancel
                                </button>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div> {{-- For proper Vertical Alignment --}}
    </div>
@stop