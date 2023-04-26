<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $guarded = [];
    public $timestamps=false;



    protected $appends = ['lessons'];


    function getlessonsAttribute(){
        $lesson = Lesson::where('section_id',$this->id)->get(['id','name']);
        return $lesson;
    }
}
