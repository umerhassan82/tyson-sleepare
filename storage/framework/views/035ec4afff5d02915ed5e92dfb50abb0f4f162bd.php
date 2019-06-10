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
                    <h4 class="text-left mt-4">Total: $<?php echo e($total*config('rate'), false); ?></h4>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Your Cart is empty!
            </div>
        <?php endif; ?>
    </div>
</div>

    <?php if( count($cart) > 0 ): ?>
        <form method="POST" action="/place-order">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mt-3 mb-3">Checkout Form</h4>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>First Name*</b></div>
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
                        <input type="text" name="user_email" value="<?php echo e(isset($fsession['user_email'])?$fsession['user_email']:'', false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>Telephone#</b></div>
                    <div class="col-md-12">
                        <input type="text" name="mobile_num" value="<?php echo e(isset($fsession['mobile_num'])?$fsession['mobile_num']:'', false); ?>" class="form-control" required>
                    </div>
                </div>
                <div class="col">
                    <div class="col-lg-12"><b>Address</b></div>
                    <div class="col-md-12">
                        <input type="text" name="address" value="<?php echo e(isset($fsession['address'])?$fsession['address']:'', false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>Apartment number</b></div>
                    <div class="col-md-12">
                        <input type="text" name="aprtment_num" value="<?php echo e(isset($fsession['aprtment_num'])?$fsession['aprtment_num']:'', false); ?>" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="col-lg-12"><b>City</b></div>
                    <div class="col-md-12">
                        <input type="text" name="city" value="<?php echo e(isset($fsession['city'])?$fsession['city']:'', false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>Zip</b></div>
                    <div class="col-md-12">
                        <input type="text" name="zipcode" value="<?php echo e(isset($fsession['zipcode'])?$fsession['zipcode']:'', false); ?>" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="col-lg-12"><b>Count</b></div>
                    <div class="col-md-12">
                        <input type="text" name="count" value="<?php echo e($selected_item['qty'], false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>Paid Amount</b></div>
                    <div class="col-md-12">
                        <input type="text" name="paid_amount" value="<?php echo e($total*config('rate'), false); ?>" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="col-lg-12"><b>Status</b></div>
                    <div class="col-md-12">
                        <input type="text" name="status" value="<?php echo e(isset($fsession['status'])?$fsession['status']:'', false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>Note</b></div>
                    <div class="col-md-12">
                        <input type="text" name="note" value="<?php echo e(isset($fsession['note'])?$fsession['note']:'', false); ?>" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="col-lg-12"><b>Tracking Receipt Status</b></div>
                    <div class="col-md-12">
                        <input type="text" name="tracking" value="<?php echo e(isset($fsession['tracking'])?$fsession['tracking']:'', false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="col-lg-12"><b>Assisted</b></div>
                    <div class="col-md-12">
                        <input type="text" name="assisted" value="<?php echo e(isset($fsession['assisted'])?$fsession['assisted']:'', false); ?>" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="col-lg-12"><b>How did you find us? (If it was through Google please tell us the keyword)</b></div>
                    <div class="col-md-12">
                        <input type="text" name="findus" value="<?php echo e(isset($fsession['findus'])?$fsession['findus']:'', false); ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="col-md-5">
                    <input class="btn btn-primary btn-block" type="submit" value="Place Order">
                </div>
            </div>
        </form>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>