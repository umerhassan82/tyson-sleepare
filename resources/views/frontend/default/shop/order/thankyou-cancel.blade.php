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
        
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body style="background-color: #eaeaea;">
        <div style="width:600px; margin:0 auto; background-color: #fff;">

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
                        <td style="font-family:sans-serif;border-collapse:collapse;padding:30px" width="100%" bgcolor="#ffffff" align="left">
                            <a href="https://www.sleepare.com/" style="font-family:sans-serif" target="_blank">
                                <img alt="Sleepare" src="{{ $logo }}" border="0" width="100px" class="CToWUd">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table>
                <tbody>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:0 30px" bgcolor="#ffffff" align="left">
                            <p style="margin-bottom:10px;font-family:sans-serif">Hello {{ $customerName }}, <br/>
                            Your cancellation request for order #{{ $order_id }} has been submitted. Kindly wait while we process it. You will be refunded within the next 24 hours.</p>
                            <p>Want to buy a new mattress? Check out our top recommended products here <a target="_blank" style="color:#243374;" href="https://www.sleepare.com/">sleepare.com</a>.</p>
                            <p style="font-style:italic;">- SleePare Customer Service Team</p>
                        </td>
                    </tr>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(169,169,169);font-size:12px;font-family:sans-serif;border-collapse:collapse">
                            <table style="color:rgb(169,169,169);font-size:12px; width: 100%; text-align:center;font-family:sans-serif;padding:0px 30px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody style="font-family:sans-serif">
                                    <tr style="font-family:sans-serif">
                                        <td style="font-family:sans-serif;border-collapse:collapse" valign="top" align="center">
                                            <p style="font-family:sans-serif">
                                            <b style="font-family:sans-serif">Questions or concerns?</b><br style="font-family:sans-serif">We're hear to help. Our office hours are <b>Weekdays</b> 10:00 am to 08:30 pm <b>Saturday</b> 10:00 am to 07:30 pm <b>Sunday</b> 10:00 am to 06:30 pm.</p>
                                            <p style="font-family:sans-serif">Call Us <a href="tel:+13474256001" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 347 4256001</a></p>
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
</html>