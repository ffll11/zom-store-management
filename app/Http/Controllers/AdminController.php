<?php

namespace App\Http\Controllers;

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
    public function __construct(UserRepository $userRepository ,ProductRepository $productRepository ,RoleRepository $roleRepository)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->roleRepository = $roleRepository;
    }


    public function getUsers( Request $request)
    {
        return $this->userRepository->all($request);
    }

    public function createUser(Request $request)
    {
        return $this->userRepository->create($request->all());
    }

    public function updateUser(Request $request, $id)
    {
        return $this->userRepository->update($id, $request->all());
    }

    public function deleteUser(Request $request, $id)
    {
        return $this->userRepository->delete($id);
    }

    public function getAllProducts(Request $request)
    {
        return $this->productRepository->all($request);
    }

}
