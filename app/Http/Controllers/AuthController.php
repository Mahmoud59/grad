<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Crypt;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    public function register($name,$email,$password)
    {
        $existingUser=User::where('email',$email)->get();

        if(count($existingUser) > 0)
        {
          return response()->json([
              'status_code' => 406,
              'success' => false,
              'message' => 'This user has registered before',
              'error' => null,
              'data' => null,
          ]);
        }

        $newUser=new User;
        $newUser->name=$name;
        $newUser->email=$email;
        $newUser->password = Hash::make($password);
        // $newUser->latitude=$request->latitude;
        // $newUser->longitude=$request->longitude;

        $result = $newUser->save();

        if (!$result) {
            return response()->json([
                'status_code' => 500,
                'success' => false,
                'message' => 'Failed Registration',
                'error' => null,
                'data' => null
            ]);
        }
        else
        {        
            return response()->json([
                'status_code' => 201,
                'success' => true,
                'message' => 'User Registered Successfully',
                'error' => null,
                'data'  => $newUser
            ]);
        }

    }
        
    public function login($email,$password)
    {
        $email = $email;
        $password = $password;
        $check = User::where('email',$email)->orWhere('password',$password)->first();
        if($check)
        {
            return response()->json([
                            'status_code' => 200,
                            'success' => true,
                            'message' => 'user logged in successfully',
                            'error' => null,
                            'data'  => $check
                    ]);
        }
        return response()->json([
                            'status_code' => 500,
                            'success' => false,
                            'message' => 'user logged in failed',
                            'error' => null,
                            'data'  => null,
                    ]);
    }

    public function logout(Request $request) {
       Auth::logout();
       return response()->json([
                            'status_code' => 200,
                            'success' => true,
                            'message' => 'user logout ',
                            'error' => null,
                            'data'  => null,
                    ]);
    }

}