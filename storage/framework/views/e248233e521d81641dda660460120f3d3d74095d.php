<?php $__env->startSection('title', 'Search Result'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo Breadcrumbs::render('search', 'Search Result'); ?>

    </div>

    <div class="col-md-12">
        <h3>
            <?php if( count($products) > 0 ): ?>
                Found: <?php echo e(count($products), false); ?>

            <?php else: ?>
                Search Result
            <?php endif; ?>
        </h3>
    </div>

    <?php if( count($products) > 0 ): ?>

        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('frontend.'.config('template').'.partials.short_products', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="clearfix"></div>

        <div class="text-center">
            <?php echo e($products->links(), false); ?>

        </div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-warning text-center">
                Nothing found
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>