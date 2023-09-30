<?php

namespace App\Http\Controllers\Band;

use App\Models\Band;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $band = new Band();
        return view("band.edit",compact("band"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'biography'=>'required|string',
            'image'=>'required|image|mimes:jpg,png',
            'text_color'=>'nullable|string',
            'background_color'=>'nullable|string',
        ]);

        $uploadedfile = Storage::disk('public')->put("images", $request->image);
        $request_all = $request->all();
        $request_all['image_path'] = "images/".basename($uploadedfile);
        $band = Band::create($request_all);
        $band->users()->sync([(Auth::user()->id)]);
        return redirect('/dashboard')
            ->with('success', 'Band information updated');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Band $band)
    {
        return view("band.edit",compact("band"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Band $band)
    {
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'Biography'=>'required|string',
            'image_path'=>'required',
            'text_color'=>'nullable|string',
            'background_color'=>'nullable|string',
        ]);

        $band->update($request->all());
        return redirect('/band/edit')
            ->with('success', 'Band information updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        $bandname = $band->name;
        $band->users()->detach();
        $band->delete();
        return redirect("/dashboard")
            ->with('success', 'Your band: '.$bandname.' has been deleted');
    }
}
