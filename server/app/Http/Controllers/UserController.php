<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;
class UserController extends Controller
{
    //
    /**
     * Signin User
     */
    public function signinUser(Request $request){
        $usernameOrEmail = $request->usernameOrEmail;
        $password = $request->password;
        $user = User::where('username','=',$usernameOrEmail)->
            orWhere('email','=',$usernameOrEmail)->
            first();
        if($user == null){
            return response([
                'success' => false,
                'message' => 'no such user exists'
            ],401);
        }
        if(Hash::check($password,$user->password)){
            return response([
                'success' => true,
                'message' => 'User Logged In Successfully',
                'user'    => $user
            ],200);
        }else{
            return response([
                'success' => false,
                'message' => 'User Not logged in Successfully'
            ],401);
        }
    }
    /**
     * Create User
     */
    public function createUser(Request $request){
        $username = $request->username;
        $email    = $request->email;
        $role     = 'user';
        $firstname = $request->firstname;
        $lastname  = $request->lastname;
        $password  = $request->password;
        $confirmPassword = $request->confirmPassword;
        if($password == $confirmPassword){
            $validator = Validator::make([
                'username' => $username,
                'email'    => $email,
                'password' => $password]
                ,[
                    'username' => 'required|unique:USERS',
                    'email'    => 'required|unique:USERS',
                    'password' => 'required|min:8'
            ]);
            if($validator->fails()){
                $errors = $validator->errors();
                $message = 'Error in request values <br>';
                foreach($errors->all() as $error){
                    $message .= $error . '<br>';
                }
                return response([
                    'success' => false,
                    'message' => $message
                ],401);
            }
            $user = User::create([
                'username' => $username,
                'password' => Hash::make($password),
                'firstname' => $firstname,
                'lastname'  => $lastname,
                'email'     => $email,
                'role'      => $role
            ]);
            return response([
                'success' => true,
                'message' => 'User Created Successfully',
                'user'    => $user
            ],200);
        }else{
            return response([
                'success' => false,
                'message' => 'Passwords do not match'
            ],401);
        }
    }
    /**
     * Forget Password of user
     */
    public function forgetPassword(Request $request){
        $username = $request->username;
        $email    = $request->email;
        $user     = User::where([
            ['username','=',$username],
            ['email','=',$email]
        ])->first();
        if($user == null){
            return response([
                'success' => false,
                'message' => 'Username,Email does not exist'
            ],401);
        }else{
            $status = Password::sendResetLink(
                $request->only('email')
            );
            return $status === Password::RESET_LINK_SENT
                            ? response([
                                'success' => true,
                                'message' => 'Reset Password Link Sent'
                            ],200)
                            : response([
                                'success' => false,
                                'message' => 'Reset Password Link Not Sent'
                            ],401); 
        }
    }
    /**
     * Reset Password for user
     */
    public function resetPassword(Request $request){
        return view('auth.reset-password',[
            'token' => $request->token,
            'email' => $request->email
        ]);
    }
    /**
     * Update Password for user
     */
    public function updatePassword(Request $request){
        $password = $request->password;
        $confirmPassword = $request->confirmPassword;
        if($password == $confirmPassword){
            return response([
                'success' => false,
                'message' => 'Passwords do not match'
            ],401);
        }else{
            $validator = Validator::make([
                'password' => $password
            ],[
                'password' => 'required|min:8'
            ]);
            if($validator->fails()){
                return response([
                    'success' => false,
                    'message' => 'Error in request values'
                ],401);
            }
            $user = User::where('email','=',$request->email)->first();
            $user->password = Hash::make($password);
            $user->save();
            return response([
                'success' => false,
                'message' => 'User Password changed successfully',
                'user'    => $user
            ]);
        }
    }
}
