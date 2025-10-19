<?php

namespace App\Repositories;
use App\Models\User;
use App\Interfaces\BaseRepository;
use App\Http\Resources\UserResource;

class UserRepository implements BaseRepository
{
    public function all($request)
    {
        if(!User::all()) {

            return "No users found";
        }

        return UserResource::collection(User::all());
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $user = User::find($id);
        if ($user) {
            return new UserResource($user);
        }
        return "User not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new UserResource(resource: User::create($attributes));
    }
    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $user = User::find($id);
        if ($user) {
            $user->update($attributes);
            return new UserResource($user);
        }
        return "User not found";
    }
    public function delete($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(null, 204);
        }
        return "User not found";
    }
}
