<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginController extends Controller
{
    //
    public function loginFunction(Request $request){ //Function to login into the user's account, the request is for the email address and the password

        try{ //try the desired behavior

            $user = User::where('email', '=', $request->email)->firstOrFail();//filling the $user variable with the MySQL query result
            //getting the user info where the email matches with the typed email

            if (!Hash::check($request->password, $user->password)){ //if the Hashed check value between the typed password and the database password
                // does not match

                return back()->with(['wrongCredentials'=>'Usuario o contraseña incorrecta,
                 por favor verfique e intente nuevamente', 'currentEmail'=>$request->email, 'currentPassword'=>$request->password]);
                 //return an error message indicating that the typed credentials are wrong, and sending the email and password values obtained from the users
                 //as parameters to set them back on the input field so the users can recheck them

            }else{ //if the hashed check value matches

                Auth::login($user, $request->filled('remember'));

                $request->session()->put(['userID'=>$user->id,'userEmail'=>$user->email, 'userName'=>$user->name, 'userPhone'=>$user->phone, 'userType'=>$user->user_type]);
                //create a new session and putting as session values the user's email, name and type

                return redirect('customer-list'); //after create the session redirect to the new-order route
                
            }

        }catch (\Exception $e){ //if an exception comes up, here is were we get it
            
            return back()->with(['wrongCredentials'=>'Usuario o contraseña incorrecta,
             por favor verfique e intente nuevamente', 'currentEmail'=>$request->email, 'currentPassword'=>$request->password]);
             //return an error message indicating that the typed credentials are wrong, and sending the email and password values obtained from the users
             //as parameters to set them back on the input field so the users can recheck them

        }

    }
}
