<?php

namespace App\Http\Controllers;

use App\Models\PackageStatus;
use Illuminate\Http\Request;

class PackageStatusController extends Controller
{
    public function index()
    {
        $data = PackageStatus::all();

        return response(['data' => $data], 200);
    }
}
