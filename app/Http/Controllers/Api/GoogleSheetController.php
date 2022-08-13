<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\OrdersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GoogleSheetController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('affiliate-store');

        Excel::import(new OrdersImport, $request->file('excel'));

        return response(['message' => 'Successfully imported'], 200);
    }
}
