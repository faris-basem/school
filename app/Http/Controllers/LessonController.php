<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function new_lesson(Request $request)
    {
        $lesson = new Lesson();
        $lesson->name=$request->name;
        $lesson->section_id=$request->section_id;
        $lesson->save();

        return response()->json([
            'message'=>'fetch data successfully',
            'code'=>200,
            'data'=>$lesson
        ]);
    }
}
