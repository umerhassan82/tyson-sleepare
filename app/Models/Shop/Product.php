<?php
namespace App\Models\Shop;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use AdminBuilder, SoftDeletes;
    
    protected $table = 'shop_products';

    public function categories()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function product()
    {
        return $this->hasMany('App\OrderItem');
    }
}