<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\UserLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;
    protected $table = 'levels';
    protected $guarded = [];
    public $timestamps=false;

    protected $appends = ['subjects','is_like'];


    function getSubjectsAttribute(){
        $subjects = Subject::where('level_id',$this->id)->get(['id','name']);
        return $subjects;
    }
    function getIsLikeAttribute(){
        if(Auth::guard('api')->check()){
            $is_like = UserLike::where('user_id',Auth::guard('api')->user()->id)->where('level_id',$this->id)->first();
            if($is_like){
             return true;
            }else{
             return false;
            }
        }else{
            return false;
        }
     
    }
}
