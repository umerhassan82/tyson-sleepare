<?php $__env->startSection('title', 'Cart'); ?>
<?php $__env->startSection('meta_desc', ''); ?>
<?php $__env->startSection('meta_key', ''); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo Breadcrumbs::render('cart'); ?>

    </div>
    <div class="col-md-12">
        <?php if( count($cart) > 0 ): ?>
            <div class="row">
                <div class="col-md-7">
                    <h3 style="margin-top: 0">Cart</h3>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('frontend.'.config('template').'.shop.cart.item', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <h4 class="text-left mt-4">Total: $<?php echo e($total*config('rate'), false); ?></h4>
                </div>
                <div class="col-md-5">
                    
                    <h3>Checkout</h3>
                    <div class="card">
                        <div class="card-body">
                            <form action="/checkout" method="post" id="payment-form">
                                <div class="form-row mb-3">
                                    <label for="card-element">
                                        <b>Credit or debit card</b>
                                    </label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>

                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" class="error" role="alert"></div>
                                </div>
                                <input type="hidden" value="<?php echo e($total*config('rate'), false); ?>" name="total_cost">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">

                                <button class="btn btn-primary btn-block">Submit Payment</button>
                            </form>
                        </div>
                    </div>
                    

                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Your Cart is empty!
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    var stripe = Stripe('pk_test_AvzHEE5hJxjtWWfcVBHUg9qj');

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
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });


    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {

        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        form.submit();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>