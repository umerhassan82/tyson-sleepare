<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Thank You - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="https://mk0sleeparej0clr43i7.kinstacdn.com/wp-content/themes/sleepare/images/favicon.png" />
        <link href="{{ asset('css/app-v2.css') }}" rel="stylesheet">
    </head>
    <body>
        <div style="max-width:600px; margin:50px auto; padding:20px; text-align:center;">
            <h1>Thank You!</h1>
            <p>Your payment has been processed successfully.</p>
            <p>You will receive a confirmation email shortly.</p>
            <a href="https://www.sleepare.com/" style="display:inline-block; margin-top:20px; padding:10px 20px; background-color:#007bff; color:white; text-decoration:none; border-radius:5px;">Return to Home</a>
        </div>
    </body>
</html>
