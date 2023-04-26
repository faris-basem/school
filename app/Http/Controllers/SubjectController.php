<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function new_subject(Request $request)
    {
        $subject = new Subject();
        $subject->name=$request->name;
        $subject->level_id=$request->level_id;
        $subject->save();

        return response()->json([
            'message'=>'fetch data successfully',
            'code'=>200,
            'data'=>$subject
        ]);
    }
}
