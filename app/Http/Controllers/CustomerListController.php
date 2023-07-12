<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Categories;
use App\Models\Status;
use App\Models\States;
use App\Models\Zones;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CustomerListController extends Controller
{
    public function index() { //Function to show the backUsers info

        if(session()->has('userEmail')){ //if is a session active and such session has an 'userEmail' parameter
            
            if(session()->get('userType') == 'Administrador') {
                $customers = Customers::orderBy('created_at', 'asc')->get(); //fill the $customers info with the Customers model query of all customers on the table
                $states = States::orderBy('created_at', 'asc')->get(); //get the states list info
                $categories = Categories::orderBy('created_at', 'asc')->get(); //get the states list info
                $statuses = Status::orderBy('created_at', 'asc')->get(); //get the states list info

                foreach($customers as $customer) {

                    $category = Categories::join('customers', 'customers.categories_id', '=', 'categories.id')
                                        ->where('customers.id', $customer->id)
                                        ->get(['categories.id', 'categories.name']);
                    
                    $status = Status::join('customers', 'customers.status_id', '=', 'status.id')
                                        ->where('customers.id', $customer->id)
                                        ->get(['status.id', 'status.name']);

                    $state = States::join('customers', 'customers.states_id', '=', 'states.id')
                                        ->where('customers.id', $customer->id)
                                        ->get(['states.id', 'states.name']);

                    $zone = Zones::join('customers', 'customers.zones_id', '=', 'zones.id')
                                        ->where('customers.id', $customer->id)
                                        ->get(['zones.id', 'zones.name']);          

                    $customer->category_id = $category[0]->id;
                    $customer->category_name = $category[0]->name;
                    $customer->status_id = $status[0]->id;
                    $customer->status_name = $status[0]->name;
                    $customer->state_id = $state[0]->id;
                    $customer->state_name = $state[0]->name;
                    $customer->zone_id = $zone[0]->id;
                    $customer->zone_name = $zone[0]->name;

                }

                return view('customer_list')->withCustomers($customers)->withStates($states)->withCategories($categories)->withStatuses($statuses); //return the customer_list view with the lists contained in $customers

            }else{
                $customers = Customers::orderBy('created_at', 'asc')->get(); //fill the $customers info with the Customers model query of all customers on the table
                $states = States::orderBy('created_at', 'asc')->get(); //get the states list info
                $categories = Categories::orderBy('created_at', 'asc')->get(); //get the states list info
                $statuses = Status::orderBy('created_at', 'asc')->get(); //get the states list info
                return view('customer_list')->withCustomers($customers)->withStates($states)->withCategories($categories)->withStatuses($statuses); //return the customer_list view with the lists contained in $customers
            }
        }
        return redirect('/'); //if there's no session or if it is it has not an 'userEmail' parameter, then redirect to the root page

    }

    public function indexZonesByState(Request $request) {

        try {

            $statesID = $request->state_id;        
            $zones = Zones::join('zones_has_states', 'zones_has_states.zones_id', '=', 'zones.id')
                                        ->join('states', 'states.id', '=', 'zones_has_states.states_id')
                                        ->where('zones_has_states.states_id', $statesID)
                                        ->get(['zones.id', 'zones.name']);
    
            return response()->json(['message'=> $zones],200);
            
        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            return response()->json(['message'=> 'Hubo un error al momento de obtener las zonas. 
            Por favor intente nuevamente'],400);

        }


    }

    public function indexSellersByZone(Request $request) {

        try {

            $zonesID = $request->zone_id;

            $sellers = User::join('zones', 'zones.seller_users_id', '=', 'users.id')
                                    ->where('zones.id', $zonesID)
                                    ->get(['users.id as seller_id', 'users.name as seller_name']);

             return response()->json(['message'=> $sellers],200);

        } catch (\Exception $e) {

            Log::debug($e);
            
            return response()->json(['message'=> 'Hubo un error al momento de obtener los vendedores. 
            Por favor intente nuevamente'],400);

        }

    }

    public function store(Request $request) { //Function to create (store) a new customer on the database, the request is for the customer's info
        //that is meant to be stored

        try {//try the desired behavior
            
            $customer = new Customers; //filling the $customer variable invoking the Customer model previously created
            $customer->users_id       = session()->get('userID'); //getting on the 'customer->user_id' position the session user ID value
            $customer->identification = $request->identification; //filling model identification with typed identification
            $customer->name           = $request->name; // filling model name with typed name
            $customer->address        = $request->address; // filling model address with typed address
            $customer->phone          = $request->phone; // filling model phone with typed phone
            $customer->states_id      = $request->state; //filling model state with typed state
            $customer->zones_id       = $request->zone; //filling model zone with typed zone
            $customer->categories_id  = $request->category; //filling model category with typed category
            $customer->status_id      = $request->status; //filling model status with typed status
            $customer->save(); //method to insert the filled info into the database
            
            return redirect('customer-list')->with('successMsg', 'Cliente '.$request->name.' creado exitosamente'); //after insert the new customer redirect to the root view
            //with a success message for the customer insert

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'La Identificación (RIF, C. I., etc) indicada ya se encuentra registrada');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de agregar el cliente. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
        }
    }

    public function update(Request $request) { //Function to updatea new customer on the database, the request is for the customer's info
        //that is meant to be stored

        try { //try the desired behavior
            
            $customer = Customers::findOrFail($request->id); //filling the $customer variable using the Customer model to find the customer where the ID matches the $request->id
            $customer->users_id       = session()->get('userID'); //getting on the 'customer->user_id' position the session user ID value
            $customer->identification = $request->identification; //filling model identification with typed identification
            $customer->name           = $request->name; // filling model name with typed name
            $customer->address        = $request->address; // filling model address with typed address
            $customer->phone          = $request->phone; // filling model phone with typed phone
            $customer->states_id      = $request->state; //filling model state with typed state
            $customer->zones_id       = $request->zone; //filling model zone with typed zone
            $customer->categories_id  = $request->category; //filling model category with typed category
            $customer->status_id      = $request->status; //filling model status with typed status
            $customer->update(); //method to update the customer's update on the database
            
            return redirect('customer-list')->with('successMsg', '¡Cliente Editado!'); //return to the same view with a success message

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'La Identificación (RIF, C. I., etc) indicada ya se encuentra registrada, No se puede editar el cliente deseado');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de editar el cliente. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
            
        }

    }

    public function delete(Request $request) {//Fuction to delete an customer, the request is for the customer info
        //that is meant to be stored

        try {//try the desired behavior

            $customer = Customers::findOrFail($request->id); //filling the $customer variable using the Customer model to find the customer where the ID matches the $request->id
            $customer->delete(); //method to delete the customer on the database
            return redirect('customer-list')->with('successMsg', '¡Cliente Eliminado!'); //return to the same view with a success message
        
        } catch (\Exception $e) { //if an exception comes up, here is were we get it
            
            return back()->with('errorMsg', 'Hubo un error al momento de eliminar el cliente. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

        }

    }
}
