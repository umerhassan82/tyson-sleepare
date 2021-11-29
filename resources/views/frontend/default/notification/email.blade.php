<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    .divTableCell{
        display: table-cell;
    }
</style>
<div style="width:600px; margin:0 auto;">

    @if(isset($header) && $header == 1)
        <div style="padding: 20px; font-size: 20px;">
            <a style="padding: 10px; color: #fff; background-color: #1087dd; border: 1px solid rgba(0,0,0,0.2); text-decoration: none; border-radius: 3px;" 
                href="/send/receipt/{{ $order_id }}">Send Receipt</a> to: {!! $emailAddress !!}
        </div>
    @endif

    @if(isset($email_logo) && $email_logo <> "")
        <?php
            $logo = $email_logo;
        ?>
    @else
        <?php
            $logo = URL::asset('images/logo.png');
        ?>
    @endif


    <table style="font-family:sans-serif;margin:0px auto"  cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
            <tr style="font-family:sans-serif">
                <td style="font-family:sans-serif;border-collapse:collapse;padding:30px" width="40%" bgcolor="#ffffff" align="left">
                    <a href="https://www.sleepare.com/" style="font-family:sans-serif" target="_blank">
                        <img alt="Sleepare" src="{{ $logo }}" border="0" width="200px" class="CToWUd">
                    </a>
                </td>
                <td style="font-family:sans-serif;border-collapse:collapse;padding:0px 30px 0px 0px" align="right">
                    <span style="font-size:10px;color:rgb(117,117,117);font-family:sans-serif">This email is confirming your order on {!! $date !!}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr style="font-family:sans-serif">                            
                <td style="border-top:0px solid rgb(255,255,255); color:rgb(0,0,0);font-size:24px;line-height:34px;font-family:sans-serif;border-collapse:collapse;padding:0px 30px" bgcolor="#ffffff" align="left">
                    <p style="font-size:18px;line-height:1.5;font-family:sans-serif">Hi, {!! $customerName !!}!</p>
                    <p style="margin-bottom:0px;font-family:sans-serif">We've received your order, and we will get started on it right away.</p>
                    <p style="font-family:sans-serif">What's next?</p>
                    <ul style="font-size:16px;font-family:sans-serif">
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:16px;">
                            <b style="font-family:sans-serif">Mattress Manufacturing:</b> Your Mattress is handmade per order. Please allow 5-15 business days for the manufacturer to build your mattress before it's boxed and placed on the truck for delivery. Please note some brands are experiencing longer production times due to global disruption of supply chains.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:16px;">
                            <b style="font-family:sans-serif">Standard shipping:</b> You will receive a notification From Sleepare after your mattress has been shipped containing a tracking number. A tracking number might be available before shipping, or sometimes only a day or two after shipping. <br />Shipping usually takes 2-5 Business days, depending on brand and customer location. In most cases, no changes to shipping times or address can be made once the mattress has shipped. Note that free Standard shipping is a UPS/ FedEx ground service, and your order will not be brought into the residence. <br />If you require assistance setting up your new mattress, please refer to our White-glove delivery service.
                        </li>
                    </ul>
                    <ul style="font-size:16px;color:rgba(0,0,0,8);font-family:sans-serif">
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:16px;">
                            <b style="font-family:sans-serif">Delayed Standard Shipping:</b> This is a complimentary service by Sleepare, where we will try to time the order to fit a desired timeframe. Please Do Not use this service if you need your order in very specific dates for delivery, as there is no guarantee that it will be met with that service.
                        </li>
                        <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif;font-size:16px;">
                            <b style="font-family:sans-serif">White-Glove Delivery:</b> You will receive a call from the delivery agent once your items have arrived at their warehouse to schedule your delivery date and time. <br />If you have any questions regarding the progress of your order, please feel free to email us at info@sleepare.com or <a href="https://www.sleepare.com/us/contact-us/">chat</a> with us.
                        </li>
                    </ul>
                    <p style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">Other things to note:</p>
                    <p style="font-size:16px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">Additional products might ship separately from various warehouse locations and might arrive in separate shipping.</p>
                    <p style="font-size:16px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">If you didn't get a chance at the store, please review our exchange/return policy <a href="https://www.sleepare.com/us/return-policy/">Here.</a></p>
                    <p style="font-size:16px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">SleePare is highly appreciative of your business, and we will work hard to see you get your order as soon as possible.</p>
                    <p style="font-size:16px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">If you have any questions regarding the progress of your order, please feel free to email us at info@sleepare.com</p>
                    <p style="font-size:16px;color:rgba(0,0,0,8);font-family:sans-serif;line-height:1.5;">We will highly appreciate your help, reading and confirming the address and order details below:</p>
                </td>
            </tr>
            <tr style="font-family:sans-serif">
                <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#F2F3F4" align="left">
                    <table style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#F2F3F4">
                        <tbody>
                            <tr style="font-family:sans-serif">
                                <td style="font-family:sans-serif;border-collapse:collapse">
                                    <p style="font-size:16px;font-weight:bold;font-family:sans-serif;margin:0px">Shipping address</p>
                                    {!! $shippingAddress !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            {!! $orderItems !!}
            <tr style="font-family:sans-serif">
                <td style="color:rgb(63,63,60);font-size:16px;border-bottom:2px solid rgb(227,227,227);border-top:2px solid rgb(227,227,227);font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="right">
                    <p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Shipping:</span> $0.00 USD</p>
                    <p style="font-family:sans-serif;margin:0px"><span style="color:rgb(162,162,162);font-family:sans-serif">Total:</span><span style="font-size:18px;font-weight:bold;font-family:sans-serif"> ${!! $totalCost !!} USD</span></p>
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
                                    <b style="font-family:sans-serif">Questions or concerns?</b><br style="font-family:sans-serif">We're hear to help. Our office hours are <b>Weekdays</b> 10:00 am to 07:00 pm <b>Saturday and Sunday</b> 10:00 am to 06:30 pm.</p>
                                    <p style="font-family:sans-serif">Call Us <a href="tel:+13479800044" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 (347) 980-0044</a></p>
                                    <p style="font-family:sans-serif">Email <a href="mailto:info@sleepare.com" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">info@sleepare.com</a></p>
                                </td>
                            </tr>
                            <tr style="font-family:sans-serif">
                                <td style="font-family:sans-serif;border-collapse:collapse">
                                    <p><a href="https://www.sleepare.com/us/return-policy/" target="_blank">Please read our Return Policy</a></p>
                                    <p style="font-family:sans-serif">&copy; {{ date('Y') }} SleePare All rights reserved.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>