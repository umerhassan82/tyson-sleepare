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
            $grid->comment()->editable();
            // $grid->size()->display(function ($order) {
            //     return html_entity_decode($order);
            // });
            $grid->total()->editable();
            $grid->disableExport();
            $grid->disableFilter();
            $grid->created_at();
            $grid->updated_at();

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
                $html = '';

                foreach($items as $item){
                    $product = Product::find($item->product_id);
                    $html .= 
                        '<tr>
                            <td>'.$product->title.'</td>
                            <td>'.$item->firmness.'</td>
                            <td>'.$item->size.'</td>
                            <td>$'.$item->price.'</td>
                        </tr>';
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
                ');
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
            $form->text('city');
            $form->text('zipcode');
            
            // $form->text('product_name');
            // $form->text('additional_products');
            // $form->text('size');
            // $form->text('firmness');

            $form->text('count');
            $form->text('status');
            $form->text('tracking_receipt_status');
            $form->text('assisted');
            $form->text('findus', 'How did you find us?');

            $form->textarea('comment')->rows(2);;
            // $form->wangeditor('order', 'Order');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}