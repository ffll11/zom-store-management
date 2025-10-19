<?php

namespace App\Repositories;

use App\Http\Resources\FamilyResource;
use App\Interfaces\BaseRepository;
use App\Models\Family;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FamilyRepository implements BaseRepository{

    public function all($request)
    {
        if(!Family::all()) {
            return "No families found";
        }

        return FamilyResource::collection(Family::all());
    }
    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $family = Family::find($id);
        if ($family) {
            return new FamilyResource($family);
        }
        return "Family not found";
    }
    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }
        return new FamilyResource(resource: Family::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $family = Family::find($id);
        if ($family) {
            $family->update($attributes);
            return new FamilyResource($family);
        }
        return "Family not found";
    }

    public function delete($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $family = Family::find($id);
        if ($family) {
            $family->delete();

            return "Family deleted successfully";
        }
        return "Family not found";
    }

}


