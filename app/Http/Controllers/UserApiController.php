<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    //
    public function store(Request $request) { //Function to create (store) a new user on the database, the request is for the user info
        //that is meant to be stored

        try {//try the desired behavior
            
            $user = new User; //filling the $user variable invoking the User model previously created
            $user->name     = $request->name; //filling model name with typed name
            $user->email    = $request->email; // filling model email with typed email
            $user->phone    = $request->phone; // filling model phone with typed phone
            $user->password = Hash::make($request->password); // filling model password with typed password
            $user->type = $request->type; //filling model type with typed type
            $user->save(); //method to insert the filled info into the database
            
            return response()->json(['message'=> 'Usuario '.$request->email.' creado exitosamente'],201); //return an 201 OK response


        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return response()->json(['message'=> 'El E-Mail indicado ya se encuentra registrado'], 403);
                //return an error message indicating that the email already exists
            
            }else{

                return response()->json(['message'=> 'Hubo un error al momento de agregar el nuevo usuario. 
                Por favor intente nuevamente'],400);

            }

        }
    }
}
