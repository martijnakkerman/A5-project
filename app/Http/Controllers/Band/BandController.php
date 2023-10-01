<?php

namespace App\Http\Controllers\Band;

use App\Http\Requests\ValidateBandRequest;
use App\Models\Embed;
use App\Models\Band;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class BandController extends Controller
{
    public function create()
    {
        $band = new Band();
        return view("band.edit",compact("band"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidateBandRequest $request)
    {
        $uploadedfile = Storage::disk('public')->put("images", $request->image);
        $request_all = $request->all();
        $request_all['image_path'] = "images/".basename($uploadedfile);
        $band = Band::create($request_all);
        $band->users()->sync([(Auth::user()->id)]);

        foreach ($request->embed_url as $embed_url) {
            $embed = Embed::create(['embed_url' => $embed_url, 'band_id' => $band->id]);
        $band->embeds()->save($embed);
    }
        return redirect('/dashboard')
            ->with('success', 'Band: '.$band->name.' was succesfully created.');
    }

    public function edit(Band $band)
    {
        return view("band.edit",compact("band"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidateBandRequest $request, Band $band)
    {
        $request_all = $request->all();
        if(!is_null($request->image)) {
            $uploadedfile = Storage::disk('public')->put("images", $request->image);
            $request_all['image_path'] = "images/".basename($uploadedfile);
        }
        $band->update($request_all);
        $band->users()->sync([(Auth::user()->id)]);
        $band->embeds()->delete();

        foreach ($request->embed_url as $embed_url) {
            $embed = Embed::create(['embed_url' => $embed_url, 'band_id' => $band->id]);
            $band->embeds()->save($embed);
        }

        $band->update($request->all());
        return redirect('/dashboard')
            ->with('success', 'Band information updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        $bandname = $band->name;

        if (Storage::disk('public')->exists($band->image_path)) {

            Storage::disk('public')->delete($band->image_path);
        } else {
            dd("file not found");
        }

        $band->users()->detach();
        $band->embeds()->delete();
        $band->delete();
        return redirect("/dashboard")
            ->with('success', 'Your band: '.$bandname.' has been deleted.');
    }
}
