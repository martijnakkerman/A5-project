<?php

namespace App\Http\Controllers\Band;

use App\Models\Embed;
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

        foreach ($request->youtube_url as $youtube_url) {
            $embed = Embed::create(['youtube_url' => $youtube_url, 'band_id' => $band->id]);
        $band->embeds()->save($embed);
    }
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
            'biography'=>'required|string',
            'image'=>'nullable|image|mimes:jpg,png',
            'text_color'=>'nullable|string',
            'background_color'=>'nullable|string',
        ]);
        $request_all = $request->all();
        if(!is_null($request->image)) {
            $uploadedfile = Storage::disk('public')->put("images", $request->image);
            $request_all['image_path'] = "images/".basename($uploadedfile);
        }
        $band->update($request_all);
        $band->users()->sync([(Auth::user()->id)]);
        $band->embeds()->delete();
        foreach ($request->youtube_url as $youtube_url) {
            $embed = Embed::create(['youtube_url' => $youtube_url, 'band_id' => $band->id]);
            $band->embeds()->save($embed);
        }
        $band->update($request->all());
        return redirect('/dashboard')
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
