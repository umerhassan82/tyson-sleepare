<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale'), false); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(Admin::title(), false); ?> <?php if($header): ?> | <?php echo e($header, false); ?><?php endif; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php echo Admin::css(); ?>


    <script src="<?php echo e(Admin::jQuery(), false); ?>"></script>
    <?php echo Admin::headerJs(); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        $(document).on("change", ".shipping_type", function(){
            var value = $(this).val();
            $(".shippingGroup").hide();
            $(".group-"+value).show();
        });

        $(document).ready(function(){
            $('.wrapper').bind("DOMSubtreeModified", function(){
                $(".option_1_1, .option_1_2").parent().parent().addClass("group-1 shippingGroup");
                $(".option_2_1").parent().parent().addClass("group-2 shippingGroup");
                $(".option_3_1").parent().parent().parent().addClass("group-3 shippingGroup");
                $(".option_4_1").parent().parent().addClass("group-4 shippingGroup");
                $(".option_5_1").parent().parent().parent().addClass("group-5 shippingGroup");
                $(".option_6_1").parent().parent().parent().addClass("group-6 shippingGroup");
                $(".option_7_1").parent().parent().parent().addClass("group-7 shippingGroup");
                $(".option_7_2, .option_7_3").parent().parent().addClass("group-7 shippingGroup");

                var selectedOption = $(".shipping_type").val();

                $(".group-"+selectedOption).show();

            });
        });
    </script>
    <style>
        .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
            border-top: 0;
            white-space: nowrap;
        }
        .shippingGroup{
            display: none;
        }
    </style>

</head>

<body class="hold-transition <?php echo e(config('admin.skin'), false); ?> <?php echo e(join(' ', config('admin.layout')), false); ?>">
<div class="wrapper">

    <?php echo $__env->make('admin::partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('admin::partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content-wrapper" id="pjax-container">
        <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
        </div>
        <?php echo Admin::script(); ?>

    </div>

    <?php echo $__env->make('admin::partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>

<script>
    function LA() {}
    LA.token = "<?php echo e(csrf_token(), false); ?>";
</script>

<!-- REQUIRED JS SCRIPTS -->
<?php echo Admin::js(); ?>


</body>
</html>
