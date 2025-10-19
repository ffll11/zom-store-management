<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        return $this->userRepository->all($request);
    }

    public function store(Request $request)
    {
        return $this->userRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->userRepository->find($id);
    }

    public function update($id, Request $request)
    {
        return $this->userRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }
    
}
