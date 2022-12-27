<div class="card">
    <div class="card-body">
        <div class="row">
            <?php if($close): ?>
                <div class="col-md-1">
                    <a class="btn btn-danger btn-sm" href="/cart/<?php echo e(urlencode($item['id']), false); ?>">x</a>
                </div>
            <?php endif; ?>
            <div class="col-md-2 cartItems">
                <?php if(!empty($item['product_id'])): ?>
                    <a href="/<?php echo e($item['product_id'], false); ?>-<?php echo e($item['slug'], false); ?>" title="<?php echo e($item['name'], false); ?>">    
                <?php endif; ?>
                    <?php if( $item['image'] !== null && !empty($item['image'])): ?>
                        <?php
                            $imageURL = 'https://newyork.sleepare.com/uploads/'.$item['image'];
                        ?>
                        <img class="img-responsive" src="<?php echo e($imageURL, false); ?>" alt="<?php echo e($item['name'], false); ?>" />
                    <?php else: ?>
                        <?php echo e(Html::image('https://dummyimage.com/762x428/000/fff.jpg&text=No+image', $item['name'], ['class'=>'img-responsive', 'style'=>'width:100%;']), false); ?>

                    <?php endif; ?>
                
                <?php if(!empty($item['product_id'])): ?>
                    </a>
                <?php endif; ?>

                <?php if(!empty($item['product_id'])): ?>
                    <b class="pt-2"><?php echo e(link_to_route('products.show', $item['name'], [$item['product_id'], $item['slug']]), false); ?></b>
                <?php else: ?>
                    <b class="pt-2"><?php echo e($item['name'], false); ?></b>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <?php if(!empty($item['firmness'])): ?>
                     <p class="mb-0">Firmness: <b><?php echo e($item['firmness'], false); ?></b></p>
                <?php endif; ?>
                <p class="mb-0">Size: <b><?php echo e($item['size'], false); ?></b></p>
                <p class="mb-0">Quantity: <b><?php echo e($item['qty'], false); ?></b></p>
                <?php if(!empty($item['open_mattress'])): ?>
                    <b>Open Mattress</b>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <?php if($item['cat_id'] == 5): ?>
                    <select name="shippingType[]" class="form-control shipping-field" id="shipping-field-<?php echo e($item['hash'], false); ?>">
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="0">Choose Shipping</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="1">Regular shipping immediatly</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="2">White Glove shipping immediately</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="3">Picked up</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="4">Will Pick up</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="6">Free delayed curbside</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="7">Delayed - White Glove</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="8">Drop Off</option>
                    </select>
                    <div id="sub-items-div-<?php echo e($item['hash'], false); ?>" class="mt-3">
                        <div id="sub-option-1-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>Mattress Removal</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input data-product="<?php echo e($item['hash'], false); ?>" type="radio" name="option-1-<?php echo e($item['hash'], false); ?>" value="yes" class="removal-shipping m-1"><span>Yes</span></label>
                                <label><input data-product="<?php echo e($item['hash'], false); ?>" type="radio" name="option-1-<?php echo e($item['hash'], false); ?>" value="no" class="removal-shipping m-1 ml-3"><span>No</span></label>
                            </div>
                        </div> <!-- Option 1  -->

                        <div id="sub-option-2-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>Mattress Removal</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input type="radio" data-product="<?php echo e($item['hash'], false); ?>" name="option-2-<?php echo e($item['hash'], false); ?>" value="yes" class="removal-shipping m-1"><span>Yes</span></label>
                                <label><input type="radio" data-product="<?php echo e($item['hash'], false); ?>" name="option-2-<?php echo e($item['hash'], false); ?>" value="no" class="removal-shipping m-1 ml-3"><span>No</span></label>
                            </div>
                        </div> <!-- Option 2  -->

                        <div id="sub-option-3-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>Picked up</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <p>Print Receipt with delivered certificate</p>
                            </div>
                        </div> <!-- Option 3  -->

                        <div id="sub-option-4-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>Product in stock</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input type="radio" data-product="<?php echo e($item['hash'], false); ?>" name="option-4-<?php echo e($item['hash'], false); ?>" value="yes" class="m-1"><span>Yes</span></label>
                                <label><input type="radio" data-product="<?php echo e($item['hash'], false); ?>" name="option-4-<?php echo e($item['hash'], false); ?>" value="no" class="m-1 ml-3"><span>No</span></label>
                            </div>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input placeholder="Comment" class="form-control" type="text" name="option-4-2-<?php echo e($item['hash'], false); ?>" id="option-4-2-<?php echo e($item['hash'], false); ?>" />
                            </div>
                        </div> <!-- Option 4  -->

                        <div id="sub-option-6-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>Please enter the first day when you will be ready to receive the product</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input type="date" min="<?php echo(date('Y-m-d')); ?>" name="option-6-<?php echo e($item['hash'], false); ?>" class="form-control">
                            </div>
                        </div> <!-- Option 6  -->

                        <div id="sub-option-7-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>Please choose a date to deliver</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input type="date" min="<?php echo(date('Y-m-d')); ?>" name="option-7-<?php echo e($item['hash'], false); ?>" class="form-control">
                            </div>
                            <br />
                            <b>Mattress Removal</b>
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <label><input type="radio" data-product="<?php echo e($item['hash'], false); ?>" name="option-7-1-<?php echo e($item['hash'], false); ?>" value="yes" class="removal-shipping m-1"><span>Yes</span></label>
                                <label><input type="radio" data-product="<?php echo e($item['hash'], false); ?>" name="option-7-1-<?php echo e($item['hash'], false); ?>" value="no" class="removal-shipping m-1 ml-3"><span>No</span></label>
                            </div>
                        </div> <!-- Option 7  -->
                    </div>
                <?php elseif($item['cat_id'] == 6): ?>
                    <select name="shippingType[]" class="form-control shipping-field" id="shipping-field-<?php echo e($item['hash'], false); ?>">
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="0">Choose Shipping</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="9">Free curbside delivery</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="10">WG W/ASSEMBLY - no removal</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="11">Drop off</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="12">Picked up</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="13">Will Pick up</option>
                    </select>
                    <div id="sub-items-div-<?php echo e($item['hash'], false); ?>" class="mt-3">
                        <div id="sub-option-10-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <b>No Removal</b>
                        </div> <!-- Option 9  -->
                        <div id="sub-option-13-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input placeholder="Comment" class="form-control" type="text" name="option-13-<?php echo e($item['hash'], false); ?>" id="option-13-<?php echo e($item['hash'], false); ?>" />
                            </div>
                        </div>
                    </div>
                <?php else: ?> 
                    <select name="shippingType[]" class="form-control shipping-field" id="shipping-field-<?php echo e($item['hash'], false); ?>">
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="0">Choose Shipping</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="14">Regular shipping</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="15">Picked up</option>
                        <option data-product="<?php echo e($item['hash'], false); ?>" value="16">Will Pick up</option>
                    </select>
                    <div id="sub-items-div-<?php echo e($item['hash'], false); ?>" class="mt-3">
                        <div id="sub-option-16-<?php echo e($item['hash'], false); ?>" class="sub-option">
                            <div class="d-flex align-items-center justify-content-start pt-2">
                                <input placeholder="Comment" class="form-control" type="text" name="option-16-<?php echo e($item['hash'], false); ?>" id="option-16-<?php echo e($item['hash'], false); ?>" />
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <input <?php echo e(auth::check() ? '' : 'readonly', false); ?> class="form-control item-shipping-cost" type="number" name="itemShippingCost[]" id="shippingCost-<?php echo e($item['hash'], false); ?>" value="0.0">
            </div>
            <div class="col-md-2 text-center">
                <?php
                    if(isset($item["dis_value"]) && !empty($item["dis_value"])){
                        echo('<del>$'.$item['full_price'] * config('rate').'</del><br />');
                    }
                ?>
                $<?php echo e(number_format($item['cost'] * config('rate'), 2), false); ?>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>