<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('meta_desc', 'Mattress Store')">
        <meta name="keywords" content="@yield('meta_key', 'shop, sleepare')">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>

        <link rel="icon" type="image/png" href="https://mk0sleeparej0clr43i7.kinstacdn.com/wp-content/themes/sleepare/images/favicon.png" />

        <link href="{{ asset('css/app-v2.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
        <script src="https://js.stripe.com/v3/"></script>

        <style>
            body {
                overflow-x: hidden;
            }

            #payment-element {
                margin-bottom: 0;
                padding-bottom: 20px;
                height:auto;
            }

            .error {
                color: #fa755a;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            #payment-form {
                width: 100%;
            }

            #payment-form .form-row.mb-3 {
                margin-bottom: 30px !important;
            }

            .card-body {
                overflow: visible !important;
                padding-bottom: 30px !important;
            }

            #checkout-btn {
                margin-top: 20px;
                clear: both;
            }

            @media (max-width: 768px) {
                body > div {
                    width: 100% !important;
                    padding: 10px;
                }
            }
        </style>

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body>
        <div style="width:600px; margin:0 auto;">

            @if(isset($email_logo) && $email_logo <> "")
                <?php
                    $logo = $email_logo;
                ?>
            @else
                <?php
                    $logo = URL::asset('images/logo.svg');
                ?>
            @endif


            <table style="font-family:sans-serif;margin:0px auto"  cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                    <tr style="font-family:sans-serif">
                        <td style="font-family:sans-serif;border-collapse:collapse;padding:30px" width="40%" bgcolor="#ffffff" align="left">
                            <a href="https://www.sleepare.com/" style="font-family:sans-serif" target="_blank">
                                <img alt="Sleepare" src="{{ $logo }}" border="0" width="200px" class="CToWUd">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;">
                <tbody>
                    <tr style="font-family:sans-serif">
                        <td style="border-top:0px solid rgb(255,255,255);color:rgb(63,63,60);font-size:24px;line-height:34px;font-family:sans-serif;border-collapse:collapse;padding:0px 30px" bgcolor="#ffffff" align="left">
                            <p style="margin-bottom:0px;font-family:sans-serif">Thanks for your <span class="il">SleePare</span> purchase!</p>
                            <p style="font-size:18px;line-height:1.5;font-family:sans-serif">Hi, {!! $customerName !!}! We've received your order and we will get started on it right away.<br style="font-family:sans-serif"></p>
                        </td>
                    </tr>
                    <tr style="font-family:sans-serif">
                        <td style="border-top:0px solid rgb(255,255,255);color:rgb(63,63,60);font-family:sans-serif;border-collapse:collapse;padding:10px;width:100%;" bgcolor="#ffffff" align="left">
                            <div class="col-md-12 mt-0 mb-4">
                                <div class="card">
                                    <div class="card-body" style="">

                                        <form id="payment-form" method="POST" action="/order/pay/link">
                                            @csrf
                                            <div class="form-row mb-0">
                                                <label for="payment-element">
                                                    <b>Payment Method</b>
                                                </label>
                                                <div id="payment-element">
                                                    <!-- A Stripe Payment Element will be inserted here. -->
                                                </div>

                                                <!-- Used to display form errors. -->
                                                <div id="payment-errors" class="error" role="alert"></div>
                                            </div>

                                            @if($ask_details == 1)
                                                <div class="form-row mb-3">
                                                    <label>Email</label>
                                                    <input class="form-control" type="text" name="user_email" id="user_email" required />
                                                </div>

                                                <div class="form-row mb-3">
                                                    <label>Number</label>
                                                    <input class="form-control" type="text" name="mobile_number" id="mobile_number" required/>
                                                </div>

                                                <div class="form-row mb-3">
                                                    <label>Address</label>
                                                    <input class="form-control" type="text" name="shipping_address" id="shipping_address" required />
                                                </div>

                                                <div class="form-row mb-3">
                                                    <label>State</label>
                                                    <input class="form-control" type="text" name="shipping_state" id="shipping_state" required />
                                                </div>

                                                <div class="form-row mb-3">
                                                    <label>Zip</label>
                                                    <input class="form-control" type="text" name="shipping_zip" id="shipping_zip" required />
                                                </div>


                                                <div class="form-row mb-3">
                                                    <label>How did you find us? (If it was through Google please tell us the keyword)</label>
                                                    <input class="form-control" type="text" name="findus" id="findus" required/>
                                                </div>

                                                <div class="form-row mb-3">
                                                    <label>Assisted</label>
                                                    <input class="form-control" type="text" name="assisted" id="assisted" />
                                                </div>
                                            @endif


                                            <input type="hidden" value="{{ $totalCost }}" name="total_cost">
                                            <input type="hidden" value="{{ $order_id }}" name="order_id">

                                            <div class="row" style="clear: both;">
                                                <div class="form-row col-md-4">
                                                    <input id="checkout-btn" class="btn btn-primary btn-block" type="submit" value="Pay ${{ $totalCost }}">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    {!! $orderItems !!}
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-size:16px;border-bottom:2px solid rgb(227,227,227);border-top:2px solid rgb(227,227,227);font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="right">
                            <p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Shipping:</span> ${{ $shipping_cost }} USD</p>
                            {!! $tax !!}
                            <p style="font-family:sans-serif;margin:0px"><span style="color:rgb(162,162,162);font-family:sans-serif">Total:</span><span style="font-size:18px;font-weight:bold;font-family:sans-serif"> ${!! $totalCost !!} USD</span></p>
                        </td>
                    </tr>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-family:sans-serif;border-collapse:collapse;padding:24px" align="center"><br></td>
                    </tr>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(169,169,169);font-size:12px;font-family:sans-serif;border-collapse:collapse">
                            <table style="color:rgb(169,169,169);font-size:12px;text-align:center;font-family:sans-serif;padding:0px 30px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody style="font-family:sans-serif">
                                    <tr style="font-family:sans-serif">
                                        <td style="font-family:sans-serif;border-collapse:collapse" valign="top" align="center">
                                            <p style="font-family:sans-serif">
                                            <b style="font-family:sans-serif">Questions or concerns?</b><br style="font-family:sans-serif">We're hear to help. Our office hours are <b>Weekdays</b> 10:00 am to 08:30 pm <b>Saturday</b> 10:00 am to 07:30 pm <b>Sunday</b> 10:00 am to 06:30 pm.</p>
                                            <p style="font-family:sans-serif">Call Us <a href="tel:+13479800044" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 (347) 980-0044</a></p>
                                            <p style="font-family:sans-serif">Email <a href="mailto:info@sleepare.com" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">info@sleepare.com</a></p>
                                        </td>
                                    </tr>
                                    <tr style="font-family:sans-serif">
                                        <td style="font-family:sans-serif;border-collapse:collapse">
                                            <p style="font-family:sans-serif">&copy; {{ date('Y') }} SleePare All rights reserved.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <body>
    <script>
        var stripe = Stripe('{{ config("stripe.key") }}');
        var clientSecret = '{{ $secretKey }}';

        var elements = stripe.elements({
            clientSecret: clientSecret
        });

        var paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            var submitButton = document.getElementById('checkout-btn');
            submitButton.disabled = true;
            submitButton.value = 'Processing...';

            // Prepare billing details
            var billingDetails = {};

            @if($ask_details == 1)
                billingDetails = {
                    email: document.getElementById('user_email').value,
                    phone: document.getElementById('mobile_number').value,
                    address: {
                        line1: document.getElementById('shipping_address').value,
                        state: document.getElementById('shipping_state').value,
                        postal_code: document.getElementById('shipping_zip').value,
                    }
                };
            @endif

            const {error, paymentIntent} = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ url("/order/link/thankyou") }}',
                    payment_method_data: {
                        billing_details: billingDetails
                    }
                },
                redirect: 'if_required'
            });

            if (error) {
                var errorElement = document.getElementById('payment-errors');
                errorElement.textContent = error.message;
                submitButton.disabled = false;
                submitButton.value = 'Pay ${{ $totalCost }}';
            } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                // Payment succeeded, submit form with payment details
                submitFormWithPaymentIntent(paymentIntent.id);
            }
        });

        function submitFormWithPaymentIntent(paymentIntentId) {
            var form = document.getElementById('payment-form');

            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_intent_id');
            hiddenInput.setAttribute('value', paymentIntentId);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
</html>
