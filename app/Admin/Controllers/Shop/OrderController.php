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
            $grid->disableFilter();

            $grid->created_at()->display(function () {
                return date('Y-m-d H:i A', strtotime($this->created_at));
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

                if(!empty($order->shipping_options)){
                    $shippingD = '<h2>Shipping Options</h2>';
                    $json = json_decode($order->shipping_options, true);

                    $shippingD .= '<h4>'.$json["label"].'</h4>';

                    foreach($json["options"] as $options){
                        $shippingD .= '<p><b>'.$options["name"].'</b>: '.$options["value"].'</p>';
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
            
            // $form->text('product_name');
            // $form->text('additional_products');
            // $form->text('size');
            // $form->text('firmness');

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
        });
    }
}