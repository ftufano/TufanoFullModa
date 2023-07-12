<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    public function index() { //Function to show the sellers info

        if(session()->get('userType') == 'Administrador'){ //if is a session active and such session has an 'userType' parameter as Administrador
            
            $sellers = User::where('user_type', 'Vendedor')->orderBy('created_at', 'asc')->get(); //get the sellers list info
            return view('seller_list')->withSellers($sellers); //return the seller_list view with the sellers contained in $sellers

        }
        return redirect('/'); //if there's no session or if it is it has not an 'userEmail' parameter, then redirect to the root page

    }
}
