<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BestBuyProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BestBuyController extends Controller
{
    //
    public function addbestbuypromo(Request $request)
    {
        try{
            $data = $request->all();
            $promo = new BestBuyProduct();
            $promo->bestbuy_stamp_code = Str::random(5) . rand(1000, 9999);
            $promo->stamp_name = $data['package_name'];
            $promo->stamp_quantity = $data['stamp_quantity'];
            $promo->dp = $data['dp'];
            $promo->sv = $data['sv'];
            $promo->bv = $data['bv'];
            $promo->cp = $data['cp'];
            $promo->save();
            // return response()->json(['message' => 'Promo added successfully'], 200);
            return redirect()->back()->with('status', 'Completed Successfully')->with('color', 'success');
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
