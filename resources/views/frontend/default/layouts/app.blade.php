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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="https://mk0sleeparej0clr43i7.kinstacdn.com/wp-content/themes/sleepare/images/favicon.png" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script type='text/javascript'>
    window.smartlook||(function(d) {
      var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
      var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
      c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
      })(document);
      smartlook('init', 'c33fa205a8a6bd9fd432433f9cfa848232a20929');
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

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="/vendor/laravel-admin/nprogress/nprogress.js"></script>
<script src="{{ asset('js/pjax.js') }}"></script>
<script src="{{ asset('js/core.js?6') }}"></script>

<script>
    $(document).ready(function(){
        $(document).on("change", ".optionField", function(){
            $(".error").remove();
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

        $(document).on("click", "#confirmProduct", function(){
            $("#product_form").submit();
        });

        $(document).on("click", "#addToCart", function(){
            var price = $(".optionField").val();
            var size = $(".optionField option:selected").attr("data-prodname");
            var title = $("#prod_title").val();
            var qty = $("#prod_qty").val();
            var firmness = $("#fimness_level").val();

            var discountedPrice = $("#discoutValue").val();

            if(discountedPrice != ""){
                price = +price - +discountedPrice;
            }

            $(".error").remove();
            if(price == 0){
                $(".optionField").after(`<label class="error">Please choose size</label>`);
                return false;
            }
            
            var html = "";

            html = `<ul>
                <li><span>Product Name</span>: ${title}</li>
                <li><span>Quantity</span>: ${qty}</li>
            `;
            
            if(size != undefined){
                html += `<li><span>Size</span>: ${size}</li>`;
            }

            if(price != 0){
                html += `<li><span>Price</span>: $${price}</li>`;
            }

            if(firmness != 0 && firmness != undefined){
                html += `<li><span>Firmness</span>: ${firmness}</li>`;
            }

            html += `</ul>`;

            $("#confrimProduct .modal-body").empty().append(html);

            $('#confrimProduct').modal({
                show: true
            });
        });

        $(document).on("change", "#cust_email", function(){
            $("#checkout-btn").attr("disabled", "disabled");

            if($('#cust_email').val() != ""){
                $.ajax({
                    type		: 'POST',
                    url			: '/checkmail',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data 		: {custemail: $('#cust_email').val()},

                    success		: function(data) {
                        if(data === "Bad"){
                            $('#cust_email').after('<p class="email-error" style="color:red; font-style:italic;">Invalid Email Address</p>');
                            return false;
                        }else{
                            $(".email-error").remove();
                            $("#checkout-btn").removeAttr("disabled");
                        }
                        return false;
                    },
                });
            }

        });

        $(document).on("change", ".preferTimeCheck input", function(){
            var changeVal = $(this).val();
            if(changeVal == 'yes'){
                $(".preferTime").show();
            }else{
                $(".preferTime").hide();
            }
        });

        $(document).on("change", "#shipping-field", function(){
            var getValue = $(this).val();
            $(".sub-option").hide();
            $("#sub-option-"+getValue).show();
        });
    });

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        // route: 'long_name',
        // locality: 'long_name',
        administrative_area_level_1: 'short_name',
        // country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), {types: ['geocode']});

        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(['address_component']);

        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle(
                {center: geolocation, radius: position.coords.accuracy});
            autocomplete.setBounds(circle.getBounds());
            });
        }
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3JQxBwv2_WJCBg-0GgRsFWMOfKUlMtEQ&libraries=places&callback=initAutocomplete" async defer></script>
</script>
</body>
</html>