<?php $__env->startSection('title', 'Cart'); ?>
<?php $__env->startSection('meta_desc', ''); ?>
<?php $__env->startSection('meta_key', ''); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo Breadcrumbs::render('cart'); ?>

    </div>
    <div class="col-md-12">
        <?php
            $sessionForm = session()->get('checkout-form');
            $cart_tax = ($total*config('rate') * 6) / 100;
            $grand_total = $total*config('rate') + $cart_tax;

            
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

        <?php if( count($cart) > 0 ): ?>
            <div class="row">
                <div class="col-md-12">
                    <h3 style="margin-top: 0">Cart</h3>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $selected_item = $item;
                        ?>
                        <?php echo $__env->make('frontend.'.config('template').'.shop.cart.item', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <form method="POST" action="/place-order" id="payment-form">

                <div class="row">
                    <div class="col-md-12">
                          <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col totalPrices">
                                <div class="col-md-12 mt-4 pr-0">
                                    <h4 class="mt-2"><b>Tax:</b> $<span id="totalCost"><?php echo e(number_format($cart_tax, 2), false); ?></span></h4>
                                    <input type="hidden" id="cart_tax" name="cart_tax" value="<?php echo e(sprintf('%0.2f', $cart_tax), false); ?>" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mt-2"><b>Total:</b> $<span id="totalCost"><?php echo e(number_format($total*config('rate'), 2), false); ?></span></h4>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mt-2"><b>Grand Total:</b> $<span id="totalCost"><?php echo e(number_format($grand_total, 2), false); ?></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="accordion">

                    <?php if(Auth::check()): ?>
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
                    <?php endif; ?>
                
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
                                    <input type="hidden" value="<?php echo e($total*config('rate'), false); ?>" name="total_cost">
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
                            <input type="text" name="f_name" value="<?php echo e(isset($fsession['f_name'])?$fsession['f_name']:'', false); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Last Name</b></div>
                        <div class="col-md-12">
                            <input type="text" name="l_name"  value="<?php echo e(isset($fsession['l_name'])?$fsession['l_name']:'', false); ?>" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Clover Trans#</b></div>
                        <div class="col-md-12">
                            <input type="text" name="clover_trans" value="<?php echo e(isset($fsession['clover_trans'])?$fsession['clover_trans']:'', false); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Email</b></div>
                        <div class="col-md-12">
                            <input type="email" name="user_email" id="cust_email" value="<?php echo e(isset($fsession['user_email'])?$fsession['user_email']:'', false); ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Telephone#<span style="color:red;">*</span></b></div>
                        <div class="col-md-12">
                            <input type="text" name="mobile_num" value="<?php echo e(isset($fsession['mobile_num'])?$fsession['mobile_num']:'', false); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Address</b></div>
                        <div class="col-md-12">
                            <input type="text" id="autocomplete" placeholder="Enter your address" name="address" value="<?php echo e(isset($fsession['address'])?$fsession['address']:'', false); ?>" class="form-control">
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Apartment number</b></div>
                        <div class="col-md-12">
                            <input type="text" name="aprtment_num" id="street_number" value="<?php echo e(isset($fsession['aprtment_num'])?$fsession['aprtment_num']:'', false); ?>" class="form-control">
                        </div>
                    </div>
                    <!-- <div class="col">
                        <div class="col-lg-12"><b>City</b></div>
                        <div class="col-md-12">
                            <input type="text" id="locality" name="city" value=""  class="form-control">
                        </div>
                    </div> -->
                    <div class="col">
                        <div class="col-lg-12"><b>State</b></div>
                        <div class="col-md-12">
                            <input type="text" id="administrative_area_level_1" name="state" value="<?php echo e(isset($fsession['state'])?$fsession['state']:'', false); ?>"  class="form-control">
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Zip</b></div>
                        <div class="col-md-12">
                            <input type="text" id="postal_code" name="zipcode" value="<?php echo e(isset($fsession['zipcode'])?$fsession['zipcode']:'', false); ?>"  class="form-control">
                        </div>
                    </div>
                    <div class="col d-flex">
                        <div class="col-lg-6">
                            <b>Shipping</b>
                            <select id="shipping-field" name="shippingType" class="form-control">
                                <option value="0">Choose Option</option>
                                <option value="1">Regular shipping immediatly</option>
                                <option value="2">White Glove shipping immediately</option>
                                <option value="3">Picked up</option>
                                <option value="4">Will Pick up</option>
                                <option value="5">Partly Pick up</option>
                                <option value="6">Delayed - Regular</option>
                                <option value="7">Delayed - White Glove</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col">
                            
                            <div id="sub-option-1" class="sub-option">
                                <b>Assembly</b>    
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-1" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-1" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>
    
                                <b>Mattress Removal</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-2-1" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-2-1" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>
                            </div> <!-- Option 1  -->
    
                            <div id="sub-option-2" class="sub-option">
                                <b>Assembly</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-2" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-2" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>

                                <b>Mattress Removal</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-2-1" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-2-1" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>
                            </div> <!-- Option 2  -->
    
                            <div id="sub-option-3" class="sub-option">
                                <b>Picked up</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <p>Print Receipt with delivered certificate</p>
                                </div>
                            </div> <!-- Option 3  -->
    
                            <div id="sub-option-4" class="sub-option">
                                <b>Product in stock</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-4" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-4" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>
                            </div> <!-- Option 4  -->
    
                            <div id="sub-option-5" class="sub-option">
                                <b>Please Specify what was picked up and suppose to be ordered</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <input type="text" name="option-5" class="form-control">
                                </div>
                            </div> <!-- Option 5  -->
    
                            <div id="sub-option-6" class="sub-option">
                                <b>Please enter the first day when you will be ready to receive the product</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <input type="date" min="<?php echo(date('Y-m-d')); ?>" name="option-6" class="form-control">
                                </div>
                            </div> <!-- Option 6  -->
    
                            <div id="sub-option-7" class="sub-option">
                                <b>Please choose a date to deliver</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <input type="date" min="<?php echo(date('Y-m-d')); ?>" name="option-7" class="form-control">
                                </div>
                                <br />
                                <b>Is there a specific time you prefer?</b>
                                <div class="d-flex align-items-center justify-content-start preferTimeCheck pt-2">
                                    <label><input type="radio" name="option-7" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-7" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>
                                <select name="option-7-1" class="form-control preferTime">
                                    <option value="morning">Morning</option>
                                    <option value="afternoon">Afternoon</option>
                                </select>
                                <br />
                                <b>Assembly</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-2" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-2" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>

                                <b>Mattress Removal</b>
                                <div class="d-flex align-items-center justify-content-start pt-2">
                                    <label><input type="radio" name="option-2-1" value="yes" class="m-1"><span>Yes</span></label>
                                    <label><input type="radio" name="option-2-1" value="no" class="m-1 ml-3"><span>No</span></label>
                                </div>
                            </div> <!-- Option 6  -->
                        </div>
                    </div>
    
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Count</b></div>
                        <div class="col-md-12">
                            <input type="text" name="count" value="<?php echo e($selected_item['qty'], false); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Paid Amount</b></div>
                        <div class="col-md-12">
                            <input type="text" id="paid_amount" name="paid_amount" value="<?php echo e(sprintf('%0.2f', $grand_total), false); ?>" class="form-control">
                            <input type="hidden" id="orignal_price" name="orignal_price" value="<?php echo e($total*config('rate'), false); ?>" />
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col">
                        <div class="col-lg-12"><b>Status</b></div>
                        <div class="col-md-12">
                            <input type="text" name="status" value="<?php echo e(isset($fsession['status'])?$fsession['status']:'', false); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>Note</b></div>
                        <div class="col-md-12">
                            <input type="text" name="note" value="<?php echo e(isset($fsession['note'])?$fsession['note']:'', false); ?>" class="form-control">
                        </div>
                    </div>
    
                </div>
    
                <div class="row mb-3">
                    <!-- <div class="col">
                        <div class="col-lg-12"><b>Tracking Receipt Status</b></div>
                        <div class="col-md-12">
                            <input type="text" name="tracking" value="" class="form-control">
                        </div>
                    </div> -->
                    <div class="col">
                        <div class="col-lg-12"><b>Assisted</b></div>
                        <div class="col-md-12">
                            <select class="form-control" name="assisted" id="assisted" required>
                                <option value="">Choose</option>
                                <?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key, false); ?>"><?php echo e($person, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col-lg-12"><b>How did you find us? (If it was through Google please tell us the keyword)</b></div>
                        <div class="col-md-12">
                            <input type="text" name="findus" id="findus" value="<?php echo e(isset($fsession['findus'])?$fsession['findus']:'', false); ?>" class="form-control" required>
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

        <?php else: ?>
            <div class="alert alert-warning text-center">
                Your Cart is empty!
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            $(document).ready(function(){
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
                var stripe = Stripe('<?php echo e(config("services.stripe.key"), false); ?>');
        
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>