<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $guarded = [];
    public $timestamps=false;


    protected $appends = ['sections'];


    function getSectionsAttribute(){
        $sections = Section::where('subject_id',$this->id)->get(['id','name']);
        return $sections;
    }
}
