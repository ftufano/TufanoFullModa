<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zones;
use App\Models\User;
use App\Models\States;
use App\Models\ZonesHasStates;
use Illuminate\Support\Facades\Log;

class ZoneController extends Controller
{
    public function index() { //Function to show the zones info

        if(session()->get('userType') == 'Administrador'){ //if is a session active and such session has an 'userType' parameter as Administrador
            
            $zones = Zones::join('users', 'users.id', '=', 'zones.seller_users_id')
                            ->get(['zones.*', 'users.id as seller_id', 'users.name as seller_name']);

            foreach($zones as $zone) {

                $zoneStates = States::join('zones_has_states', 'zones_has_states.states_id', '=', 'states.id')
                                    ->join('zones', 'zones.id', '=', 'zones_has_states.zones_id')
                                    ->where('zones_has_states.zones_id', $zone->id)
                                    ->get(['states.id', 'states.name']);

                    $zone->zone_states = $zoneStates;
            }

            $sellers = User::where('user_type', 'Vendedor')->orderBy('created_at', 'asc')->get(); //get the sellers list info
            $states = States::orderBy('created_at', 'asc')->get(); //get the states list info
            return view('zone_list')->withZones($zones)->withSellers($sellers)->withStates($states); //return the zone_list view with the zones contained in $zones

        }
        return redirect('/'); //if there's no session or if it is it has not an 'userEmail' parameter, then redirect to the root page

    }

    public function store(Request $request) { //Function to create (store) a new zone on the database, the request is for the zone info
        //that is meant to be stored

        try {//try the desired behavior
            
            $zone = new Zones; //filling the $zone variable invoking the Zone model previously created
            $zone->users_id           = session()->get('userID'); //getting on the 'zone->user_id' position the session user ID value
            $zone->name               = $request->name; //filling model name with typed name
            $zone->seller_users_id    = $request->seller; // filling model seller with typed seller
            $zone->save(); //method to insert the filled info into the database

            $zoneID = Zones::orderBy('id', 'desc')->first()->id; //get the last zone ID from DB

            foreach($request->states as $state) { //loop to save each state selected to the zone created

                $zoneHasState = new ZonesHasStates;
                $zoneHasState->zones_id = $zoneID;
                $zoneHasState->states_id = $state;
                $zoneHasState->save();

            }
            
            return back()->with('successMsg', 'Zona '.$request->name. ' creada exitosamente'); //after insert the new user redirect to the root view
            //with a success message for the user insert

        } catch (\Exception $e) { //if an exception comes up, here is were we get it
            return back()->with('errorMsg', 'Hubo un error al momento de agregar la zona. 
            Revise la información colocada e intente nuevamente'); //returns to the same view but no insert has been done
        }
    }

    public function update(Request $request) { //Function to update any user's info, the request is for the user info
        //that is meant to be stored
        
        try { //try the desired behavior
            
            $zone = Zones::findOrFail($request->id); //filling the $user variable using the User model to find the user where the ID matches the $request->id

            if ($request->name != $zone->name) {

                $zone->name = $request->name; //filling model name with typed name
                $zone->update();

            }

            if ($request->seller != $zone->seller_users_id) {

                $zone->seller_users_id = $request->seller; // filling model seller with typed seller
                $zone->update();

            }

            $zoneHasState = ZonesHasStates::where('zones_id', $request->id)->get(); //filling the $user variable using the User model to find the user where the ID matches the $request->id

            foreach($zoneHasState as $initZoneHasState) { // for each loop to compare both arrays values
                $comparable = $initZoneHasState->states_id; //saving in a variable the current position value in order to be compared with the final id index array positions

                if(in_array($comparable, $request->states) != true) { //if the value is not found on the final id array then...
                   $deleteZoneState = ZonesHasStates::where('states_id', $comparable); //find the item in the DB by the id value that is not on the final id array
                   $deleteZoneState->delete(); //delete the item
                }
            }

            $zoneHasState = ZonesHasStates::where('zones_id', $request->id)->get(); //filling the $user variable using the User model to find the user where the ID matches the $request->id

            $dbStates = []; //initializing the final id index array

            foreach($zoneHasState as $dbZone) {

                $dbStates[] = $dbZone->states_id;

            }

            foreach($request->states as $initZoneHasState) { // for each loop to compare both arrays values
                $comparable = $initZoneHasState; //saving in a variable the current position value in order to be compared with the final id index array positions

                if(in_array($comparable, $dbStates) != true) { //if the value is not found on the final id array then...
                    $zoneHasState = new ZonesHasStates;
                    $zoneHasState->zones_id = $request->id;
                    $zoneHasState->states_id = $comparable;
                    $zoneHasState->save();
                }
            }            

            $zone->users_id = session()->get('userID'); //getting on the 'zone->user_id' position the session user ID value            
            $zone->update(); //method to update the user's update on the database
            
            return back()->with('successMsg', 'Zona '.$request->name. ' Editada!'); //return to the same view with a success message

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            return back()->with('errorMsg', 'Hubo un error al momento de editar la zona. 
            Revise la información colocada e intente nuevamente'); //returns to the same view but no update has been done
            
        }
    }

    public function delete(Request $request) { //Fuction to delete an user, the request is for the user info
        //that is meant to be stored

        try {//try the desired behavior

            $deleteZoneStates = ZonesHasStates::where('zones_id', $request->id); //find the item in the DB by the id value that is not on the final id array
            $deleteZoneStates->delete(); //delete the item

            $zone = Zones::findOrFail($request->id); //filling the $user variable using the User model to find the user where the ID matches the $request->id
            $zone->delete(); //method to delete the user on the database
            return back()->with('successMsg', '¡Zona '.$zone->name.' eliminada!'); //return to the same view with a success message
        
        } catch (\Exception $e) { //if an exception comes up, here is were we get it
            Log::debug($e);
            
            return back()->with('errorMsg', 'Hubo un error al momento de eliminar la zona. 
            Revise la información colocada e intente nuevamente'); //returns to the same view but no dalete has been done

        }
    }

}
