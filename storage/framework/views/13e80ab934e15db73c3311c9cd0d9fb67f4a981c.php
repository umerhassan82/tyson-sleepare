<?php $__env->startSection('title', 'Cart'); ?>
<?php $__env->startSection('meta_desc', ''); ?>
<?php $__env->startSection('meta_key', ''); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo Breadcrumbs::render('order'); ?>

    </div>
    <div class="col-md-12">
        <div class="alert alert-success text-center">
            Thank you
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.default.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>