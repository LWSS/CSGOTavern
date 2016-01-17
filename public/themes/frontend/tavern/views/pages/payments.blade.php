@extends('layouts/tavern')
@section('scripts')
    @parent
@stop

@section('page')
    <h1>Charge $10 with Stripe</h1>

    <form action="" method="POST" id="payment-form">
        {!! csrf_field() !!}
        <span class="payment-errors"></span>

        <div class="form-row">
            <label>
                <span>Card Number</span>
                <input value="4242424242424242" type="text" size="20" data-stripe="number"/>
            </label>
        </div>

        <div class="form-row">
            <label>
                <span>CVC</span>
                <input value="555" type="text" size="4" data-stripe="cvc"/>
            </label>
        </div>

        <div class="form-row">
            <label>
                <span>Expiration (MM/YYYY)</span>
                <input value="12" type="text" size="2" data-stripe="exp-month"/>
            </label>
            <span> / </span>
            <input value="2020" type="text" size="4" data-stripe="exp-year"/>
        </div>

        <div class="form-row">
            <label>
                <span>Amount to Donate</span>
                <input value="10.00" type="text" size="4" name="amount"/>
            </label>
        </div>

        <button type="submit">Submit Payment</button>
    </form>
@stop