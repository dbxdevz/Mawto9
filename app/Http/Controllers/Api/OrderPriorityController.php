<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderPriority;
use App\Models\PackageStatus;
use Illuminate\Http\Request;

class OrderPriorityController extends Controller
{
    public function index()
    {
        $priorities = OrderPriority::all();

        return response(['data' => $priorities], 200);
    }

    public function index2()
    {
        $priorities = PackageStatus::all();

        return response(['data' => $priorities], 200);
    }
}
