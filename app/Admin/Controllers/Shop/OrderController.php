<?php
namespace App\Admin\Controllers\Shop;

use App\Http\Controllers\Controller;
//use App\Models\Shop\Category;
//use App\Models\Shop\Product;
use App\Models\Shop\Order;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use App\OrderItem;
use App\Models\Shop\Product;
//use Encore\Admin\Tree;

class OrderController extends Controller
{
    use ModelForm;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Orders');
            $content->breadcrumb(
                ['text' => 'Shop'],
                ['text' => 'Orders', 'url' => '/shop/orders']
            );
            $content->body($this->grid());
            // $content->body(Admin::show(Order::findOrFail(2), $this->grid()));
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->model()->orderBy('created_at', 'desc');
            $grid->id();
            $grid->first_name()->editable();
            $grid->email()->editable();
            $grid->phone()->editable();

            $grid->column('Products')->display(function () {
                $items = OrderItem::where('order_id', $this->id)->get();
                $html = array();
                foreach($items as $key => $item){
                    $product = Product::find($item->product_id);
                    $html[] =  ($key+1).": ".$product->title.' x '.($item->qty>1? $item->qty : 1);
                }
                if(count($html) > 0)
                    return implode("<br />", $html);
                else
                    return '';
            });

            $grid->column('Size')->display(function () {
                $items = OrderItem::where('order_id', $this->id)->get();
                $html = array();
                foreach($items as $key => $item){
                    if(!empty($item->size))
                        $html[] =  ($key+1).": ".$item->size;
                }
                if(count($html) > 0)
                    return implode("<br />", $html);
                else
                    return '';
            });

            $grid->column('Firmness')->display(function () {
                $items = OrderItem::where('order_id', $this->id)->get();
                $html = array();
                foreach($items as $key => $item){
                    if(!empty($item->firmness))
                        $html[] =  ($key+1).": ".$item->firmness;
                }
                if(count($html) > 0)
                    return implode("<br />", $html);
                else
                    return '';

            });

            // $grid->column('Status')->display(function () {
            //     $text = $this->tracking_receipt_status;

            //     $color = '';
            //     if (strpos($text, 'submitted') !== false) {
            //         $color = 'd96e53'; // orange
            //     }else if(strpos($text, 'processed') !== false){
            //         $color = '00aeed'; // blue
            //     }else if(strpos($text, 'sent') !== false){
            //         $color = '457a33'; //green
            //     }

            //     return '<span style="background-color:#'.$color.';padding: 8px 15px;text-align: center;color: #fff;">'.ucfirst($this->tracking_receipt_status).'</span>';
            // })->setAttributes(['style' => 'padding:0px;vertical-align: middle;text-align: center;']);

            $grid->column('tracking_receipt_status','Status')->editable('select', [
                'submitted' => 'Submitted',
                'processed' => 'Processed',
                'sent'      => 'Sent'
            ]);

            
            $grid->column("")->display(function(){

                $text = $this->tracking_receipt_status;
                $color = '';
                if (strpos($text, 'submitted') !== false) {
                    $color = 'fb8801'; // orange
                }else if(strpos($text, 'processed') !== false){
                    $color = '00aeed'; // blue
                }else if(strpos($text, 'sent') !== false){
                    $color = '457a33'; //green
                }
                return '<span style="background-color:#'.$color.';padding: 8px 15px;text-align: center;color: #fff;"></span>';
            });
            
            $grid->comment()->editable();
            $grid->total()->editable();
            
            $grid->disableExport();
            //$grid->disableFilter();

            $grid->origin("From")->display(function () {
                return ucfirst($this->origin);
            });
            
            $grid->created_at()->display(function () {
                return date('Y-m-d H:i A', strtotime($this->created_at));
            });

            $grid->filter(function($filter){

                // Remove the default id filter
                $filter->disableIdFilter();
            
                // Add a column filter
                $filter->like('first_name', 'first_name');

                $filter->scope('trashed', 'Trashed')->onlyTrashed();
            
            });
            

