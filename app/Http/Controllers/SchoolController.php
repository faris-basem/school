<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Subject;
use App\Models\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function level_data(Request $request)
    {
            $user=User::where('id',Auth::guard('api')->user()->id)->first();
            if($user->activated==1){
                    $ld=Level::where('id',$request->id)->get();
                    // $ld=Level::where('id',$request->id)->get()->makeHidden('subjects');
                    // foreach($ld as $d){
                    //     $d['subject']=Subject::where('level_id',$d->id)->get(['id','name']);

                        
                    //     foreach($d['subject'] as $s){
                    //         $s['sections']=Section::where('subject_id',$s->id)->get(['id','name']);

                           
                    //         foreach($s['sections'] as $k){
                    //             $k['lesson']=Lesson::where('section_id',$k->id)->get(['name']);
                    //         }
                    //     }
                
                    // }
                    return response()->json([
                        'code'=>200,
                        'data'=>$ld
                        
                    ]);

        }else{
            return response()->json([
                'code'=>400,
                'message'=>'Your profile is not activated'
                
            ]);
        }

    }

public function add_like(Request $request)
{
    $is_like = UserLike::where('user_id',Auth::guard('api')->user()->id)->where('level_id',$request->level_id)->first();
    
    if($is_like){
        $is_like->delete();

        return response()->json([
            'message'=>"removed like"
        ]);
    }else{
        $is_like = new UserLike();
        $is_like->user_id = Auth::guard('api')->user()->id;
        $is_like->level_id = $request->level_id;
        $is_like->save();

        return response()->json([
            'message'=>"added like"
        ]);
    }
}

    public function get_all_subjects(){
        $sub = Subject::all();
        return response()->json([
            'data'=>$sub
        ]);
    }
    
}
