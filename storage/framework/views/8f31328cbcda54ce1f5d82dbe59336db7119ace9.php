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
        
        <link href="<?php echo e(asset('css/app-v2.css'), false); ?>" rel="stylesheet">
        <link rel="stylesheet" href="/vendor/laravel-admin/nprogress/nprogress.css">
        <script src="https://js.stripe.com/v3/"></script>
        
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>;
        </script>
    </head>
    <body style="background-color: #eaeaea;">
        <div style="width:600px; margin:0 auto; background-color: #fff;">

            <?php if(isset($email_logo) && $email_logo <> ""): ?>
                <?php
                    $logo = $email_logo;
                ?>
            <?php else: ?>
                <?php
                    $logo = URL::asset('images/logo.svg');
                ?>
            <?php endif; ?>

            <table style="font-family:sans-serif;margin:0px auto"  cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody>
                    <tr style="font-family:sans-serif">
                        <td style="font-family:sans-serif;border-collapse:collapse;padding:30px" width="40%" bgcolor="#ffffff" align="left">
                            <a href="https://www.sleepare.com/" style="font-family:sans-serif" target="_blank">
                                <img alt="Sleepare" src="<?php echo e($logo, false); ?>" border="0" width="200px" class="CToWUd">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:0 30px" bgcolor="#ffffff" align="left">
                            <p style="margin-bottom:10px;font-family:sans-serif">Hi, <?php echo e($customerName, false); ?></p>
                            <p style="margin-bottom:10px;font-family:sans-serif">Thank you for choosing SleePare!</p>
                            <p style="margin-bottom:10px;font-family:sans-serif">Following are the details of your order. If you wish to cancel it, please click on <b>Cancel Order</b>.</p>
                            <div style="text-align: right;">
                                <form method="post" action="/cancel/request/order/<?php echo e($order_id, false); ?>">
                                    <button href="#" style="border: none; font-size: 17px; cursor:pointer; color:#fff; padding:7px 15px; border-radius:5px; background-color:red; display:inline-block; text-decoration: none;">Cancel Order</button>
                                    <input type="hidden" name="hash_token" value="<?php echo e($hash, false); ?>">
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php echo $orderItems; ?>

                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-size:16px;border-top:2px solid rgb(227,227,227);font-family:sans-serif;border-collapse:collapse;padding:0 30px" bgcolor="#ffffff" align="right">
                            <p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Shipping:</span> $0.00 USD</p>
                            <p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Tax:</span> $<?php echo $tax; ?> USD</p>
                            <p style="font-family:sans-serif;margin:0px"><span style="color:rgb(162,162,162);font-family:sans-serif">Total:</span><span style="font-size:18px;font-weight:bold;font-family:sans-serif"> $<?php echo $totalCost; ?> USD</span></p>
                        </td>
                    </tr>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-family:sans-serif;border-collapse:collapse;padding:24px" align="center"><br></td>
                    </tr>
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(169,169,169);font-size:12px;font-family:sans-serif;border-collapse:collapse">
                            <table style="color:rgb(169,169,169);font-size:12px;text-align:center;font-family:sans-serif;padding:0px 30px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody style="font-family:sans-serif">
                                    <tr style="font-family:sans-serif">
                                        <td style="font-family:sans-serif;border-collapse:collapse" valign="top" align="center">
                                            <p style="font-family:sans-serif">
                                            <b style="font-family:sans-serif">Questions or concerns?</b><br style="font-family:sans-serif">We're hear to help. Our office hours are <b>Weekdays</b> 10:00 am to 08:30 pm <b>Saturday</b> 10:00 am to 07:30 pm <b>Sunday</b> 10:00 am to 06:30 pm.</p>
                                            <p style="font-family:sans-serif">Call Us <a href="tel:+13479800044" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 (347) 980-0044</a></p>
                                            <p style="font-family:sans-serif">Email <a href="mailto:info@sleepare.com" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">info@sleepare.com</a></p>
                                        </td>
                                    </tr>
                                    <tr style="font-family:sans-serif">
                                        <td style="font-family:sans-serif;border-collapse:collapse">
                                            <p style="font-family:sans-serif">&copy; <?php echo e(date('Y'), false); ?> SleePare All rights reserved.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <body>
</html>