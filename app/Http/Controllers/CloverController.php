<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloverController extends Controller
{
    
    public function add(Request $request){

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://apisandbox.dev.clover.com/v3/merchants/W2352ZC5EKN51/items?access_token=f49a96f8-0bc3-774b-52be-d26e55eab790', [
            "json" => [
                "hidden"        => "false",
                "name"          => $request->name,
                "alternateName" => $request->alternateName,
                "code"          => $request->code,
                "sku"           => $request->sku,
                "price"         => $request->price,
                "priceType"     => "FIXED"
            ]
        ]);

        return response()->json($response->getBody());
    }
}