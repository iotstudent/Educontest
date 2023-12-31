<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use \Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Str;
use App\Http\Requests\ProfileUpdateRequest;

class AuthController extends Controller
{
    
    // resgister user 
    public function register(Request $request)
    {
        // collect all the inputs stored in the request variable , validate them and bundle them in an array
        $fields = $request->validate([
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'phone_number'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $checkUser = User::where('email', $request->email)->first();

       

      // insert the values in the array into DB extracting them from the fields array
        $user = User::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'email'=>$fields['email'],
            'phone_number'=> $fields['phone_number'],
            'password'=>bcrypt($fields['password'])
        ]);

       

        // generate a token for the user
        $token = $user->createToken('myapptoken')->plainTextToken;

        // send user token and user details 
        $response = [
            'Message' => "Registration Successful"
        ];

        return response ($response, 200);
    }


    // update user profile 
    public function update(Request $request)
    {   
        $fields = $request->validate([
            'id' =>'required',
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'phone_number'=>'required|string',
            'email' => 'required|string'
        ]);

        $UpdateDetails = User::where('id', $request->id)->first();

        if (is_null($UpdateDetails)) {
            return response('Error', 401);
        }

        $UpdateDetails->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'updated_at' => now()
        ]);

        return response('Profile updated successfully');
    }
   

    //login
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password'=>'required|string'
        ]);
        //check user email
        $user = User::where('email',$fields['email'])->first();
        
        //check password
        if( !$user || !Hash::check($fields['password'],$user->password)){
            return response([
                    'message' => 'Wrong Login Details'
            ],401);
        }


        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user' =>$user,
            'token'=>$token
        ];

        return response($response,201);
    }

    //logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message'=>'Logged out'
        ];
    }

    // submit forgot password 
    public function ForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(8);

        $check = DB::table('password_reset_tokens')->where(['email' => $request->email])->first();
        if($check){
            DB::table('password_reset_tokens')->where(['email' => $request->email])->update([ 'token' => $token, ]);
            Mail::send('email.forgotpassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });
    
            return response ('We have sent an OTP to your Email',200);

        }else{

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
              ]);
    
            Mail::send('email.forgotpassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });
    
            return response ('We have sent an OTP to your Email',200);

        }

       
    }

    
 

    // submit reset form
    public function ResetPassword(Request $request)
      {
          $request->validate([
               'token'=> 'required',
              'email' => 'required|email|exists:users',
              'password' => 'required|string|confirmed',
          ]);
  
          $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return response ('Invalid token!',401);
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => bcrypt($request->password)]);
 
          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
  
          return response ('Your password has been changed!',200);
      }

       // resgister user 
   
       public function countUsers() {
        
        $Users = User::where('role', 'user');
        $userCount = $Users->count();
        $response = ['Number_of_Users'=>$userCount];
        return response ($response, 200);
    }


}
