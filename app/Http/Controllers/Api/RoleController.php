<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	public function index()
	{
		$this->authorize('role-index');

		$roles = Role::select('id', 'name')->get();

		return response(['roles' => $roles], 200);
	}

	public function store(RoleStoreRequest $request)
	{
		$this->authorize('role-store');

		$data = $request->validated();

		$role = Role::create($data);

		$role->permissions()->attach($data['permissions']);

		return response(['message' => 'Role created successfully'], 200);
	}

	public function show(Request $request)
	{
		$this->authorize('role-show');

        $role = Role::where('id', $request->role)->select('id', 'name')->with('permissions:id,name,table_name')->get();

		return response(['role' => $role]);
	}

	public function update(RoleUpdateRequest $request, Role $role)
	{
		$this->authorize('role-update');

		$data = $request->validated();

        if($role->id != 1){

		    $role->update($data);

            $role->permissions()->detach();
            $role->permissions()->attach($data['permissions']);
        }else{
            return response(['message' => 'You can not update role']);
        }

		return response(['message' => 'Role updated successfully'], 200);
	}

	public function destroy(Role $role)
	{
		$this->authorize('role-destroy');

        if($role->id == 1 || $role->id == 2 || $role->id == 3 || $role->id == 4){
            return response(['message' => 'Role can not be deleted'], 200);
        }

		$role->delete();

		return response(['message' => 'Role deleted successfully'], 200);
	}

}
