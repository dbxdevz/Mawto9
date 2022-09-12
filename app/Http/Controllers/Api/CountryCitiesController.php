<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryCitiesController extends Controller
{
    public function country(Request $request)
    {
        $countries = Country::where('name', 'LIKE', "%$request->name%")
                            ->with(['City:id,name,country_id'])
                            ->get()
        ;

        return response($countries, 200);
    }
}
