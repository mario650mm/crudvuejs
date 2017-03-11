<?php

namespace App\Http\Controllers;

use App\City;

class CityController extends Controller
{
    public function getCitysByState($stateId)
    {
        $citys = City::where('state_id',$stateId)->get(['id','name']);
        return $citys->toJson();
    }
}
