<?php

namespace App\Repositories;

use App\Http\Resources\RoleResource;
use App\Interfaces\BaseRepository;
use App\Models\Role;

class RoleRepository implements BaseRepository
{
    public function all($request)
    {

        if(!Role::all()) {
            return "No roles found";
        }

        return RoleResource::collection(Role::all());
    }

    public function find($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return "Role not found";
        }
        return new RoleResource($role);
    }

    public function create(array $data)
    {
        $role = Role::create($data);
        return new RoleResource($role);
    }

    public function update($id, array $data)
    {
        $role = Role::find($id);
        if (!$role) {
            return "Role not found";
        }
        $role->update($data);
        return new RoleResource($role);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return "Role not found";
        }
        $role->delete();
        return response()->json(null, 204);
    }
    
}
