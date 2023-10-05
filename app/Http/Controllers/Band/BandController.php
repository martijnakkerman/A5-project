<?php

namespace App\Http\Controllers\Band;

use App\Http\Requests\ValidateBandRequest;
use App\Models\Embed;
use App\Models\Band;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class BandController extends Controller
{
    public function create()
    {
        $users = User::all();
        $band = new Band();
        return view("band.edit",compact("band","users"));

    }

    public function store(ValidateBandRequest $request)
    {
        $uploadedfile = Storage::disk('public')->put("images", $request->image);
        $request_all = $request->all();
        $request_all['image_path'] = "images/".basename($uploadedfile);
        $band = Band::create($request_all);
        $band->users()->sync($request->users);

        foreach ($request->embed_url as $embed_url) {
            $embed = Embed::create(['embed_url' => $embed_url, 'band_id' => $band->id]);
        $band->embeds()->save($embed);
    }
        return redirect('/dashboard')
            ->with('success', 'Band: '.$band->name.' was successfully created.');
    }

    public function edit(Band $band)
    {
        $users = User::all();
        return view("band.edit",compact("band","users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidateBandRequest $request, Band $band)
    {
        \Log::info("started update");
        try {
            $request_all = $request->all();
            if (!is_null($request->image)) {
                if (Storage::disk('public')->exists($band->image_path)) {
                    Storage::disk('public')->delete($band->image_path);
                }

                $uploadedfile = Storage::disk('public')->put("images", $request->image);
                $request_all['image_path'] = "images/" . basename($uploadedfile);
            }

            $band->update($request_all);
            $band->users()->sync($request->users);
            $band->embeds()->delete();

            foreach ($request->embed_url as $embed_url) {
                $embed = Embed::create(['embed_url' => $embed_url, 'band_id' => $band->id]);
                $band->embeds()->save($embed);
            }
        } catch(\Exception $e) {
            \Log::error($e);
        }

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
        }

        $band->users()->detach();
        $band->embeds()->delete();
        $band->delete();

        return redirect("/dashboard")
            ->with('success', 'Your band: '.$bandname.' has been deleted.');
    }
}
