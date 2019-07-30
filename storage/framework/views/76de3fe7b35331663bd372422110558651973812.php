<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<div style="width:600px; margin:0 auto;">

    <?php if(isset($header) && $header == 1): ?>
        <div style="padding: 20px; font-size: 20px;">
            <a style="padding: 10px; color: #fff; background-color: #1087dd; border: 1px solid rgba(0,0,0,0.2); text-decoration: none; border-radius: 3px;" 
                href="/send/receipt/<?php echo e($order_id, false); ?>">Send Receipt</a> to: <?php echo $emailAddress; ?>

        </div>
    <?php endif; ?>

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
                <td style="font-family:sans-serif;border-collapse:collapse;padding:0px 30px 0px 0px" align="right">
                    <span style="font-size:10px;color:rgb(117,117,117);font-family:sans-serif">This email is confirming your order on <?php echo $date; ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr style="font-family:sans-serif">                            
                <td style="border-top:0px solid rgb(255,255,255);color:rgb(63,63,60);font-size:24px;line-height:34px;font-family:sans-serif;border-collapse:collapse;padding:0px 30px" bgcolor="#ffffff" align="left">
                    <p style="margin-bottom:0px;font-family:sans-serif">Thanks for your <span class="il">Sleepare</span> purchase!</p>
                    <p style="font-size:18px;line-height:1.5;font-family:sans-serif">Hi, <?php echo $customerName; ?>! We've received your order and we will get started on it right away.<br style="font-family:sans-serif"></p>
                    <p style="font-family:sans-serif">What's next?</p>
                    <ul style="font-size:16px;font-family:sans-serif">
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                            <b style="font-family:sans-serif">Mattress Orders:</b> allow 1 - 2 business days to build and compress your mattress before its boxed and placed on the truck for delivery.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                            <b style="font-family:sans-serif">Order Tracking:</b> sent between 2 - 4 business days from when you placed the order.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                            <b style="font-family:sans-serif">Delivery:</b> allow up to 7 business days.
                            <ul style="margin-left:0px;font-family:sans-serif">
                                <li style="font-family:sans-serif">Canada Orders: please allow up to 10 business days for delivery.</li>
                            </ul>
                        </li>
                    </ul>
                    <p style="font-size:16px;color:rgba(0,0,0,0.54);font-family:sans-serif">Other things to note:</p>
                    <ul style="font-size:16px;color:rgba(0,0,0,0.54);font-family:sans-serif">
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                            Products are shipped separately from various warehouse locations.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                            White-Glove Delivery: you will receive a call from the delivery agent within 1-2 weeks to schedule your delivery date and time.
                        </li>
                    </ul>
                </td>
            </tr>
            <tr style="font-family:sans-serif">
                <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#F2F3F4" align="left">
                    <table style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#F2F3F4">
                        <tbody>
                            <tr style="font-family:sans-serif">
                                <td style="font-family:sans-serif;border-collapse:collapse">
                                    <p style="font-size:16px;font-weight:bold;font-family:sans-serif;margin:0px">Shipping address</p>
                                    <?php echo $shippingAddress; ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php echo $orderItems; ?>

            <tr style="font-family:sans-serif">
                <td style="color:rgb(63,63,60);font-size:16px;border-bottom:2px solid rgb(227,227,227);border-top:2px solid rgb(227,227,227);font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="right">
                    <p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Shipping:</span> $0.00 USD</p>
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
                                    <p style="font-family:sans-serif">Call Us <a href="tel:+13474256001" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 347 4256001</a></p>
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