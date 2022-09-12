<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleStatisticController extends Controller
{
    public function statistic()
    {
        $this->authorize('role-index');

        $role = Role::withCount(['permissions', 'users'])
                    ->get()
        ;

        return response(['data' => $role], 200);
    }
}
