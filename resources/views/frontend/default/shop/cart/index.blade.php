@extends('frontend.'.config('template').'.layouts.app')

@section('title', 'Cart')
@section('meta_desc', '')
@section('meta_key', '')

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Breadcrumbs::render('cart') !!}
    </div>
    <div class="col-md-12">
        <?php
            $sessionForm = session()->get('checkout-form');
            $cart_tax = ($total * 6) / 100;
            $grand_total = $total + $cart_tax;
            
            if(!empty($sessionForm)){
                $fields  = explode("&", $sessionForm);

                $fsession = array();
                foreach($fields as $field){
                    $explodeField = explode("=", $field);

                    if(isset($explodeField[1])){
                        $fsession[$explodeField[0]] = $explodeField[1];
                    }else{
                        $fsession[$explodeField[0]] = "";
                    }
                }
            }
        ?>

        @if( count($cart) > 0 )
            <form method="POST" action="/place-order" id="payment-form">
                <div class="row">
                    <div class="col-md-12">
                        <h3 style="margin-top: 0">Cart</h3>
                        @foreach ($cart as $item)
                            <?php
                                $selected_item = $item;
                            ?>
                            @include ('frontend.'.config('template').'.shop.cart.item', ['item' => $item])
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                          <div class="col col-8"></div>  
                          <div class="col col-4 totalPrices">
                              <div class="col-md-12 mt-4">
                                  <h4 class="mt-2">
                                      <b>Total:</b> 
                                      <span class="text-secondary">$</span><span class="text-secondary" id="total-cost">{{ number_format($total*config('rate'), 2) }}</span>
                                  </h4>
                              </div>
                              <div class="col-md-12">
                                  <h4 class="mt-2">
                                      <b>Shipping:</b> 
                                      <span class="text-secondary">$</span><span class="text-secondary" id="total-shipping">0.00</span>
                                  </h4>
                              </div>
                              <div class="col-md-12 pr-0">
                                  <h4 class="mt-2">
                                      <b>Tax:</b> 
                                      <span class="text-secondary">$</span><span class="text-secondary" id="cart-tax">{{ number_format($cart_tax, 2) }}</span>
                                  </h4>
                                  <input type="hidden" id="cart_tax" name="cart_tax" value="{{ round($cart_tax, 2) }}" class="form-control">
                              </div>
                              <div class="col-md-12 mb-4 mt-3">
                                  <h4 class="mt-2">
                                      <b>Grand Total:</b> 
                                      $<span id="grand-total">{{ number_format($grand_total, 2) }}</span>
                                  </h4>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div id="accordion">
                    @if(Auth::check())
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <label class="btn btn-link mb-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <input type="radio" value="1" class="mr-2 paymentType" checked name="paymentType" /> Paid Clover
                                    </label>
                                    <label class="btn btn-link mb-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <input type="radio" value="3" class="mr-2 paymentType" checked name="paymentType" /> Financing
                                    </label>
                                </h5>
                            </div>
                        </div>
                    @endif
                
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <label class="btn btn-link collapsed mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <input type="radio" value="2" checked class="mr-2 paymentType" name="paymentType" /> Credit or debit card
                                </label>
                                <img class="paymentLogos" src="/images/image.png" />
                            </h5>
                        </div>
                        <div id="" class="" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">

                                <div class="col-md-12 mt-4 mb-4">
                                    <div class="form-row mb-3">
                                        <div id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                        </div>
                
                                        <!-- Used to display form errors. -->
                                        <div id="card-errors" class="error" role="alert"></div>
                                    
                                    </div>
                                    <input type="hidden" value="{{ $total*config('rate') }}" name="total_cost">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>    

                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="mt-3 mb-3">Checkout Form</h4>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>First Name<span style="color:red;">*</span></b></div>
                        <div class="col-md-12">
                            <input type="text" name="f_name" value="{{ isset($fsession['f_name'])?$fsession['f_name']:'' }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Last Name</b></div>
                        <div class="col-md-12">
                            <input type="text" name="l_name"  value="{{ isset($fsession['l_name'])?$fsession['l_name']:'' }}" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Clover Trans#</b></div>
                        <div class="col-md-12">
                            <input type="text" name="clover_trans" value="{{ isset($fsession['clover_trans'])?$fsession['clover_trans']:'' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Email</b></div>
                        <div class="col-md-12">
                            <input type="email" name="user_email" id="cust_email" value="{{ isset($fsession['user_email'])?$fsession['user_email']:'' }}" class="form-control" required>
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Telephone#<span style="color:red;">*</span></b></div>
                        <div class="col-md-12">
                            <input type="text" name="mobile_num" value="{{ isset($fsession['mobile_num'])?$fsession['mobile_num']:'' }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Address</b></div>
                        <div class="col-md-12">
                            <input type="text" id="autocomplete" placeholder="Enter your address" name="address" value="{{ isset($fsession['address'])?$fsession['address']:'' }}" class="form-control">
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Apartment number</b></div>
                        <div class="col-md-12">
                            <input type="text" name="aprtment_num" id="street_number" value="{{ isset($fsession['aprtment_num'])?$fsession['aprtment_num']:'' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>State</b></div>
                        <div class="col-md-12">
                            <input type="text" id="administrative_area_level_1" name="state" value="{{ isset($fsession['state'])?$fsession['state']:'' }}"  class="form-control">
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col col-6">
                        <div class="col-lg-12"><b>Zip</b></div>
                        <div class="col-md-12">
                            <input type="text" id="postal_code" name="zipcode" value="{{ isset($fsession['zipcode'])?$fsession['zipcode']:'' }}"  class="form-control">
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Count</b></div>
                        <div class="col-md-12">
                            <input type="text" name="count" value="{{ $selected_item['qty'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Paid Amount</b></div>
                        <div class="col-md-12">
                            <input type="text" id="paid_amount" name="paid_amount" value="{{ sprintf('%0.2f', $grand_total) }}" class="form-control">
                            <input type="hidden" id="orignal_price" name="orignal_price" value="{{ $total*config('rate') }}" />
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Status</b></div>
                        <div class="col-md-12">
                            <input type="text" name="status" value="{{ isset($fsession['status'])?$fsession['status']:'' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Note</b></div>
                        <div class="col-md-12">
                            <input type="text" name="note" value="{{ isset($fsession['note'])?$fsession['note']:'' }}" class="form-control">
                        </div>
                    </div>
    
                </div>
    
                <div class="row mb-3">
                    <!-- <div class="col">
                        <div class="col-lg-12"><b>Tracking Receipt Status</b></div>
                        <div class="col-md-12">
                            <input type="text" name="tracking" value="{{-- isset($fsession['tracking'])?$fsession['tracking']:'' --}}" class="form-control">
                        </div>
                    </div> -->
                    <div class="col">
                        <div class="col-lg-12"><b>Assisted</b></div>
                        <div class="col-md-12">
                            <select class="form-control" name="assisted" id="assisted" required>
                                <option value="">Choose</option>
                                @foreach ($persons as $key => $person)
                                    <option value="{{ $key }}">{{ $person }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>How did you find us? (If it was through Google please tell us the keyword)</b></div>
                        <div class="col-md-12">
                            <input type="text" name="findus" id="findus" value="{{ isset($fsession['findus'])?$fsession['findus']:'' }}" class="form-control" required>
                            <div id="keyword-dropdown" class="col-md-12 bootstrap-autocomplete dropdown-menu" style="top: 40px; left: 14px; width: 95%; height: 210px; overflow-y: scroll; "></div>
                        </div>
                    </div>
                </div>
    
                <div class="mb-5">
                    <div class="col-md-5">
                        <input id="checkout-btn" class="btn btn-primary btn-block" type="submit" value="Place Order">
                    </div>
                </div>
            </form>

        @else
            <div class="alert alert-warning text-center">
                Your Cart is empty!
            </div>
        @endif
    </div>
</div>

@endsection

@section('bottom-js')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            $(document).ready(function(){
                var whiteGlovesShipping = 190;
                var whiteGlovesShippingAndRemoval = whiteGlovesShipping + 95;
                var dropOffCost = 100;
                var whiteGlovesShippingForBase = 240;
                var dropOffCostBase = 120;

                var totalElem = $("#orignal_price");
                var getCurrentTotal = totalElem.val();

                $(document).on("change", ".shipping-field", function(){    
                    var shippingValue = $(this).val();
                    var productValue = $("option:selected", this).attr('data-product');

                    switch (shippingValue) {
                        case "2": case "7":
                            updateShippingInTotal(whiteGlovesShipping, productValue);
                        break;
                        case "8":
                            updateShippingInTotal(dropOffCost, productValue);
                        break;
                        case "10":
                            updateShippingInTotal(whiteGlovesShippingForBase, productValue);
                        break;
                        case "11":
                            updateShippingInTotal(dropOffCostBase, productValue);
                        break;
                        default: 
                            updateShippingInTotal(0, productValue);
                        break;
                    }
                });

                $(document).on("change", ".item-shipping-cost", function () { 
                    updateGrandTotal();
                });

                $(document).on("change", ".removal-shipping", function(){
                    var shippingValue = $(this).val();
                    var productValue = $(this).attr('data-product');
                    var shippingType = $("#shipping-field-"+productValue).val();

                    if(shippingType == 1) {
                        if(shippingValue == 'yes') {
                            updateShippingInTotal(whiteGlovesShipping, productValue);
                        } else {
                            updateShippingInTotal(0, productValue);
                        }
                    } else {
                        if(shippingValue == 'yes'){
                            updateShippingInTotal(whiteGlovesShippingAndRemoval, productValue);
                        }else{
                            updateShippingInTotal(whiteGlovesShipping, productValue);
                        }
                    }
                });

                function updateShippingInTotal(cost, productValue){
                    showShipping(cost, productValue);
                    if(cost == 0) {
                        hideShipping(productValue);
                    }
                    updateGrandTotal();
                }

                function updateGrandTotal() {
                    let totalShippingCost = 0;
                    $(".item-shipping-cost").each(function(i, item) {
                        let singleVal = $(item).val();
                        totalShippingCost += +singleVal;
                    });

                    var total = +getCurrentTotal + +totalShippingCost;
                    var taxTotal = (+total * 6) / 100;
                    var grandTotal = +getCurrentTotal + +totalShippingCost + +taxTotal;

                    $("#shipping-cost").val(totalShippingCost);
                    $("#cart_tax").val(taxTotal);

                    $("#total-shipping").html(totalShippingCost.toFixed(2));
                    $("#cart-tax").html(taxTotal.toFixed(2));
                    $("#grand-total").html(grandTotal.toFixed(2));
                    $("#paid_amount").val(grandTotal.toFixed(2));
                }

                function showShipping(price, productValue){
                    $("#shippingCost-"+productValue).val(price.toFixed(2));
                }

                function hideShipping(productValue){
                    $("#shippingCost-"+productValue).val("0.0");
                }

                $('#findus').on('input', function() {
                    getKeywordOptions();
                }); // end

                $('#findus').on('click', function() {
                    getKeywordOptions();
                }); // end

                function getKeywordOptions(){
                    var val = $('#findus').val();
                    $.ajax({
                        type: "GET",
                        url: "/get/keywords/"+val,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            // console.log(result);
                            if(result != ''){
                                $("#keyword-dropdown").empty().append(result);
                                $('#keyword-dropdown').addClass('show');
                            }else{
                                $('#keyword-dropdown').removeClass('show');            
                            }
                        }
                    });
                }

                $(document).on("click", ".dropdown-item", function(){
                    var value = $(this).attr('data-value');
                    $("#findus").val(value);
                    $('#keyword-dropdown').removeClass('show');
                });

                // ----------------------------------------- Stripe
                var stripe = Stripe('{{ config("services.stripe.key") }}');
        
                var elements = stripe.elements();
                var style = {
                    base: {
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                        color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                var card = elements.create('card', {style: style});

                card.mount('#card-element');

                card.addEventListener('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    // var byPass = document.getElementById('passValidation').checked;

                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });


                var form = document.getElementById('payment-form');

                form.addEventListener('submit', function(event) {

                    var paymentType = document.querySelector('input[name="paymentType"]:checked').value;

                    // alert(paymentType);
                    // return false;

                    if(paymentType == 1){
                        document.getElementById("checkout-btn").disabled = true;
                        form.submit();
                        return false;
                    }else if(paymentType == 3){
                        event.preventDefault();
                        // go to klarna checkout page
                        window.location.href = '/klarna/checkout';
                        return false;
                    }else{
                        
                        event.preventDefault();
                        // var byPass = document.getElementById('passValidation').checked;
                        // console.log(byPass);
                        stripe.createToken(card).then(function(result) {
                            if (result.error) {
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = result.error.message;
                            } else {
                                document.getElementById("checkout-btn").disabled = true;
                                stripeTokenHandler(result.token);
                            }
                        });

                    }

                });
                function stripeTokenHandler(token) {
                    // var byPass = document.getElementById('passValidation').checked;
                    var form = document.getElementById('payment-form');

                    // var hiddenInput1 = document.createElement('input');
                    // hiddenInput1.setAttribute('type', 'hidden');
                    // hiddenInput1.setAttribute('name', 'passValidation');
                    // hiddenInput1.setAttribute('value', byPass);
                    // form.appendChild(hiddenInput1);


                    // if(!byPass){
                        var hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'stripeToken');
                        hiddenInput.setAttribute('value', token.id);
                        form.appendChild(hiddenInput);
                    // }

                    form.submit();
                }
            });
        </script>
@endsection