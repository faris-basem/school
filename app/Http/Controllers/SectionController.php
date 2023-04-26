<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function new_section(Request $request)
    {
        $section = new Section();
        $section->name=$request->name;
        $section->subject_id=$request->subject_id;
        $section->save();

        return response()->json([
            'message'=>'fetch data successfully',
            'code'=>200,
            'data'=>$section
        ]);
    }
}
