@section('scripts')
    @parent
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey('{{ Config::get('services.stripe.key') }}');

        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        }
        ;

        jQuery(function ($) {
            $('#payment-form').submit(function (event) {
                if ($('#payment-form select[name="payment_method"] option:selected').val() == 'credit-card') {
                    var $form = $(this);

                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

                    Stripe.card.createToken($form, stripeResponseHandler);

                    // Prevent the form from submitting with the default action
                    return false;
                } else {
                    $form.get(0).submit();
                }
            });

            $('#payment-form select[name="payment_method"]').change(function () {
                if ($('#payment-form select[name="payment_method"] option:selected').val() == 'credit-card') {
                    $('#new_card').show();
                    $("#new_card input").prop('required',true);
                    $("#new_card select").prop('required',true);
                } else {
                    $('#new_card').hide();
                    $("#new_card input").prop('required',false);
                    $("#new_card select").prop('required',false);
                }
            });

            $('#payment-form select[id="address-book"]').change(function () {
                if ($('#payment-form select[id="address-book"] option:selected').val() == -1) {
                    $('#new_billing_address').show();
                    $("#new_billing_address input").prop('required',true);
                    $("#new_billing_address select").prop('required',true);
                } else {
                    $('#new_billing_address').hide();
                    $("#new_billing_address input").prop('required',false);
                    $("#new_billing_address select").prop('required',false);
                }
            });

        });
    </script>
@stop
<div class="form-group">
    <label for="tokens">Tokens to Purchase</label>
    <input type="text" name="tokens" id="tokens" class="form-control" placeholder="Enter amount" tabindex="1" required="required">
    {{--<span class="input-group-addon">.00</span>--}}

</div>

{{--@foreach ($cards as $card)--}}
{{--<i class="{{ 'fa fa-cc-'.Stripe::getCardSlug($card['brand']) . ' fa-3' }}" style="font-size: 4em;"></i><br><br><br>--}}
{{--@endforeach--}}

<div class="form-group">


    <label class="control-label" for="form_control_1">Pay with</label>


    <select class="form-control" id="form_control_1" name="payment_method" tabindex="2">
        @if($hasCards)
            <optgroup label="Saved Payment Methods">

                {{--<option value=""></option>--}}
                {{--<i class="{{ 'fa fa-cc-'.Stripe::getCardSlug($card['brand']) . ' fa-3' }}"></i>--}}
                @foreach ($cards as $card)
                    <option data-icon="fa-cc-visa"
                            value="{{ $card->id }}" {{ ($card->default ? 'selected="selected"' : null ) }}>{{

                strtoupper($card->brand)  .' '.  $card->last_four
                }}</option>
                @endforeach

            </optgroup>

            <optgroup label="Other Payment Methods">
                @endif
                <option value="credit-card">
                    Credit Card
                </option>
                <option value="balance">
                    Vionox Balance
                </option>
                @if(count($cards)>0)
            </optgroup>
        @endif

    </select>

</div>

<div id="new_card" style="display: {{ (count($cards) > 0) ? 'none': 'block' }};">

    <div class="form-group">
        <label>Card Number</label>
        <input placeholder="Card number" aria-label="Card number" type="tel"
               class="form-control"
               id="card-number" tabindex="3" data-stripe="number"
               @if(!$hasCards)required="required"@endif>
    </div>

    <label class="control-label css-label" for="expiration-month">Expiration
        Date</label>

    <div class="row">


        <div class="col-md-6">
            <div class="form-group">
                <select class="form-control" tabindex="4"
                        id="expiration-month" @if(!$hasCards)required="required"@endif data-stripe="exp-month">
                    <option value="" selected="selected" data-placeholder="placeholder">
                        Month
                    </option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <select class="form-control" tabindex="5" id="expiration-year" data-stripe="exp-year"
                        data-placeholder="placeholder" @if(!$hasCards)required="required"@endif>
                    <option value="" selected="selected">
                        Year
                    </option>
                    <option value="15">2015</option>
                    <option value="16">2016</option>
                    <option value="17">2017</option>
                    <option value="18">2018</option>
                    <option value="19">2019</option>
                    <option value="20">2020</option>
                    <option value="21">2021</option>
                    <option value="22">2022</option>
                    <option value="23">2023</option>
                    <option value="24">2024</option>
                    <option value="25">2025</option>
                    <option value="26">2026</option>
                    <option value="27">2027</option>
                    <option value="28">2028</option>
                    <option value="29">2029</option>
                    <option value="30">2030</option>
                    <option value="31">2031</option>
                    <option value="32">2032</option>
                    <option value="33">2033</option>
                    <option value="34">2034</option>
                    <option value="35">2035</option>
                </select>
            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label tooltipstered" for="verification-code">
            <span id="verification-code-label">Security Code</span>
            <span class="icon-question-circle"></span>
        </label>

        <div class="controls">
            <input type="tel"
                   id="verification-code"
                   tabindex="6" placeholder="CVC" aria-label="Security code" maxlength="4"
                   onpaste="return false;" data-stripe="cvc"
                   @if(!$hasCards)required="required"@endif/> <span class="help-icon"></span>
        </div>
    </div>


    <div class="form-group">
        <div class="checkbox-list">
            <label for="save-payment">
                <input type="checkbox" id="save-payment" name="save" value="TRUE" checked="checked"> Save this
                payment method for later. </label>
        </div>
    </div>


    <legend>Billing Information</legend>
    @include('sections.forms.billing-information')
</div>