<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale'), false); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_desc', 'Mattress Store'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta_key', 'shop, sleepare'); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <link rel="icon" type="image/png" href="https://mk0sleeparej0clr43i7.kinstacdn.com/wp-content/themes/sleepare/images/favicon.png" />
    <link href="<?php echo e(asset('css/app.css'), false); ?>" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
<body>

<?php echo $__env->make('frontend.default.partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<section class="container mainCnts">
    <div id="pjax-container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</section>

<footer class="footer-classic context-dark pt-5 pb-5">
    <div class="container">
        <div class="row row-30">
            <div class="col-md-6 col-xl-6">
                <div class="pr-xl-4">
                    <p><?php echo e(config('text_on_footer'), false); ?></p>
                    <p class="rights">&copy;  <?php echo e(date('Y'), false); ?> <?php echo e(config('app.name'), false); ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo e(asset('js/app.js'), false); ?>"></script>
<script src="/vendor/laravel-admin/nprogress/nprogress.js"></script>
<script src="<?php echo e(asset('js/pjax.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/core.js?6'), false); ?>"></script>

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