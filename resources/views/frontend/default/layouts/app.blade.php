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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

@include('frontend.default.partials.nav')

<section class="container mainCnts">
    <div id="pjax-container">
        @yield('content')
    </div>
</section>

<footer class="footer-classic context-dark pt-5 pb-5">
    <div class="container">
        <div class="row row-30">
            <div class="col-md-6 col-xl-6">
                <div class="pr-xl-4">
                    <p>{{ config('text_on_footer') }}</p>
                    <p class="rights">&copy;  {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<script src="/vendor/laravel-admin/nprogress/nprogress.js"></script>
<script src="{{ asset('js/pjax.js') }}"></script>
<script src="{{ asset('js/core.js?6') }}"></script>

<script>
    $(document).ready(function(){
        $(document).on("change", ".optionField", function(){
            $(".show_price").text($(this).val());
            $("#product_size").val($(this).find('option:selected').attr("data-prodname"));
        });

        $("#pjax-container input").change(function(){
            var formData = $("#pjax-container form").serialize();

            $.ajax({
                type: "GET",
                url: "/formdata/"+formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {

                }
            });

        });

    });
</script>
</body>
</html>