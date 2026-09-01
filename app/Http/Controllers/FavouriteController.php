<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listings=$request->user()->favourites()->paginate(10);
        return view('favourites.index',compact('listings'));
    }


    public function toggle(Request $request, Listing $listing){
        $request->user()->favourites()->toggle($listing->id);

        return back()->with('success',"Favourite's list updated");
    }

}
