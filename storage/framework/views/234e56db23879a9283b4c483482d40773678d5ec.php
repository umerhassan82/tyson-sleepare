<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    .divTableCell{
        display: table-cell;
    }
</style>
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
            $logo = URL::asset('images/logo.png');
        ?>
    <?php endif; ?>


    <table style="font-family:sans-serif; margin:0px auto; width: 100%"  cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
            <tr style="font-family:sans-serif">
                <td style="font-family:sans-serif;border-collapse:collapse;padding:30px" width="40%" bgcolor="#ffffff" align="center">
                    <a href="https://www.sleepare.com/" style="font-family:sans-serif" target="_blank">
                        <img alt="Sleepare" src="<?php echo e($logo, false); ?>" border="0" width="200px" class="CToWUd">
                    </a>
                    <p style="margin-bottom: 0; font-size:10px;color:rgb(117,117,117);font-family:sans-serif">This email is confirming your order on <?php echo $date; ?></p>
                </td>
            </tr>
            <tr style="font-family:sans-serif">                            
                <td style="border-top:0px solid rgb(255,255,255); color:rgb(0,0,0);font-size:17px;line-height:34px;font-family:sans-serif;border-collapse:collapse;padding-top:20px; padding-bottom:30px;" bgcolor="#ffffff" align="left">
                    <p style="font-size:18px;line-height:1.5;font-family:sans-serif">Hi, <?php echo $customerName; ?>!</p>
                    <p style="margin-bottom:0px; font-family:sans-serif">Thank you for your order #<?php echo $orderID; ?> , we will start working on it right away!</p>
                </td>
            </tr>
            <tr>
                <td align="left" style="padding-bottom:5px; padding-top: 20px; border-top: 2px solid #ccc; font-size: 13px; color: #333; font-weight: 500;">
                    <span style="width: 200px; display: inline-block;">Customer Name:</span>
                    <?php echo $customerName; ?>

                </td>
            </tr>
            <tr>
                <td align="left" style="padding-bottom:20px; border-bottom: 2px solid #ccc; font-size: 13px; color: #333; font-weight: 500;">
                    <span style="width: 200px; display: inline-block;">Order#:</span> <?php echo $orderID; ?>

                </td>
            </tr>
            <?php echo $orderItems; ?>

            <tr style="font-family:sans-serif">
                <td style="color:rgb(63,63,60);font-size:14px;font-family:sans-serif;border-collapse:collapse;padding:20px;" bgcolor="#F2F3F4" align="left">
                    <table style="color:rgb(63,63,60);font-size:14px;font-family:sans-serif" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#F2F3F4">
                        <tbody>
                            <tr style="font-family:sans-serif">
                                <td style="font-family:sans-serif;border-collapse:collapse">
                                    <div style="display: flex; padding-bottom:30px;">
                                        <h3 style="font-size:13px; font-family:sans-serif; margin:0px; width: 200px;">Shipping address:</h3>
                                        <div><?php echo $shippingAddress; ?></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="font-family:sans-serif">
                <td style="padding: 20px;" bgcolor="#ffffff" align="right">
                    <p style="margin-bottom:10px;font-family:sans-serif"><span style="font-size: 16px;">Shipping:</span> <span style="font-size: 15px; width: 150px; display: inline-block;"><?php echo $totalShippingCost; ?> USD</span></p>
                    <p style="margin-bottom:10px;font-family:sans-serif"><span style="font-size: 16px;">Tax:</span> <span style="font-size: 15px; width: 150px; display: inline-block;"><?php echo $totalTax; ?> USD</span></p>
                    <p style="font-family:sans-serif;margin:0px"><span style="font-size: 16px;">Total:</span> <span style="font-size: 15px; width: 150px; display: inline-block;"><?php echo $totalCost; ?> USD</span></p>
                </td>
            </tr>
            <tr style="font-family:sans-serif">                            
                <td style="border-top:0px solid rgb(255,255,255); color:rgb(0,0,0);font-size:17px;line-height:34px;font-family:sans-serif;border-collapse:collapse;padding-top:20px; padding-bottom:30px;" bgcolor="#ffffff" align="left">
                    <p style="font-family:sans-serif">What's next?</p>
                    <ul style="font-size:14px;font-family:sans-serif">
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:14px;">
                            <b style="font-family:sans-serif">Mattress Manufacturing:</b> Your Mattress is handmade per order. Please allow up to 15 business days for the manufacturer to Box your mattress and put it  on the truck for delivery.
                        </li>
                    </ul>
                    <p style="font-family:sans-serif">What does the different shipping options mean:</p>
                    <ul style="font-size:14px;color:rgba(0,0,0,8);font-family:sans-serif">
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:14px;">
                            <b style="font-family:sans-serif">Standard shipping:</b> You will receive a notification From Sleepare after your mattress has been shipped containing a tracking number. A tracking number might be available before shipping, or sometimes only a day or two after shipping. <br />Shipping usually takes 2-5 Business days, depending on factory  and customer location. In most cases, no changes to shipping times or address can be made once the mattress has shipped. Note that the free Standard shipping uses UPS/ FedEx ground service, and your order will not be brought into the residence.<br />If you require assistance setting up your new mattress, pleasecontact us to inquire about  White-glove delivery service.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:14px;">
                            <b style="font-family:sans-serif">Delayed Standard Shipping:</b> This is a complimentary service by 
                            Sleepare, where we will try to time the order to fit a desired 
                            timeframe. Please Do Not use this service if you need your order in 
                            very specific dates for delivery, as there is no guarantee that it will be 
                            met with that service.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:14px;">
                            <b style="font-family:sans-serif">White-Glove Delivery:</b> You will receive a call from the delivery company agent 
                            once your items have arrived at their warehouse to schedule your 
                            delivery date and time. 
                            If you have any questions regarding the progress of your order, please feel free to email us at info@sleepare.com or <a href="https://www.sleepare.com/us/contact-us/">chat</a> with us.
                        </li>
                    </ul>
                    <p style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">Other things to note:</p>
                    <p style="font-size:14px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">Additional products might ship separately from various warehouse locations and might arrive in separate shipping.</p>
                    <p style="font-size:14px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">If you didn't get a chance at the store, please review our exchange/return policy <a href="https://www.sleepare.com/us/return-policy/">Here.</a></p>
                    <p style="font-size:14px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">SleePare is highly appreciative of your business, and we will work hard to see you get your order as soon as possible.</p>
                    <p style="font-size:14px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">If you have any questions regarding the progress of your order, please feel free to email us at info@sleepare.com</p>
                </td>
            </tr>
            <tr style="font-family:sans-serif">
                <td style="color:rgb(63,63,60);font-family:sans-serif;border-collapse:collapse;padding:1px" align="center"><br></td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr style="font-family:sans-serif">
                <td style="color:rgb(169,169,169);font-size:12px;font-family:sans-serif;border-collapse:collapse">
                    <table style="color:rgb(169,169,169);font-size:12px;text-align:center;font-family:sans-serif;padding:0px 30px" width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody style="font-family:sans-serif">
                            <tr style="font-family:sans-serif">
                                <td style="font-family:sans-serif;border-collapse:collapse" valign="top" align="center">
                                    <p style="font-family:sans-serif">
                                    <b style="font-family:sans-serif">Questions or concerns?</b><br style="font-family:sans-serif">We're here to help. Our office hours are <b>Weekdays</b> 10:00 am to 07:00 pm <b>Saturday and Sunday</b> 10:00 am to 06:30 pm.</p>
                                    <p style="font-family:sans-serif">Call Us <a href="tel:+13479800044" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 (347) 980-0044</a></p>
                                    <p style="font-family:sans-serif">Email <a href="mailto:info@sleepare.com" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">info@sleepare.com</a></p>
                                </td>
                            </tr>
                            <tr style="font-family:sans-serif">
                                <td style="font-family:sans-serif;border-collapse:collapse; padding-top:10;">
                                    <p><a href="https://www.sleepare.com/us/return-policy/" target="_blank">Please read our Return Policy</a></p>
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