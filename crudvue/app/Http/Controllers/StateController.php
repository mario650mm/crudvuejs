<?php

namespace App\Http\Controllers;


use App\State;

class StateController extends Controller
{
    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id',$countryId)->get(['id','name']);
        return $states->toJson();
    }
}
