<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$permissions = Permission::select('id', 'name', 'table_name')->get()->groupBy(function ($product) {
			return $product->table_name; // or whatever you can use as a key
		});

		return response(['permissions' => $permissions], 200);
	}
}
