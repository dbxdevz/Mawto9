<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tva;
use Illuminate\Http\Request;

class TvaController extends Controller
{
    public function index()
    {
        $tvas = Tva::all();

        return response(['tvas' => $tvas], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tva' => ['numeric', 'required']
        ]);

        Tva::create([
            'tva' => $request->tva
        ]);

        return response(['message' => 'TVA created successfully'], 200);
    }

    public function show(Tva $tva)
    {
        return response(['tva' => $tva], 200);
    }

    public function update(Tva $tva, Request $request)
    {
        $request->validate([
            'tva' => ['numeric', 'required']
        ]);

        $tva->udate([
            'tva' => $request->tva
        ]);

        return response(['message' => 'Tva updated successfully'], 200);
    }

    public function destroy(Tva $tva)
    {
        $tva->delete();

        return response(['message' => 'Tva deleted successfully'], 200);
    }
}
