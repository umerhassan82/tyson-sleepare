<?php
namespace App\Models\Shop;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use AdminBuilder, SoftDeletes;

    protected $table = 'shop_orders';


    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }


}