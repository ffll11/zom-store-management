<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userRepository;

    protected $productRepository;

    protected $roleRepository;

    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, RoleRepository $roleRepository)
    {
        $this->middleware('can:access-admin');

        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        return $this->userRepository->all($request);
    }

    public function show(Request $request, $id)
    {
        return $this->userRepository->find($id);
    }

    public function create(Request $request)
    {
        return $this->userRepository->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->userRepository->update($id, $request->all());
    }

    public function delete(Request $request, $id)

    {
        $this->authorize('delete', User::class);

        return $this->userRepository->delete($id);
    }

}
