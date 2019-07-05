<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ShopBrands extends Model
{
    protected $table = 'shop_brands';

    protected $fillable = [];

    public function products(){
        return $this->hasMany('App\Models\Shop\HomeProduct', 'brand_id');
    }

}