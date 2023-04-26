<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function subscriber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'level_id' => 'required|integer',
            'phone'    => 'required|numeric|unique:subscribers',
            'address'  => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'code' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }
        $sub=new Subscriber();
        $sub->name=$request->name;
        $sub->level_id=$request->level_id;
        $sub->phone=$request->phone;
        $sub->address=$request->address;
        $sub->save();




        return response()->json([
            'message'=>'fetch data successfully',
            'code'=>200,
            'data'=>$sub
        ]);
    }
}
