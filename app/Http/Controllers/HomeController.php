<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the user's search input

        // Perform a database query to search for bands by title or description
        $bands = Band::where('name', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->orderBy("created_at","desc")->get();

        return view('home', compact('bands'));
    }


}
