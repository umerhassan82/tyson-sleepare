<?php $__env->startSection('title', $categories->title); ?>
<?php $__env->startSection('meta_desc', $categories->meta_desc); ?>
<?php $__env->startSection('meta_key', $categories->meta_key); ?>

<?php $__env->startSection('content'); ?>
    <?php echo Breadcrumbs::render('categories', $categories->title, $categories->slug); ?>


    <?php if( $category_menu ): ?>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <?php echo $category_menu; ?>

            </div>
        </div>
        <div class="col-md-9">
            <h3><?php echo e($categories->title, false); ?></h3>
            <div class="row">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('frontend.'.config('template').'.partials.short_products', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h3><?php echo e($categories->title, false); ?></h3>
        <div class="row">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('frontend.'.config('template').'.partials.short_products', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="text-center">
        <?php echo e($products->links(), false); ?>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>