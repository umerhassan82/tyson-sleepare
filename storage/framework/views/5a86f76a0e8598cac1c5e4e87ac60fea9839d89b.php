<?php $__env->startSection('title', $product->title); ?>
<?php $__env->startSection('meta_desc', $product->meta_desc); ?>
<?php $__env->startSection('meta_key', $product->meta_key); ?>

<?php $__env->startSection('content'); ?>
<?php echo e(Breadcrumbs::render('product_full', $product), false); ?>


<div class="row">
    <div class="col-6 product-detail">
        <?php if( !empty($product->photo) ): ?>
            <img class="img-responsive" src="https://newyork.sleepare.com/uploads/<?php echo e($product->photo, false); ?>" alt="<?php echo e($product->title, false); ?>" />
        <?php else: ?>
            <?php echo e(Html::image('https://dummyimage.com/640x480/000/fff.jpg&text=No+image', $product->title, ['class'=>'img-responsive']), false); ?>

        <?php endif; ?>
    </div>
    <div class="col-6">
        <h2><?php echo e($product->title, false); ?></h2>
        <input type="hidden" name="prod_title" id="prod_title" value="<?php echo e($product->title, false); ?>" />
        <small class="text-muted">Category: <?php echo e($product->categories['title'], false); ?></small>
        <div><br/>Description<br/><?php echo $product->fulldesc; ?></div>
        <hr/>

        <?php
            $options = array('twin', 'twin-xl', 'full', 'queen', 'king', 'cal-king', 'split-king');
            $optionsName = array('Twin', 'Twin xl', 'Full', 'Queen', 'King', 'Cal King', 'Split King');
            $price = 0;

            $firmness = array();
            if(!empty($product->firmness))
                $firmness = explode(",", trim($product->firmness));
        ?>

        <?php echo e(Form::open(['route' => 'cart.store', "id" => "product_form"]), false); ?>


        <div class="row">
            <div class="col-md-2">
                <b>Options:</b>
            </div>
            <div class="col-md-4">
                <select name="product_price" class="form-control text-center optionField" required>
                    <option value="0">Choose Size</option>
                    <?php 
                        $found = 0; 
                        $size = null;    
                    ?>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($product[$option])): ?>
                           <?php
                                if($price == 0)
                                    $price  = $product[$option];

                                if($found == 0 && !empty($optionsName[$key])){
                                    $size = $optionsName[$key];
                                    $found = 1;
                                }
                            ?>
                            <option data-prodname="<?php echo e($optionsName[$key], false); ?>" value="<?php echo e($product[$option], false); ?>"><?php echo e($optionsName[$key], false); ?> - $<?php echo e($product[$option], false); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </div>
        </div>
        <?php if(!empty($firmness)): ?>
            <br />
            <div class="row">
                <div class="col-md-2">
                    <b>Firmness:</b>
                </div>
                <div class="col-md-4">
                    <select name="fimness_level" class="form-control text-center" id="fimness_level">
                        <option value="0">Choose Firmness</option>
                        <?php $__currentLoopData = $firmness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $firm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($firm, false); ?>"><?php echo e($firm, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
        
        <br />

        <div class="row">
            
            <input type="hidden" name="discountType" value="2" />
            <?php if(Auth::check()): ?>
                <div class="col-md-2">
                    <b>Discount:</b>
                </div>
                <div class="col-md-4">
                    <input type="text" name="discoutValue" id="discoutValue" class="form-control" />
                </div>
            <?php else: ?>
                <input type="hidden" name="discoutValue" id="discoutValue" class="form-control" />
            <?php endif; ?>

        </div>

        <br/>

        <div class="row">
            <div class="col-md-5">
                <h3><b>COST:</b> $<span class="show_price"><?php echo e($price, false); ?></span></h3>
            </div>
            <div class="col-md-3">
                <?php echo e(Form::text('qty', 1, ['class' => 'form-control text-center',"id" => "prod_qty"]), false); ?>

            </div>
            <div class="col-md-4">
                <a id="addToCart" class="btn btn-primary btn-block blue-btn">Add Product</a>
            </div>
        </div>
        <?php echo e(Form::hidden('product_id', $product->id), false); ?>

         <input type="hidden" name="product_size" id="product_size" value="<?php echo e($size, false); ?>" class="form-control" />
        <?php echo csrf_field(); ?>
        <?php echo e(Form::close(), false); ?>


        <hr/>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="confrimProduct" tabindex="-1" role="dialog" aria-labelledby="confrimProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to want to add this?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body confirmModal"></div>
        <div class="modal-footer">
            <button type="button" id="confirmProduct" class="btn btn-primary">Confirm</button>
        </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>