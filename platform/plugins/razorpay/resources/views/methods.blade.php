@if (get_payment_setting('status', RAZORPAY_PAYMENT_METHOD_NAME) == 1)
    <li class="list-group-item">
        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_{{ RAZORPAY_PAYMENT_METHOD_NAME }}"
               value="{{ RAZORPAY_PAYMENT_METHOD_NAME }}" data-toggle="collapse" data-target=".payment_{{ RAZORPAY_PAYMENT_METHOD_NAME }}_wrap"
               data-parent=".list_payment_method"
               @if (setting('default_payment_method') == RAZORPAY_PAYMENT_METHOD_NAME) checked @endif
        >
        <label for="payment_{{ RAZORPAY_PAYMENT_METHOD_NAME }}">{{ get_payment_setting('name', RAZORPAY_PAYMENT_METHOD_NAME) }}</label>
        <div class="payment_{{ RAZORPAY_PAYMENT_METHOD_NAME }}_wrap payment_collapse_wrap collapse @if (setting('default_payment_method') == RAZORPAY_PAYMENT_METHOD_NAME) show @endif">
            <p>{!! get_payment_setting('description', RAZORPAY_PAYMENT_METHOD_NAME, __('Payment with Razorpay')) !!}</p>
        </div>
        <input type="hidden" id="rzp_order_id" value="{{ $orderId }}">
    </li>

    <script>
        $(document).ready(function () {

            var validatedAddressForm = function () {
                return ($('#address_id').val() && $('#address_id').val() != 'new') || ($('#address_country').val() && $('#address_state').val() && $('#address_city').val() && $('#address_address').val() && $('#address_name').val() && $('#address_email').val() && $('#address_phone').val());
            }

            $('.payment-checkout-form').on('submit', function (e) {
                if (validatedAddressForm() && $('input[name=payment_method]:checked').val() === 'razorpay' && !$('input[name=razorpay_payment_id]').val()) {
                    e.preventDefault();
                }
            });

            var loadExternalScript = function(path) {
                var result = $.Deferred(),
                    script = document.createElement('script');

                script.async = 'async';
                script.type = 'text/javascript';
                script.src = path;
                script.onload = script.onreadystatechange = function(_, isAbort) {
                    if (!script.readyState || /loaded|complete/.test(script.readyState)) {
                        if (isAbort) {
                            result.reject();
                        }
                        else {
                            result.resolve();
                        }
                    }
                };

                script.onerror = function() {
                    result.reject();
                };

                $('head')[0].appendChild(script);

                return result.promise();
            }

            var callRazorPayScript = function() {
                loadExternalScript('https://checkout.razorpay.com/v1/checkout.js').then(function() {

                    var options = {
                        key: '{{ get_payment_setting('key', RAZORPAY_PAYMENT_METHOD_NAME) }}',
                        name: '{{ $name }}',
                        description: '{{ $name }}',
                        order_id: $('#rzp_order_id').val(),
                        handler: function (transaction) {
                            var form = $('.payment-checkout-form');
                            form.append($('<input type="hidden" name="razorpay_payment_id">').val(transaction.razorpay_payment_id));
                            form.append($('<input type="hidden" name="razorpay_order_id">').val(transaction.razorpay_order_id));
                            form.append($('<input type="hidden" name="razorpay_signature">').val(transaction.razorpay_signature));
                            form.submit();
                        }
                    };

                    window.rzpay = new Razorpay(options);
                    rzpay.open();
                });
            }

            $(document).off('click', '.payment-checkout-btn').on('click', '.payment-checkout-btn', function (event) {
                event.preventDefault();

                var _self = $(this);
                var form = _self.closest('form');
                if (validatedAddressForm()) {
                    _self.attr('disabled', 'disabled');
                    var submitInitialText = _self.html();
                    _self.html('<i class="fa fa-gear fa-spin"></i> ' + _self.data('processing-text'));

                    var method = $('input[name=payment_method]:checked').val();

                    if (method === 'stripe') {
                        Stripe.setPublishableKey($('#payment-stripe-key').data('value'));
                        Stripe.card.createToken(form, function (status, response) {
                            if (response.error) {
                                if (typeof Botble != 'undefined') {
                                    Botble.showError(response.error.message, _self.data('error-header'));
                                } else {
                                    alert(response.error.message);
                                }
                                _self.removeAttr('disabled');
                                _self.html(submitInitialText);
                            } else {
                                form.append($('<input type="hidden" name="stripeToken">').val(response.id));
                                form.submit();
                            }
                        });
                    } else if (method === 'razorpay') {

                        callRazorPayScript();

                        _self.removeAttr('disabled');
                        _self.html(submitInitialText);
                    } else {
                        form.submit();
                    }
                } else {
                    form.submit();
                }
            });
        });
    </script>
@endif
