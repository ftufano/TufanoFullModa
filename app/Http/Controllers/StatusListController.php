<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Log;

class StatusListController extends Controller
{
    public function index() { //Function to show the backUsers info

        if(session()->has('userEmail')){ //if is a session active and such session has an 'userEmail' parameter
            
            if(session()->get('userType') == 'Administrador') {
                $statuses = Status::orderBy('created_at', 'asc')->get(); //fill the $statuses info with the Status model query of all statuses on the table
                return view('status_list')->withStatuses($statuses); //return the status_list view with the lists contained in $statuses

            }else{
                $statuses = Status::orderBy('created_at', 'asc')->get(); //fill the $statuses info with the Status model query of all statuses on the table
                return view('status_list')->withStatuses($statuses); //return the status_list view with the lists contained in $statuses
            }
        }
        return redirect('/'); //if there's no session or if it is it has not an 'userEmail' parameter, then redirect to the root page

    }

    public function store(Request $request) { //Function to create (store) a new status on the database, the request is for the status's info
        //that is meant to be stored

        try {//try the desired behavior
            
            $status = new Status; //filling the $status variable invoking the status model previously created
            $status->users_id       = session()->get('userID'); //getting on the 'status->user_id' position the session user ID value
            $status->name           = $request->name; // filling model name with typed name
            $status->save(); //method to insert the filled info into the database
            
            return redirect('status-list')->with('successMsg', 'Status'.$request->name.' registrado exitosamente'); //after insert the new status redirect to the root view
            //with a success message for the status insert

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'El status '.$request->name.' ya se encuentra registrado');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de agregar el status. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
        }
    }

    public function update(Request $request) { //Function to updatea new status on the database, the request is for the status's info
        //that is meant to be stored

        try { //try the desired behavior
            
            $status = Status::findOrFail($request->id); //filling the $status variable using the status model to find the status where the ID matches the $request->id
            $status->name           = $request->name; // filling model name with typed name
            $status->update(); //method to update the status's update on the database
            
            return redirect('status-list')->with('successMsg', '¡Status Editado!'); //return to the same view with a success message

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'El status '.$request->name.' ya se encuentra registrado');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de editar el estatus. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
            
        }

    }

    public function delete(Request $request) {//Fuction to delete an status, the request is for the status info
        //that is meant to be stored

        try {//try the desired behavior

            $status = Status::findOrFail($request->id); //filling the $status variable using the Status model to find the status where the ID matches the $request->id
            $status->delete(); //method to delete the status on the database
            return redirect('status-list')->with('successMsg', '¡Status Eliminado!'); //return to the same view with a success message
        
        } catch (\Exception $e) { //if an exception comes up, here is were we get it
            
            return back()->with('errorMsg', 'Hubo un error al momento de eliminar el status. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

        }

    }
}
