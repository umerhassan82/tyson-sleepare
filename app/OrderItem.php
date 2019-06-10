<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [];

    public function orderItems(){
        return $this->belongsTo('App\Models\Shop\Order', 'order_id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Shop\Product', 'product_id');
    }
}