            $grid->actions(function ($actions) {
                $actions->disableView();
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Edit');
            $content->breadcrumb(
                ['text' => 'Shop'],
                ['text' => 'Orders', 'url' => '/shop/orders'],
                ['text' => 'Edit']
            );
            $content->body($this->form($id)->edit($id));
        });
    }

    public function update($id)
    {
        return $this->form($id)->update($id);
    }
    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('Create new');
            $content->breadcrumb(
                ['text' => 'Shop'],
                ['text' => 'Orders', 'url' => '/shop/orders'],
                ['text' => 'Create new']
            );
            $content->body($this->form());
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        return Order::form(function (Form $form) use ($id) {

            if(!empty($id)){

                $items = OrderItem::where('order_id', $id)->get();
                $order = Order::find($id);
                $html = '';
                $email = '';
                $prodcts = array();

                foreach($items as $item){
                    $product = Product::find($item->product_id);
                    $prodcts[] = $product->title.' '.(!empty($item->firmness)? ", ".$item->firmness: "").' '.(!empty($item->size)? ", ".$item->size: "");
                    $html .= 
                        '<tr>
                            <td>'.$product->title.'</td>
                            <td>'.$item->firmness.'</td>
                            <td>'.$item->size.'</td>
                            <td>$'.$item->price.'</td>
                        </tr>';
                }

                $email = '
                    <table style="width:100%;">
                        <tr>
                            <td style="border:1px solid #ccc; padding:10px;">1/1</td>
                            <td style="border:1px solid #ccc; padding:10px;">'.$order->first_name.'</td>
                            <td style="border:1px solid #ccc; padding:10px;">'.$order->last_name.'</td>
                            <td style="border:1px solid #ccc; padding:10px;">'.implode("<br />", $prodcts).'</td>
                            <td style="border:1px solid #ccc; padding:10px;">'.$order->email.'</td>
                            <td style="border:1px solid #ccc; padding:10px;">'.$order->phone.'</td>
                            <td style="border:1px solid #ccc; padding:10px;">'.$order->address.', '.$order->apartment_num.' '.$order->state.' '.$order->zipcode.'</td>
                        </tr>
                    </table>

                ';


                $shippingD = '';

                // if(!empty($order->shipping_options)){
                //     $shippingD = '<h2>Shipping Options</h2>';
                //     $json = json_decode($order->shipping_options, true);

                //     $shippingD .= '<h4>'.$json["label"].'</h4>';

                //     foreach($json["options"] as $options){
                //         $shippingD .= '<p><b>'.$options["name"].'</b>: '.$options["value"].'</p>';
                //     }
                // }

                // echo($order->shipping_type);

                if(!empty($order->shipping_type)){
                    $shippingD = '<h2>Shipping Options</h2>';
                    switch($order->shipping_type){
                        case 1:
                            $shippingD .= '<h4>Regular shipping immediatly</h4>';
                            $shippingD .= '<p><b>Assembly</b>: '.($order->option_1_1 == 1? "Yes" : "No").'</p>';
                            $shippingD .= '<p><b>Mattress Removal</b>: '.($order->option_1_2 == 1? "Yes" : "No").'</p>';
                        break;
                        case 2:
                            $shippingD .= '<h4>White Glove shipping immediately</h4>';
                            $shippingD .= '<p><b>Assembly</b>: '.($order->option_2_1 == 1? "Yes" : "No").'</p>';
                        break;
                        case 3:
                            $shippingD .= '<h4>Picked up</h4>';
                            $shippingD .= '<p><b>Picked up</b>: '.$order->option_3_1.'</p>';
                        break;
                        case 4:
                            $shippingD .= '<h4>Will Pick up</h4>';
                            $shippingD .= '<p><b>Product in stock</b>: '.($order->option_4_1 == 1? "Yes" : "No").'</p>';
                        break;
                        case 5:
                            $shippingD .= '<h4>Partly Pick up</h4>';
                            $shippingD .= '<p><b>Please specify what was picked up and suppose to be ordered</b>: '.$order->option_5_1.'</p>';
                        break;
                        case 6:
                            $shippingD .= '<h4>Delayed - Regular</h4>';
                            $shippingD .= '<p><b>Please enter the first day when you will be ready to receive the product</b>: '.$order->option_6_1.'</p>';
                        break;
                        case 7:
                            $shippingD .= '<h4>Delayed - White Glove</h4>';
                            $shippingD .= '<p><b>Please choose a date to deliver</b>: '.$order->option_7_1.'</p>';
                            $shippingD .= '<p><b>Is there a specific time you prefer?</b>: '.($order->option_7_2 == 1? "Yes" : "No").'</p>';
                            $shippingD .= '<p><b>Morning/Afternoon</b>: '.$order->option_7_3.'</p>';
                        break;
                    }
                }

                $form->html('
                    <h2>Order Items</h2>
                    <table style="width:100%;">
                        <tr>
                            <th>Product Name</th>
                            <th>Firmness</th>
                            <th>Size</th>
                            <th>Price</th>
                        </tr>
                        '.$html.'
                    </table>
                    '.$shippingD.'
                ');
                
                $form->html('<h2>Email</h2>'.$email);
            }

            $form->divider();

            $form->select('shipping_type')
                ->options([
                    '0'  => 'Choose Option',
                    '1'  => 'Regular shipping immediatly',
                    '2'  => 'White Glove shipping immediately',
                    '3'  => 'Picked up',
                    '4'  => 'Will Pick up',
                    '5'  => 'Partly Pick up',
                    '6'  => 'Delayed - Regular',
                    '7'  => 'Delayed - White Glove',
                ]);


            $form->switch('option_1_1', 'Assembly');
            $form->switch('option_1_2', "Mattress Removal");
        
            $form->switch('option_2_1','Assembly');

            $form->text('option_3_1','Picked up')->default('Print Receipt with delivered certificate');
            

            $form->switch('option_4_1', "Product in stock");

            $form->text('option_5_1','Please specify what was picked up and suppose to be ordered')->setGroupClass("test");

            $form->date('option_6_1',"Please enter the first day when you will be ready to receive the product");

            $form->date('option_7_1', "Please choose a date to deliver");
            $form->switch('option_7_2', "Is there a specific time you prefer?");
            $form->select('option_7_3', "Morning/Afternoon")
                ->options([
                    'morning' => 'Morning',
                    'afternoon' => 'Afternoon'
                ]);


            $form->divider();


            $form->display('id', 'ID');
            $form->text('first_name');
            $form->text('last_name');
            $form->text('clover_trans_num');
            $form->text('email');

            $form->text('phone');
            $form->text('total');
            $form->text('address');

            $form->text('apartment_num');
            $form->text('state');
            $form->text('zipcode');
            
            $form->text('count');
            $form->text('status');
            $form->select('tracking_receipt_status')
                ->options([
                    'submitted' => 'Submitted',
                    'processed' => 'Processed',
                    'sent'      => 'Sent'
                ]);
            $form->text('assisted');
            $form->text('findus', 'How did you find us?');

            $form->textarea('comment')->rows(2);
            // $form->wangeditor('order', 'Order');
            $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');

            // $form->submitted(function (Form $form) {
            //     $form->ignore(['option_1', 'option-2', 'option-3', 'option-4', 'option-5', 'option-6', 'option-7']);
            // });
            // $form->saving(function (Form $form) {
            //     // $form->ignore(['option-1', 'option-2', 'option-3', 'option-4', 'option-5', 'option-6', 'option-7']);
            //     $value = $form->option_1;
            //     // dd($value);
            // });

        });
    }
}