<?php
namespace App\Repositories;

use App\Interfaces\BaseRepository;
use App\Http\Resources\SubfamilyResource;
use App\Models\Subfamily;

class SubfamilyRepository implements BaseRepository
{
    public function all($request)
    {
        if(!Subfamily::all()) {
            return "No subfamilies found";
        }

        return SubfamilyResource::collection(Subfamily::all());
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $subfamily = Subfamily::find($id);
        if ($subfamily) {
            return new SubfamilyResource($subfamily);
        }
        return "Subfamily not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new SubfamilyResource(resource: Subfamily::create($attributes));
    }
    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $subfamily = Subfamily::find($id);
        if ($subfamily) {
            $subfamily->update($attributes);
            return new SubfamilyResource($subfamily);
        }
        return "Subfamily not found";
    }
    public function delete($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $subfamily = Subfamily::find($id);
        if ($subfamily) {
            $subfamily->delete();

            return "Subfamily deleted successfully";
        }
        return "Subfamily not found";
    }
}
