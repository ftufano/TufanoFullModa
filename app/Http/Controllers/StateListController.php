<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\States;

class StateListController extends Controller
{
    public function index() { //Function to show the backUsers info

        if(session()->has('userEmail')){ //if is a session active and such session has an 'userEmail' parameter
            
            if(session()->get('userType') == 'Administrador') {
                $states = States::orderBy('created_at', 'asc')->get(); //fill the $states info with the States model query of all states on the table
                return view('state_list')->withStates($states); //return the state_list view with the lists contained in $states

            }else{
                $states = States::orderBy('created_at', 'asc')->get(); //fill the $states info with the States model query of all states on the table
                return view('state_list')->withStates($states); //return the state_list view with the lists contained in $states
            }
        }
        return redirect('/'); //if there's no session or if it is it has not an 'userEmail' parameter, then redirect to the root page

    }

    public function store(Request $request) { //Function to create (store) a new state on the database, the request is for the state's info
        //that is meant to be stored

        try {//try the desired behavior
            
            $state = new States; //filling the $state variable invoking the State model previously created
            $state->users_id       = session()->get('userID'); //getting on the 'state->user_id' position the session user ID value
            $state->name           = $request->name; // filling model name with typed name
            $state->save(); //method to insert the filled info into the database
            
            return redirect('state-list')->with('successMsg', 'Estado '.$request->name.' registrado exitosamente'); //after insert the new state redirect to the root view
            //with a success message for the state insert

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'El estado '.$request->name.' ya se encuentra registrado');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de agregar el estado. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
        }
    }

    public function update(Request $request) { //Function to updatea new state on the database, the request is for the state's info
        //that is meant to be stored

        try { //try the desired behavior
            
            $state = States::findOrFail($request->id); //filling the $state variable using the State model to find the state where the ID matches the $request->id
            $state->name           = $request->name; // filling model name with typed name
            $state->update(); //method to update the state's update on the database
            
            return redirect('state-list')->with('successMsg', '¡Estado Editado!'); //return to the same view with a success message

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'El estado '.$request->name.' ya se encuentra registrado');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de editar el estado. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
            
        }

    }

    public function delete(Request $request) {//Fuction to delete an state, the request is for the state info
        //that is meant to be stored

        try {//try the desired behavior

            $state = States::findOrFail($request->id); //filling the $state variable using the State model to find the state where the ID matches the $request->id
            $state->delete(); //method to delete the state on the database
            return redirect('state-list')->with('successMsg', '¡Estado Eliminado!'); //return to the same view with a success message
        
        } catch (\Exception $e) { //if an exception comes up, here is were we get it
            
            return back()->with('errorMsg', 'Hubo un error al momento de eliminar el estado. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

        }

    }
}
