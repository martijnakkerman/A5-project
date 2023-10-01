<?php

namespace App\Http\Controllers\Band;
use App\Models\Band;
use App\Http\Controllers\Controller;

class BandDetailsController extends Controller {
    public function index(Band $band) {

        return view("band.band-details",compact("band"));

    }
}
