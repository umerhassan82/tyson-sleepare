<?php $__env->startSection('content'); ?>

    <img class="main-image" src="<?php echo e(URL::asset('uploads/images/home-main-banner.jpg'), false); ?>" />

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.'.config('template').'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>