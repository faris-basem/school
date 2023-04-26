<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Level;
use App\Models\Coupon;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|numeric',
            'code'     => 'required',
            'password' => 'required|min:8'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'code' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }
        $coup=Coupon::where('code',$request->code)->first();
        $subs=Subscriber::where('phone',$request->phone)->first();
        if($subs && $coup&&$coup->is_activated==0){
            
            $subs->subscribed=1;
            $coup->is_activated=1;
            
            $date=time() + 365*24*60*60;
            $coup->expires_at=date('Y-m-d H:i:s',$date);
            
            $coup->save();
            // $date=Carbon::now();
            // $coup->expires_at=$date->addYear();
            
        $user = new User();
        $user->name =  $request->name;
        $user->email =  $request->email;
        $user->coupon =  $request->code;
        $user->expires_at =  $coup->expires_at;
        $user->password =  bcrypt($request->password);
        $user->save();



        $coup2=Coupon::where('id',$coup->id)->first();
        $coup2->user_id=$user->id;   
        $coup2->save();
       
        $subs->save();

        $user['token'] = $user->createToken('accessToken')->accessToken;
        
        
        
        
        return response()->json([
            'message'=>'fetch data successfully',
            'code'=>200,
            'data'=>$user
        ]);
    
    }else{
        return response()->json([
            'code'=>401,
            'message'=>'Make sure that the information is correct and fill in all fields',                
        ]);

    }
    }


    public function login(Request $request)
    {

      $loginData = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if ($loginData->fails()) {
        $errors = $loginData->errors();

        return response([
            'status'=>false,
            'message'=>'Make sure that the information is correct and fill in all fields',
            'errors'=>$errors,
            'code'=>422
        ]);
      }
        

        $user = User::where('email',$request->email)->first();

      

      

        if($user)
        {
          
            if (!Hash::check($request->password, $user->password)) {
        
                return response()->json(
                    ["errors"=>[
                        "password"=>[
                         "Invalid Password!"
                        ]
                    ],
                    "status"=>false,
                    'code' => 404,
                ]);
            }

            $ex=Coupon::where('user_id',$user->id)->first();
            if(time()>=strtotime($ex->expires_at)){
                Coupon::where('user_id',$user->id)->delete();
                User::where('id',$user->id)->delete();

                return response()->json(
                    ["errors"=>[
                        "message"=>[
                         "Your Registeration has expired!"
                        ]
                    ],
                    "status"=>false,
                    'code' => 404,
                ]);
                
            }
            $accessToken =     $user->createToken('authToken')->accessToken;

            return response([
                'code' => 200,
                'status' => true,
                'message' => 'login Successfully',
                'user' => $user,
                'access_token' => $accessToken
            ]);
        }
        else
        {
 
            return response()->json(
                ["errors"=>[
                    "email"=>[
                      "No Account Assigned To This email!"
                    ]
                ],
                "status"=>false,
                'code' => 404,
            ]);

        }

    }


    public function logout(){
            
        $user = Auth::guard('api')->user()->token();
        $user->revoke();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'logout Successfully',
            
        ]);
    }



    public function verify()
    {
        $ran=Str::random(6);
        $code=User::where('id',Auth::guard('api')->user()->id)->first();
        $code->code=$ran;
        $code->save();
        return response()->json([
            'code'=>200,
            'data'=>$ran,
            
        ]);
    }

    public function activate(Request $request)
    {
        $user=User::where('id',Auth::guard('api')->user()->id)->first();
        if($user->code==$request->code)
        {
            $user->activated=1;
            $user->save();

            return response()->json([
                'code'=>200,
                'message'=>'your profile is activated',                
            ]);
        }
    }

    public function forgot(Request $request)
    {
        $ran=Str::random(6);
        $user=User::where('email',$request->email)->first();
        $user->code=$ran;
        $user->save();
        return response()->json([
            'code'=>200,
            'data'=>$ran,
            
        ]);
    }

    public function chang_pass(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if($user->code==$request->code){
            $user->password=bcrypt($request->password);
            $user->save();
            return response()->json([
                'code'=>200,
                'message'=>'your password is updated successfully',
                'data'=>$user,
                
            ]);
        }
    }



    public function gg(Request $request)
    {
        try{
            DB::beginTransaction();
            $level = new Level();
            $level->name=$request->name;
            $level->save();

            
            $subject = new Subject();
            $subject->name=$request->namee;
            $subject->level_id=$request->level_id;
            $subject->save();
            
            // $section = new Section();
            // $section->name=$request->name;
            // $section->subject_id=$request->subject_id;
            // $section->save();
            
            // $lesson = new Lesson();
            // $lesson->name=$request->name;
            // $lesson->section_id=$request->section_id;
            // $lesson->save();

        DB::commit();
        return response()->json([
            'code'=>200,
            'data'=>"added",
            
        ]);

     } catch (\Exception $e) {
           
        return response()->json([
            'code'=>401,
            'data'=>"somthing error",
            'error'=>$e,
            
        ]);
        
        }
       
        
        
        
        
        
        

    }


}
