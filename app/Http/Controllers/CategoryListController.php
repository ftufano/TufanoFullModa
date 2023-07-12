<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryListController extends Controller
{
    public function index() { //Function to show the backUsers info

        if(session()->has('userEmail')){ //if is a session active and such session has an 'userEmail' parameter
            
            if(session()->get('userType') == 'Administrador') {
                $categories = Categories::orderBy('created_at', 'asc')->get(); //fill the $categories info with the Categories model query of all categories on the table
                return view('category_list')->withCategories($categories); //return the category_list view with the lists contained in $categories

            }else{
                $categories = Categories::orderBy('created_at', 'asc')->get(); //fill the $categories info with the Categories model query of all categories on the table
                return view('category_list')->withCategories($categories); //return the category_list view with the lists contained in $categories
            }
        }
        return redirect('/'); //if there's no session or if it is it has not an 'userEmail' parameter, then redirect to the root page

    }

    public function store(Request $request) { //Function to create (store) a new category on the database, the request is for the category's info
        //that is meant to be stored

        try {//try the desired behavior
            
            $category = new Categories; //filling the $category variable invoking the Category model previously created
            $category->users_id       = session()->get('userID'); //getting on the 'category->user_id' position the session user ID value
            $category->name           = $request->name; // filling model name with typed name
            $category->save(); //method to insert the filled info into the database
            
            return redirect('category-list')->with('successMsg', 'Categoría'.$request->name.' registrada exitosamente'); //after insert the new category redirect to the root view
            //with a success message for the category insert

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'La categoría '.$request->name.' ya se encuentra registrada');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de agregar la categoría. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
        }
    }

    public function update(Request $request) { //Function to updatea new category on the database, the request is for the category's info
        //that is meant to be stored

        try { //try the desired behavior
            
            $category = Categories::findOrFail($request->id); //filling the $category variable using the Category model to find the category where the ID matches the $request->id
            $category->name           = $request->name; // filling model name with typed name
            $category->update(); //method to update the category's update on the database
            
            return redirect('category-list')->with('successMsg', '¡Categoría Editada!'); //return to the same view with a success message

        } catch (\Exception $e) { //if an exception comes up, here is were we get it

            $errorCode = $e->errorInfo[1]; //if the exception was a SQL exception, here we get the error code

            if($errorCode == 1062){ //if the exception was a SQL exception and the error code is equal to 1062 value

                return back()->with('errorMsg', 'La categoría '.$request->name.' ya se encuentra registrada');
                //return an error message indicating that the email already exists
            
            }else{

                return back()->with('errorMsg', 'Hubo un error al momento de editar la categoría. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

            }
            
        }

    }

    public function delete(Request $request) {//Fuction to delete an category, the request is for the category info
        //that is meant to be stored

        try {//try the desired behavior

            $category = Categories::findOrFail($request->id); //filling the $category variable using the Category model to find the category where the ID matches the $request->id
            $category->delete(); //method to delete the category on the database
            return redirect('category-list')->with('successMsg', '¡Categoría Eliminada!'); //return to the same view with a success message
        
        } catch (\Exception $e) { //if an exception comes up, here is were we get it
            
            return back()->with('errorMsg', 'Hubo un error al momento de eliminar la categoría. 
                Revise la información colocada e intente nuevamente');
                //return an error message indicating that something went wrong

        }

    }
}
