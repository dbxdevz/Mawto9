<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleStatisticController extends Controller
{
    public function statistic()
    {
        $role = Role::withCount(['permissions', 'users'])->get();

        return response(['data' => $role], 200);
    }
}
