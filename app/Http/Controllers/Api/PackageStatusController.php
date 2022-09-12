<?php

namespace App\Http\Controllers;

use App\Models\PackageStatus;

class PackageStatusController extends Controller
{
    public function index()
    {
        $data = PackageStatus::all();

        return response(['data' => $data], 200);
    }
}
