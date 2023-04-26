<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function new_level(Request $request)
    {
        $level = new Level();
        $level->name=$request->name;
        $level->save();

        return response()->json([
            'message'=>'fetch data successfully',
            'code'=>200,
            'data'=>$level
        ]);
    }
}
