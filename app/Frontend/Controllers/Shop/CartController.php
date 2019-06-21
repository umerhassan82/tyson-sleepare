<?php
namespace App\Http\Controllers\Frontend\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use LukePOLO\LaraCart\Facades\LaraCart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart_data = [];
        foreach($items = LaraCart::getItems() as $item) {
            $cart_data[$item->id]['id']         = $item->id;
            $cart_data[$item->id]['name']       = $item->name;
            $cart_data[$item->id]['image']      = $item->photo;
            $cart_data[$item->id]['slug']       = $item->slug;
            $cart_data[$item->id]['cost']       = $item->price;
            $cart_data[$item->id]['cat_id']     = $item->cat_id;
            $cart_data[$item->id]['qty']        = $item->qty;
            $cart_data[$item->id]['dis_value']  = $item->discount_value;
            $cart_data[$item->id]['dis_type']   = $item->discount_type;
            $cart_data[$item->id]['full_price'] = $item->full_price;
            $cart_data[$item->id]['firmness']   = $item->firmness;
            $cart_data[$item->id]['size']       = $item->product_size;
            $cart_data[$item->id]['product_id'] = $item->product_id;
        }
        $total = LaraCart::total($formatted = false, $withDiscount = true);

        return view('frontend.'.config('template').'.shop.cart.index', ['cart' => $cart_data, 'total' => $total ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \LukePOLO\LaraCart\Exceptions\ModelNotFound
     */
    public function store(Request $request)
    {
//        LaraCart::destroyCart();

        // dd($request);

        $product_id = $request->product_id;
        $product_qty = $request->qty;
        $product_price = $request->product_price;
        $price = $product_price;

        if(isset($request->discoutValue) && !empty($request->discoutValue)){
            switch($request->discountType){
                case 1: // 1- percent
                    $price = $product_price - (($request->discoutValue * $product_price) / 100);
                break;
                case 2: // 2- Flat
                    $price = $product_price - $request->discoutValue;
                break;
            }// end switch
        }// end if

        $product_price = $price;

        
        $product = Product::where('id', $product_id)->firstOrFail();
        $new_id = rand(100, 999).$product_id;

        // $item = LaraCart::find(['id' => $new_id, 'price' => $product_price]);
        // if ( $item ) {
        //     LaraCart::updateItem($item->getHash(), 'qty', $item->qty+$product_qty);
        // } else {
            LaraCart::add(
                $new_id,
                $product->title,
                $product_qty,
                $product_price,
                $options = [
                    'photo'             =>  $product->photo,
                    'slug'              =>  $product->slug,
                    'cat_id'            =>  $product->cat_id,
                    'discount_value'    =>  $request->discoutValue,
                    'discount_type'     =>  $request->discountType, // 1- percent, 2- Flat
                    'full_price'        =>  $request->product_price,
                    'product_size'      =>  $request->product_size,
                    'firmness'          =>  (isset($request->fimness_level) ? $request->fimness_level : ''),
                    'product_id'        =>  $product_id
                ]
            );
        // }

        return redirect('cart');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Cart  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = LaraCart::find(['id' => $id]);

        LaraCart::removeItem($item->getHash());
        return redirect('cart');
    }
}