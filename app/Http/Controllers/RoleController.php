<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        return $this->roleRepository->all($request);
    }

    public function store(StoreRoleRequest $request)
    {
        return $this->roleRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->roleRepository->find($id);
    }

    public function update($id, UpdateRoleRequest $request)
    {
        return $this->roleRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->roleRepository->delete($id);
    }
}
