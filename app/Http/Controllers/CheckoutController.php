<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Redirect;
use App\Models\Shop\Order;
// use LukePOLO\LaraCart;
use LukePOLO\LaraCart\Facades\LaraCart;
use App\OrderItem;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Shop\Product;
use Twilio\Rest\Client;

class CheckoutController extends Controller
{
    public function payViaLink(Request $request)
    {
        try {
            $stripeConfig = \Config::get('services');
            Stripe::setApiKey($stripeConfig["stripe"]["secret"]);
            \Log::info('app.requests', ['request' => $request->all(), 'Method' => 'link']);

            // Get payment intent ID from request
            $payment_intent_id = $request->payment_intent_id;

            // Retrieve the PaymentIntent to get the payment details
            $paymentIntent = PaymentIntent::retrieve($payment_intent_id);

            $order = Order::find($request->order_id);
            if ($order->ask_details == 1) {
                $order->address = $request->shipping_address;
                $order->phone = $request->mobile_number;
                $order->findus = $request->findus;
                $order->email = $request->user_email;
                $order->state = $request->shipping_state;
                $order->zipcode = $request->shipping_zip;
                $order->assisted = $request->assisted;
            }
            $order->paid = 1;
            $order->payment_type = 2;
            $order->transaction_id = $payment_intent_id;
            $order->save();
            $this->sendEmail($request->order_id);
            return Redirect::route('/order/link/thankyou');
        } catch (\Exception $e) {
            return Redirect::route('cancelled')->withErrors('Error! ' . $e->getMessage());
        }
    }

