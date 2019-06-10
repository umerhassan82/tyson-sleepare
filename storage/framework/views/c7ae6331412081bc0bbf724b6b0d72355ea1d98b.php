<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale'), false); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_desc', 'Mattress Store'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta_key', 'shop, sleepare'); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <link rel="icon" type="image/png" href="https://mk0sleeparej0clr43i7.kinstacdn.com/wp-content/themes/sleepare/images/favicon.png" />
    <link href="<?php echo e(asset('css/app.css'), false); ?>" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
<body>

<?php echo $__env->make('frontend.default.partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<section class="container mainCnts">
    <div id="pjax-container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</section>

<footer class="footer-classic context-dark pt-5 pb-5">
    <div class="container">
        <div class="row row-30">
            <div class="col-md-6 col-xl-6">
                <div class="pr-xl-4">
                    <p><?php echo e(config('text_on_footer'), false); ?></p>
                    <p class="rights">&copy;  <?php echo e(date('Y'), false); ?> <?php echo e(config('app.name'), false); ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo e(asset('js/app.js'), false); ?>"></script>
<script src="/vendor/laravel-admin/nprogress/nprogress.js"></script>
<script src="<?php echo e(asset('js/pjax.js'), false); ?>"></script>
<script src="<?php echo e(asset('js/core.js?6'), false); ?>"></script>

<script>
    $(document).ready(function(){
        $(document).on("change", ".optionField", function(){
            $(".show_price").text($(this).val());
        });
    });
</script>
</body>
</html>