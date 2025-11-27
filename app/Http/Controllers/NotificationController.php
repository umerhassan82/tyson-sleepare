<?php

namespace App\Http\Controllers;

use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\OrderItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class NotificationController extends Controller
{

    public function generatePaymentLink($order_id){

        $order = Order::find($order_id);

        $customerName = $order->first_name." ".$order->last_name;

        $emailAddress = $order->email;

        $date = date('Y/m/d', strtotime($order->created_at));

        $shippingAddress = '
            <p style="font-family:sans-serif;margin:0px">'.$customerName.'</p>
            <p style="font-family:sans-serif;margin:0px">'.$order->address.', '.$order->apartment_num.'</p>
            <p style="font-family:sans-serif;margin:0px">'.$order->city.', '.$order->zipcode.'</p>
        ';

        $totalCost = $order->total;

        $subjectNames = array();
        $orderItems = '';

        $items = OrderItem::where('order_id', $order->id)->get();


        foreach($items as $item){

            $imagePath = '';
            if(!empty($item->product_id)){
                $product = Product::find($item->product_id);

                $tiem_name = $product->title;

                if(!empty($product->photo))
                    $imagePath = str_replace(" ","%20", 'https://newyork.sleepare.com/uploads/'.$product->photo);

            }else{
                $tiem_name = $item->product_name;
            }

            $subjectNames[] = $tiem_name;
            $orderItems .= '
                <tr style="font-family:sans-serif">
                    <td style="color:rgb(63,63,60);font-size:16px;font-family:sans-serif;border-collapse:collapse;padding:30px" bgcolor="#ffffff" align="left">
                        <table style="font-family:sans-serif;width: 100%;" cellspacing="0" cellpadding="0" border="0">
                            <tbody style="font-family:sans-serif">
                                <tr style="font-family:sans-serif">
                                    <td style="padding-right:20px;font-family:sans-serif;border-collapse:collapse; vertical-align: middle;" width="23%" align="left">
                                        '.(!empty($imagePath)?'<img src="'.$imagePath.'" style="max-width:175px;font-family:sans-serif" width="175" align="left">':'').'
                                    </td>
                                    <td style="font-family:sans-serif;border-collapse:collapse; vertical-align: middle;" width="38%" valign="top" align="left">
                                        <p style="font-family:sans-serif">'.$tiem_name.'<br style="font-family:sans-serif">
                                            <br style="font-family:sans-serif"> Quantity: '.$item->qty.'
                                            '.(isset($item->firmness)&& !empty($item->firmness) ? '<br style="font-family:sans-serif"> Firmness: '.$item->firmness: '').'
                                            '.(isset($item->size)&& $item->size<>""? '<br style="font-family:sans-serif"> Size: '.$item->size: '').'
                                        </p>
                                    </td>
                                    <td style="font-family:sans-serif;border-collapse:collapse; vertical-align: middle;" width="38%" valign="top" align="right">
                                        <p style="font-family:sans-serif">$'.$item->price.'</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                ';
        }

        $emailSubject = 'Thank you '.$customerName.' for order of '.implode(", ", $subjectNames);

        $tax = '';

        $shipping_cost = empty($order->shipping_cost) ? 0.00 : $order->shipping_cost;
        $ask_details = $order->ask_details;

        if($order->origin == 'tyson' && !empty($order->tax)){
            $tax = '<p style="margin-bottom:10px;font-family:sans-serif"><span style="color:rgb(162,162,162);font-family:sans-serif">Tax:</span> $'.$order->tax.' USD</p>';
        }

        // Create Stripe PaymentIntent with multiple payment methods
        $secretKey = '';
        $intentId = '';
        if ($totalCost > 0) {
            $stripeConfig = \Config::get('services');
            Stripe::setApiKey($stripeConfig["stripe"]["secret"]);
            $paymentIntent = PaymentIntent::create([
                'amount' => round($totalCost * 100, 2),
                'currency' => 'usd',
                'payment_method_types' => ['card', 'affirm', 'klarna'],
            ]);
            $secretKey = $paymentIntent->client_secret;
            $intentId = $paymentIntent->id;
        }

        return view("paymentlink", compact('shippingAddress', 'totalCost', 'date', 'customerName', 'orderItems', 'emailAddress', 'order_id', 'tax', 'shipping_cost', 'ask_details', 'secretKey', 'intentId'));

    } // end function

    public function thankyou(){
        return view("thankyou");
    }

}