    public function sendEmail($order_id)
    {
        $orderID = $order_id;
        $order = order::find($orderID);
        $date = date('Y/m/d');
        $customerName = $order->first_name . " " . $order->last_name;
        $totalCost = $order->total;
        $shippingAddress = '
            <p style="font-family:sans-serif;margin:0px">' . $customerName . '</p>
            <p style="font-family:sans-serif;margin:0px">' . $order->address . ', ' . $order->apartment_num . ' ' . $order->zipcode . '</p>
        ';

        $items = OrderItem::where('order_id', $order->id)->get();
        $orderItems = '';
        $subjectNames = array();

        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            $imagePath = str_replace(" ", "%20", 'https://newyork.sleepare.com/uploads/' . $product->photo);
            $subjectNames[] = $product->title;
            $orderItems .= '
                <tr style="font-family:sans-serif">
                    <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="left">
                        <table style="font-family:sans-serif" cellspacing="0" cellpadding="0" border="0">
                            <tbody style="font-family:sans-serif">
                                <tr style="font-family:sans-serif">
                                    <td style="padding-right:20px;font-family:sans-serif;border-collapse:collapse" width="33%" align="left">
                                        <img src="' . $imagePath . '" style="max-width:175px;font-family:sans-serif" width="175" align="left">
                                    </td>
                                    <td style="font-family:sans-serif;border-collapse:collapse" width="33%" valign="top" align="left">
                                        <p style="font-family:sans-serif">' . $product->title . '<br style="font-family:sans-serif">
                                            <br style="font-family:sans-serif"> Quantity: ' . $item->qty . '
                                            ' . (isset($item->firmness) && $item->firmness <> "" ? '<br style="font-family:sans-serif"> Firmness: ' . $item->firmness : '') . '
                                            ' . (isset($item->product_size) && $item->product_size <> "" ? '<br style="font-family:sans-serif"> Size: ' . $item->product_size : '') . '
                                        </p>
                                    </td>
                                    <td style="font-family:sans-serif;border-collapse:collapse" width="33%" valign="top" align="right">
                                        <p style="font-family:sans-serif">$' . $item->price . '</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                ';
        } // end foreach
        $empID = 'Sleepare';
        $emailFrom = 'info@sleepare.com';
        $password = 'ftvahfkneuxkguwr';
        $sendTo = empty($order->email) ? $order->user_email : $order->email;
        $txt = '
            <div style="width:600px; margin:0 auto;">
                <table style="font-family:sans-serif;margin:0px auto" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                        <tr style="font-family:sans-serif">
                            <td style="font-family:sans-serif;border-collapse:collapse;padding:30px" width="60%" bgcolor="#ffffff" align="left">
                                <a href="https://www.sleepare.com/" style="font-family:sans-serif" target="_blank">
                                    <img alt="Sleepare" src="https://mk0sleeparej0clr43i7.kinstacdn.com/wp-content/themes/sleepare/images/logo.png" style="max-width:100%;vertical-align:top;color:rgb(63,63,60);font-size:14px;font-family:$
                                </a>
                            </td>
                            <td style="font-family:sans-serif;border-collapse:collapse;padding:0px 30px 0px 0px" width="40%" align="right">
                                <span style="font-size:10px;color:rgb(117,117,117);font-family:sans-serif">This email is confirming your order on ' . $date . '</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr style="font-family:sans-serif">
                            <td style="border-top:0px solid rgb(255,255,255);color:rgb(63,63,60);font-size:24px;line-height:34px;font-family:sans-serif;border-collapse:collapse;padding:0px 30px" bgcolor="#ffffff" align="left">
                                <p style="font-size:18px;line-height:1.5;font-family:sans-serif">Hi, ' . $customerName . '!!</p>
                                <p style="margin-bottom:0px;font-family:sans-serif">We\'ve received your order and we will get started on it right away.</p>
                                <p style="font-family:sans-serif">What\'s next?</p>
                                <ul style="font-size:16px;font-family:sans-serif">
                                    <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                                        <b style="font-family:sans-serif">Mattress Orders:</b> Allow 1-2 business days for our team to build and compress your mattress before it’s boxed and placed on the truck for delivery.
                                    </li>
                                    <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                                        <b style="font-family:sans-serif">Tracking Number:</b> You will receive notification that your order has shipped 2-5 business days from when you placed the order.
                                    </li>
                                    <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                                        <b style="font-family:sans-serif">Delivery:</b> After receiving your shipping notification, <b style="font-family:sans-serif"><em>allow 7-10 business days for delivery</em>.</b>
                                    </li>
                                </ul>
                                <p style="font-size:16px;color:rgba(0,0,0,0.54);font-family:sans-serif">Other things to note:</p>
                                <ul style="font-size:16px;color:rgba(0,0,0,0.54);font-family:sans-serif">
                                    <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                                        Products are shipped separately from various warehouse locations.
                                    </li>
                                    <li style="margin-bottom:8px;line-height:1.5;font-family:sans-serif">
                                        <b style="font-family:sans-serif">White-Glove Delivery:</b> You will receive a call from the delivery agent within 1-2 weeks to schedule your delivery date and time.
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
                                                ' . $shippingAddress . '
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        ' . $orderItems . '
                        <tr style="font-family:sans-serif">
                            <td style="color:rgb(63,63,60);font-size:16px;border-bottom:2px solid rgb(227,227,227);border-top:2px solid rgb(227,227,227);font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="right">
                                <p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Shipping:</span> $0.00 USD</p>
                                <p style="font-family:sans-serif;margin:0px"><span style="color:rgb(162,162,162);font-family:sans-serif">Total:</span><span style="font-size:18px;font-weight:bold;font-family:sans-serif"> $' . $totalCost  . ' USD</span></p>
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
                                                <b style="font-family:sans-serif">Questions or concerns?</b><br style="font-family:sans-serif">We\'re hear to help. Our office hours are <b>Weekdays</b> 10:00 am to 08:30 pm <b>Saturday</b> 10:00 am to 07:30 pm <b>Sunday</b> 10:00 am to 06:30 pm.</p>
                                                <p style="font-family:sans-serif">Call Us <a href="tel:+13479800044" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">+1 (347) 980-0044</a></p>
                                                <p style="font-family:sans-serif">Email <a href="mailto:info@sleepare.com" style="color:rgb(169,169,169);text-decoration:underline;font-weight:normal;font-family:sans-serif" target="_blank">info@sleepare.com</a></p>
                                            </td>
                                        </tr>
                                        <tr style="font-family:sans-serif">
                                            <td style="font-family:sans-serif;border-collapse:collapse">
                                                <p><a href="' . url('/pdf/shipping_and_returning.pdf') . '" target="_blank">Return Policy</a></p>
                                                <p style="font-family:sans-serif">&copy;' . date('Y') . ' SleePare All rights reserved.</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>';
        //checkmail
        try {
            $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $emailFrom;                          // SMTP username
            $mail->Password = $password;                             // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            $mail->Port = 465;                                    // Set the SMTP port number - 587 for authenticated TLS
            $mail->setFrom($emailFrom, $empID);                        // Set who the message is to be sent from
            $mail->addAddress($sendTo, $order->first_name);            // Add a recipient
            //$mail->addBCC($c_email);
            // $mail->addCC($to);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Thank you ' . $customerName . ' for order of ' . implode(", ", $subjectNames) . ", Order #" . $orderID;
            $mail->Body    = $txt;

            if (!$mail->send()) {
                return '<h1>Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo . '</h1>';
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }

    public function proceedPayment(Request $request)
    {

        Stripe::setApiKey(config("services.stripe.secret"));
        \Log::info('app.requests', ['request' => $request->all()]);
        try {
            $token = $request->stripeToken;

            $id = '';
            if ($request->paymentType == 2) {
                $charge = Charge::create(array(
                    'amount'      => round((float)$request->paid_amount * 100, 2),
                    'currency'    => 'usd',
                    "source"      => $token,
                    'description' => 'Thank you for your shopping | ' . $request->f_name,
                ));
                $id = $charge->id;
            }

            $this->placeOrder($request, $id);

            \LaraCart::destroyCart();
            session()->forget('checkout-form');

            return Redirect::route('thank-you');
        } catch (\Exception $e) {
            return Redirect::route('cancelled')->withErrors('Error! ' . $e->getMessage());
        }
        return Redirect::route('cancelled');
    }

    public function thankyou()
    {
        return view('frontend.default.shop.thankyou');
    }

    public function cancelled()
    {
        return view('frontend.default.shop.cancel');
    }

    public function placeOrder(Request $request, $transaction_id)
    {
        $totalTax = (float)$request->cart_tax;
        $totalShippingCost = 0;
        $order = new Order;
        $order->first_name              = $request->f_name;
        $order->last_name               = $request->l_name;
        $order->clover_trans_num        = $request->clover_trans;
        $order->email                   = strtolower($request->user_email);
        $order->phone                   = $request->mobile_num;
        $order->address                 = $request->address;
        $order->size                    = $request->size;
        $order->count                   = $request->count;
        $order->total                   = $request->paid_amount;
        $order->status                  = $request->status;
        $order->comment                 = $request->note;
        $order->assisted                = $request->assisted;
        $order->transaction_id          = $transaction_id;
        $order->apartment_num           = $request->aprtment_num;
        $order->tax                     = $totalTax;
        $order->city                    = $request->city;
        $order->zipcode                 = $request->zipcode;
        $order->state                   = $request->state;
        $order->findus                  = $request->findus;
        $order->origin                  = "tyson";
        $customerEmail = $request->user_email;
        $order->save();

        $orderID = $order->id;
        $date = date('Y/m/d');
        $customerName = $request->f_name . " " . $request->l_name;
        $totalCost = $request->paid_amount;
        $shippingAddress = '
            <p style="font-family:sans-serif;margin:0px">' . $customerName . '</p>
            <p style="font-family:sans-serif;margin:0px">' . $request->address . ' ' . $request->aprtment_num . ', ' . $request->state . ' ' . $request->zipcode . '</p>
        ';

        $items = LaraCart::getItems();
        $orderItems = '';
        $subjectNames = array();
        $order_items = array();

        $itemsShippingType = $request->shippingType;
        $itemsShippingCost = $request->itemShippingCost;
        $key = 0;
        foreach ($items as $item) {
            $imagePath = "";
            $tiem_name = "";
            $item_qty  = "";
            $item_price = "";
            $orderItem = new OrderItem;

            $orderItem->size        = $item->product_size;
            $orderItem->price       = $item->price;
            $orderItem->product_original_price = $item->full_price;
            $orderItem->discount    = $item->discount_value ?? 0;

            $orderItem->order_id    = $orderID;
            $orderItem->qty         = $item->qty;
            if (!empty($item->product_id)) {
                $product = Product::find($item->product_id);
                if (!empty($product)) {
                    $imagePath = str_replace(" ", "%20", \URL::asset('uploads/' . $product->photo));

                    $product->stock_newyork = $product->stock_newyork > 0 ? $product->stock_newyork - $orderItem->qty : $product->stock_newyork;
                    $product->save();
                    $tiem_name = $product->title;
                }

                $orderItem->firmness    = $item->firmness;
                $orderItem->product_id  = $item->product_id;

                $item_qty = $orderItem->qty;
                $item_price = $orderItem->price;
            } else {
                $tiem_name = $item->name;
                $item_qty  = $item->qty;
                $item_price = $item->price;
                $orderItem->product_name  = $item->name;
            }

            if (!empty($itemsShippingType) && !empty($item->product_id)) {
                $pid = $item->getHash();
                switch ($itemsShippingType[$key]) {
                    case 1:
                        $orderItem->option_1_1 = $request["option-1-" . $pid] == 'yes' ? 1 : 0;
                        break;
                    case 2:
                        $orderItem->option_2_1 = $request["option-2-" . $pid] == 'yes' ? 1 : 0;
                        break;
                    case 3:
                        $orderItem->option_3_1 = "Print Receipt with delivered certificate";
                        break;
                    case 4:
                        $orderItem->option_4_1 = $request["option-4-" . $pid] == 'yes' ? 1 : 0;
                        $orderItem->option_4_2 = $request["option-4-2-" . $pid];
                        break;
                    case 5:
                        $orderItem->option_5_1 = $request["option-5-" . $pid];
                        break;
                    case 6:
                        $orderItem->option_6_1 = $request["option-6-" . $pid];
                        break;
                    case 7:
                        $orderItem->option_7_1 = $request["option-7-" . $pid];
                        $orderItem->option_7_2 = $request["option-7-1" . $pid] == 'yes' ? 1 : 0;
                        break;
                    case 13:
                        $orderItem->option_13_1 = $request["option-13-" . $pid];
                        break;
                    case 16:
                        $orderItem->option_16_1 = $request["option-16-" . $pid];
                        break;
                }
                $orderItem->shipping_cost = (float)$itemsShippingCost[$key];
                $totalShippingCost += $orderItem->shipping_cost;
            }
            $orderItem->shipping_type = $itemsShippingType[$key];
            $orderItem->open_mattress = $item->open_mattress;
            $orderItem->save();

            $order_items[] = [
                "type"             => "physical",
                "name"             => $tiem_name,
                "quantity"         => $item_qty,
                "unit_price"       => (float)sprintf('%0.2f', $item_price + (($item_price * 8.875) / 100)),
                "tax_rate"         => 887.5,
                "total_amount"     => (float)sprintf('%0.2f', $item_price + (($item_price * $item_qty * 8.875) / 100)),
                "total_tax_amount" => (float)sprintf('%0.2f', ($item_price * $item_qty * 8.875) / 100)
            ];

            // dd($order_items);

            $product = Product::find($item->product_id);
            $image = '';
            $productName = '';
            if (!empty($product)) {
                $imagePath = str_replace(" ", "%20", 'https://newyork.sleepare.com/uploads/' . $product->photo);
                $image = '<img src="' . $imagePath . '" style="max-width:175px;font-family:sans-serif" width="175" align="left">';
                $productName = $product->title;
                $subjectNames[] = $product->title;
            } elseif (isset($item->name)) {
                $productName = $item->name;
                $subjectNames[] = $item->name;
            }

            $orderItems .= '
                <tr style="font-family:sans-serif">
                    <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="left">
                        <table style="font-family:sans-serif" cellspacing="0" cellpadding="0" border="0">
                            <tbody style="font-family:sans-serif">
                                <tr style="font-family:sans-serif">
                                    <td style="padding-right:20px;font-family:sans-serif;border-collapse:collapse" width="30%" align="left">
                                        ' . $image . '
                                    </td>
                                    <td style="font-family:sans-serif;border-collapse:collapse" width="70%" valign="top" align="left">
                                        <span style="font-size: 15px">' . $productName . '</span><br />
                                        ' . (isset($item->firmness) && $item->firmness <> "" ? '<span style="width:150px; display:inline-block; font-weight: bold; font-size: 13px">Firmness: </span><span style="font-size: 13px">' . $item->firmness . '</span><br />' : '') . '
                                        ' . (isset($item->product_size) && $item->product_size <> "" ? '<span style="width:150px; font-weight: bold; display:inline-block; font-size: 13px">Size: </span><span style="font-size: 13px">' . $item->product_size . '</span><br />' : '') . '
                                        ' . (isset($item->price) ? '<span style="width:150px; display:inline-block; font-weight: bold; font-size: 13px">Price: </span><span style="font-size: 13px">$' . number_format($item->price, 2) . '</span><br />' : '') . '
                                        ' . (isset($item->open_mattress) ? '<span style="width:150px; display:inline-block; font-weight: bold; font-size: 13px">Open Mattress: </span><span style="font-size: 13px">Yes</span><br />' : '') . '
                                        <span style="width:150px; display:inline-block; font-weight: bold; font-size: 13px">Shipping Option: </span><br />' . ($this->getShippingTypeName($orderItem)) . '
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                ';
            $key++;
        } // end foreach

        try {
            $totalShippingCost = number_format($totalShippingCost, 2);
            $empID = 'SleePare';
            $emailFrom = 'info@sleepare.com';
            $password = 'ftvahfkneuxkguwr';
            $sendTo = $request->user_email;
            $email_logo = 'https://newyork.sleepare.com/images/sleepare-tab-logo.png';
            $txt = view(
                "frontend.default.notification.email",
                compact(
                    'shippingAddress',
                    'totalCost',
                    'date',
                    'customerName',
                    'orderItems',
                    'email_logo',
                    'orderID',
                    'customerEmail',
                    'totalTax',
                    'totalShippingCost'
                )
            );

            //checkmail
            $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $emailFrom;                          // SMTP username
            $mail->Password = $password;                             // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            $mail->Port = 465;                                    // Set the SMTP port number - 587 for authenticated TLS
            $mail->setFrom($emailFrom, $empID);                        // Set who the message is to be sent from
            $mail->addAddress($sendTo, $request->f_name);            // Add a recipient
            //$mail->addBCC($c_email);
            // $mail->addCC($to);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Thank you ' . $customerName . ' for your order #' . $orderID;
            $mail->Body    = $txt;

            if (!$mail->send()) {
                return '<h1>Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo . '</h1>';
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }

        // $this->klarnaCheckout($order_items, $order->tax, $request->paid_amount);
        $hash = md5($customerName);
        $cancel_link = url('/cancel/order/' . $orderID . '?token=' . $hash);

        // dd($cancel_link);
        $this->sendsms(
            $request->mobile_num,
            "Thank you for choosing SleePare! We help you find your dream mattress so you can enjoy a relaxing sleep.\n\n" .
                "We have processed your order for " . implode(", ", $subjectNames) . " and will be delivered to you at " . $request->address . ", " . $request->aprtment_num . " " . $request->zipcode . "\n\n" .
                "Please reply with “ok” if the information you provided is correct. In case you want to make changes, you can call us at +1 (347) 980-0044.\n\n" .
                "If you wish to cancel the order, follow the link here " . $cancel_link . ".\n\n" .
                "Once again, thank you for shopping with us!\n\n" .
                "- SleePare Customer Service Team"
        );


        \LaraCart::destroyCart();
        session()->forget('checkout-form');


        return Redirect::route('thank-you');
    }

    private function getShippingTypeName($item): string
    {
        if (empty($item->shipping_type)) {
            return '';
        }

        $shippingD = '';
        switch ($item->shipping_type) {
            case 1:
                $shippingD .= '<span style="font-size:12px;">Regular shipping immediatly';
                $shippingD .= '<br />Mattress Removal: ' . ($item->option_1_1 == 1 ? "Yes" : "No");
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 2:
                $shippingD .= '<span style="font-size:12px;">White Glove shipping immediately';
                $shippingD .= '<br />Mattress Removal: ' . ($item->option_2_1 == 1 ? "Yes" : "No");
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 3:
                $shippingD .= '<span style="font-size:12px;">Picked up';
                $shippingD .= '<br />Picked up: ' . $item->option_3_1;
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 4:
                $shippingD .= '<span style="font-size:12px;">Will Pick up';
                $shippingD .= '<br />Product in stock: ' . ($item->option_4_1 == 1 ? "Yes" : "No");
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                if (!empty($item->option_4_2)) {
                    $shippingD .= '<br /><i style="font-size:12px;">Comment: ' . $item->option_4_2 . '</i>';
                }
                break;
            case 5:
                $shippingD .= '<span style="font-size:12px;">Partly Pick up';
                $shippingD .= '<br />Please specify what was picked up and suppose to be ordered: ' . $item->option_5_1;
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 6:
                $shippingD .= '<span style="font-size:12px;">Free delayed curbside';
                $shippingD .= '<br />Please enter the first day when you will be ready to receive the product: ' . $item->option_6_1;
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 7:
                $shippingD .= '<span style="font-size:12px;">Delayed - White Glove';
                $shippingD .= '<br />Please choose a date to deliver: ' . $item->option_7_1;
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 8:
                $shippingD .= '<span style="font-size:12px;">Drop Off';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 9:
                $shippingD .= '<span style="font-size:12px;">Free curbside delivery';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 10:
                $shippingD .= '<span style="font-size:12px;">WG W/ASSEMBLY - no removal';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 11:
                $shippingD .= '<span style="font-size:12px;">Drop off';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 12:
                $shippingD .= '<span style="font-size:12px;">Picked up';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 13:
                $shippingD .= '<span style="font-size:12px;">Will Pick up';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                if (!empty($item->option_13_1)) {
                    $shippingD .= '<br /><i style="font-size:12px;">Comment: ' . $item->option_13_1 . '</i>';
                }
                break;
            case 14:
                $shippingD .= '<span style="font-size:12px;">Regular shipping';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 15:
                $shippingD .= '<span style="font-size:12px;">Picked up';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                break;
            case 16:
                $shippingD .= '<span style="font-size:12px;">Will Pick up';
                $shippingD .= '<br />Shipping Cost: $' . (isset($item->shipping_cost) ? $item->shipping_cost : "0") . '</span>';
                if (!empty($item->option_16_1)) {
                    $shippingD .= '<br /><i style="font-size:12px;">Comment: ' . $item->option_16_1 . '</i>';
                }
                break;
        }
        return $shippingD;
    }

    public function sendsms($number, $body)
    {
        try {
        } catch (\Exception $e) {
            // exception
        }
    }

    public function cencelOrder($id)
    {

        $order = Order::find($id);
        $orderItems = '';
        $customerName = $order->first_name . " " . $order->last_name;

        $hash = md5($customerName);
        $url_hash = $_GET["token"];

        if ($order->tracking_receipt_status != 'sent' && $hash == $url_hash) {

            foreach ($order->orderItems as $item) {

                if (!empty($item->product_id)) {
                    $product = Product::find($item->product_id);
                    $imagePath = str_replace(" ", "%20", \URL::asset('uploads/' . $product->photo));

                    $tiem_name = $item->name;
                    $item_qty  = $item->qty;
                    $item_price = $item->price;
                }

                $orderItems .= '
                    <tr style="font-family:sans-serif">
                        <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="left">
                            <table style="font-family:sans-serif; width: 100%;" cellspacing="0" cellpadding="0" border="0">
                                <tbody style="font-family:sans-serif">
                                    <tr style="font-family:sans-serif">
                                        <td style="padding-right:20px;font-family:sans-serif;border-collapse:collapse" width="33%" align="left">
                                            ' . (!empty($imagePath) ? '<img src="' . $imagePath . '" style="max-width:175px;font-family:sans-serif" width="175" align="left">' : '') . '
                                        </td>
                                        <td style="font-family:sans-serif;border-collapse:collapse" width="33%" valign="top" align="left">
                                            <p style="font-family:sans-serif">' . $tiem_name . '<br style="font-family:sans-serif">
                                                Quantity: ' . $item_qty . '
                                                ' . (isset($item->firmness) && !empty($item->firmness) ? '<br style="font-family:sans-serif"> Firmness: ' . $item->firmness : '') . '
                                                ' . (isset($item->product_size) && $item->product_size <> "" ? '<br style="font-family:sans-serif"> Size: ' . $item->product_size : '') . '
                                            </p>
                                        </td>
                                        <td style="font-family:sans-serif;border-collapse:collapse; vertical-align:middle;" width="33%" valign="top" align="right">
                                            <p style="font-family:sans-serif">$' . $item_price . '</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    ';
            } // end foreach


            return view('frontend.default.shop.order.cancel', [
                'orderItems' => $orderItems,
                'customerName' => $customerName,
                'tax' => $order->tax,
                'totalCost' => $order->total,
                'hash' => $hash,
                'order_id' => $order->id
            ]);
        } else {
            return redirect('https://www.sleepare.com');
        }
    } // cancel order coming from sms


    public function cancelOrderRequest(Request $request, $id)
    {
        $order = Order::find($id);
        $orderItems = '';

        $customerName = $order->first_name . " " . $order->last_name;

        $hash = md5($customerName);
        $url_hash = $request->hash_token;

        if ($order->tracking_receipt_status != 'sent' && $hash == $url_hash) {
            $order->cancelled = 1;
            $order->save();

            $empID = 'Roy Yosef';
            $emailFrom = 'roy@sleepare.com';
            $password = config('app.roy_email');
            $sendTo = $order->email;

            $txt = '<table>
                        <tbody>
                            <tr style="font-family:sans-serif">
                                <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:0 30px" bgcolor="#ffffff" align="left">
                                    <p style="margin-bottom:10px;font-family:sans-serif">Hello ' . $customerName . ', <br />
                                    Your cancellation request for order #' . $order->id . ' has been submitted. Kindly wait while we process it. You will be refunded within the next 24 hours.</p>
                                    <p>Want to buy a new mattress? Check out our top recommended products here <a target="_blank" style="color:#243374;" href="https://www.sleepare.com/">sleepare.com</a>.</p>
                                    <p style="font-style:italic;">- SleePare Customer Service Team</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>';

            $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $emailFrom;                          // SMTP username
            $mail->Password = $password;                             // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            $mail->Port = 465;                                    // Set the SMTP port number - 587 for authenticated TLS
            $mail->setFrom($emailFrom, $empID);                        // Set who the message is to be sent from
            $mail->addAddress($sendTo, $request->first_name);      // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Your request for cancellation has been received - Order #" . $order->id;
            $mail->Body    = $txt;


            if (!$mail->send()) {
                return '<h1>Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo . '</h1>';
            }

            return view('frontend.default.shop.order.thankyou-cancel', [
                'customerName' => $customerName,
                'order_id' => $order->id
            ]);
        } else {
            return redirect('https://www.sleepare.com');
        }
    }


    public function klarnaCheckout($order_items, $tax, $total)
    {

        $merchantId     = "PN01094_b191c67d3f71";
        $sharedSecret   = "WInskd9LGUf3Rlem";

        $apiEndpoint = \Klarna\Rest\Transport\ConnectorInterface::NA_TEST_BASE_URL;

        $connector = \Klarna\Rest\Transport\GuzzleConnector::create(
            $merchantId,
            $sharedSecret,
            $apiEndpoint
        );

        $order = [

            "purchase_country" => "us",
            "purchase_currency" => "usd",
            "locale" => "en-us",
            "order_amount" => (float)$total,
            "order_tax_amount" => $tax,
            "order_lines" => $order_items,

            "merchant_urls" => [
                "terms" => "https://www.example.com/terms.html",
                "cancellation_terms" => "https://www.example.com/terms/cancellation.html",
                "checkout" => "https://www.example.com/checkout.html",
                "confirmation" => "https://www.example.com/confirmation.html",

                // Callbacks
                "push" => "https://www.example.com/api/push",
                "validation" => "https://www.example.com/api/validation",
                "shipping_option_update" => "https://www.example.com/api/shipment",
                "address_update" => "https://www.example.com/api/address",
                "notification" => "https://www.example.com/api/pending",
                "country_change" => "https://www.example.com/api/country"
            ]
        ];

        // dd($order);


        try {
            $checkout = new \Klarna\Rest\Checkout\Order($connector);
            $checkout->create($order);

            $orderId = $checkout->getId();
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public function savesession($data = null)
    {

        session(['checkout-form' => $data]);
    } // save form data in session

}
