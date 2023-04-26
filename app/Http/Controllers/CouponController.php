<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function generate(Request $request)
    {
        $x=$request->num;
        for ($i=0; $i < $x; $i++) { 
            $ran=Str::random(10);
            $code=new Coupon();
            $code->code=$ran;
            $code->save();
        }

        return response()->json([
            'code'=>200,
            'message'=>'your codes are added successfully',                
        ]);
    }
}
