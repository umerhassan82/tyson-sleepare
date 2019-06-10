<?php $__env->startSection('title', $product->title); ?>
<?php $__env->startSection('meta_desc', $product->meta_desc); ?>
<?php $__env->startSection('meta_key', $product->meta_key); ?>

<?php $__env->startSection('content'); ?>
<?php echo e(Breadcrumbs::render('product_full', $product), false); ?>


<div class="row">
    <div class="col-6 product-detail">
        <?php if( !empty($product->photo) ): ?>
            <img class="img-responsive" src="<?php echo e(URL::asset('/uploads/'.$product->photo), false); ?>" alt="<?php echo e($product->title, false); ?>" />
        <?php else: ?>
            <?php echo e(Html::image('https://dummyimage.com/640x480/000/fff.jpg&text=No+image', $product->title, ['class'=>'img-responsive']), false); ?>

        <?php endif; ?>
    </div>
    <div class="col-6">
        <h2><?php echo e($product->title, false); ?></h2>
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

        <?php echo e(Form::open(['route' => 'cart.store']), false); ?>


        <div class="row">
            <div class="col-md-2">
                <b>Options:</b>
            </div>
            <div class="col-md-4">
                <select name="product_price" class="form-control text-center optionField">

                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($product[$option])): ?>
                           <?php
                                if($price == 0)
                                    $price  = $product[$option];
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
                    <select name="fimness_level" class="form-control text-center">
                        <?php $__currentLoopData = $firmness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $firm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($firm, false); ?>"><?php echo e($firm, false); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
        
        <br />

        <div class="row">
            <div class="col-md-2">
                <b>Discount:</b>
            </div>
            <div class="col-md-3">
                <select name="discountType" class="form-control text-center">
                    <option value="1">Percent</option>
                    <option value="2">Flat</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="discoutValue" class="form-control" />
            </div>
        </div>
        <br />

        <div class="row">
            <div class="col-md-5">
                <h3><b>COST:</b> $<span class="show_price"><?php echo e($price, false); ?></span></h3>
            </div>
            <div class="col-md-3">
                <?php echo e(Form::text('qty', 1, ['class' => 'form-control text-center']), false); ?>

            </div>
            <div class="col-md-4">
                <?php echo e(Form::submit('Buy', ['class' => 'btn btn-primary btn-block']), false); ?>

            </div>
        </div>
        <?php echo e(Form::hidden('product_id', $product->id), false); ?>

        <input type="hidden" name="product_size" id="product_size" class="form-control" />
        <?php echo csrf_field(); ?>
        <?php echo e(Form::close(), false); ?>


        <hr/>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>