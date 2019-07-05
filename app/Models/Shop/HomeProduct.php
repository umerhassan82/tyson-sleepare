<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class HomeProduct extends Model
{
    protected $table = 'home_products';

    protected $fillable = [
        'sizes'
    ];

    public function brand(){
        return $this->belongsTo('App\Models\Shop\ShopBrands');
    }

    Public function setSizesAttribute($extra)
    {
        $this->attributes['sizes'] = json_encode(array_values($extra));
    }

    Public function getSizesAttribute($extra)
    {
        return array_values(json_decode($extra, true) ?: []);
    }

    protected $casts = [
        'sizes' => 'json',
    ];

}
